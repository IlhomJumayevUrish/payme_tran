<?php

namespace App\Models\Api\Payme;

use App\Models\Api\Order;
use App\Models\Api\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Bills;
use App\Models\Api\Payme\PaymeData;

class OrderTransaction extends Model
{
    use HasFactory;
    protected $table='payme_transactions';
    protected $guarded=[];

    public static function CheckPerformTransaction($id, $amount, $order_id)
    {
        if($order_id == null) {
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -32504,
                    'message' => "Ошибки связанные с неверным пользовательским вводом “account“. Например: введённый логин не найден, введённый номер телефона не найден и т.д."
                ]
            ];
        }

        $order = Order::find($order_id);
        if($order == null) {
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -31050,
                    'message' => "Ошибки связанные с неверным пользовательским вводом “account“. Например: введённый логин не найден, введённый номер телефона не найден и т.д."
                ]
            ];
        }

        if ($order->state == 2){
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -31050,
                    'message' => "Ошибки связанные с неверным пользовательским вводом “account“. Например: введённый логин не найден, введённый номер телефона не найден и т.д."
                ]
            ];
        }

        $setting = new PaymeData();
        if(($amount < $setting->order_min_amount || $amount > $setting->order_max_amount) or ($order->amount * 100) != $amount) {
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -31001,
                    'message' => "Неверная сумма."
                ]
            ];
        }

        return ['result' => ['allow' => true],'error' => null];
    }

    public static function CreateTransaction($id, $param_id, $time, $amount, $order_id)
    {
        $transaction = OrderTransaction::where('order_id', $order_id)->where('state', 1)->first();

        if($transaction == null){
            $checkPerformTransaction = OrderTransaction::CheckPerformTransaction($id, $amount, $order_id);
            if(isset($checkPerformTransaction['result']['allow'])){

                $bill = new Bills();
                $bill->user_id = $order_id;
                $bill->amount = $amount / 100;
                $bill->status = 'created';
                $bill->type = 'order';
                $bill->psystem = 'Payme';
                $bill->description = 'Заказ оплачивается через Payme';
                $bill->save();

                $transaction = new OrderTransaction();
                $create_time                        = round(microtime(true) * 1000);
                $transaction->paycom_transaction_id = (string)$id;
                $transaction->param_id              = (string)$param_id;
                $transaction->paycom_time           = (string)$time;
                $transaction->paycom_time_datetime  = PaymeData::timestamp2datetime($time);
                $transaction->create_time           = PaymeData::timestamp2datetime($create_time);
                $transaction->state                 = PaymeData::STATE_CREATED;
                $transaction->amount                = $amount;
                $transaction->order_id              = $order_id;
                $transaction->save(); // after save $transaction->id will be populated with the newly created transaction's id.

                $bill->update(['transaction_id' => $transaction->id]);

                $order = Order::find($order_id);
                $order->state = PaymeData::STATE_CREATED;
                $order->save();

                return [
                    'result' => [
                        'create_time' => PaymeData::datetime2timestamp($transaction->create_time),
                        'transaction' => (string)$transaction->paycom_transaction_id,
                        'state'       => $transaction->state,
                        'receivers'   => null,
                    ]
                ];
            }
            else{
                return $checkPerformTransaction;
            }
        }else{
            if($transaction->state == PaymeData::STATE_CREATED){
                if ($time==$transaction->paycom_time){
                    return [
                        'result' => [
                            'create_time' => PaymeData::datetime2timestamp($transaction->create_time),
                            'transaction' => (string)$transaction->paycom_transaction_id,
                            'state'       => $transaction->state,
                            'receivers'   => null,
                        ]
                    ];
                } else {
                    return [
                        'jsonrpc' => "2.0",
                        'error' => [
                            'code' => -31050,
                            'message' => "Ошибки связанные с неверным пользовательским вводом “account“. Например: введённый логин не найден, введённый номер телефона не найден и т.д."
                        ]
                    ];
                }

            }else{
                return [
                    'jsonrpc' => "2.0",
                    'error' => [
                        'code' => -31008,
                        'message' => "Невозможно выполнить операцию."
                    ]
                ];
            }
        }
    }

    public static function PerformTransaction($id, $param_id)
    {
        $transaction = OrderTransaction::where(['param_id' => $param_id])->first();
        if($transaction == null){
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ]
            ];
        }
        else{
            if($transaction->state == PaymeData::STATE_CREATED){
                /*timeoutga tekwirish kerak*/
                if( false ){
                    $transaction->state = PaymeData::STATE_CANCELLED;
                    $transaction->reason = PaymeData::REASON_CANCELLED_BY_TIMEOUT;
                    $transaction->save();
                    return [
                        'jsonrpc' => "2.0",
                        'error' => [
                            'code' => -31008,
                            'message' => "Невозможно выполнить операцию."
                        ]
                    ];
                }
                else{
                    $bill = Bills::where('transaction_id', $transaction->id)->where('type','order')->where('psystem', 'Payme')->where('status', 'created')->first();
                    $bill->status = 'completed';
                    $bill->date_pay = date('Y-m-d H:i:s');
                    $bill->save();

                    $order = Order::find($transaction->order_id);
                    $order->state = PaymeData::STATE_COMPLETED;
                    $order->change_state = date('Y-m-d H:i:s');
                    $order->save();

                    $transaction->state = PaymeData::STATE_COMPLETED;
                    $transaction->perform_time = (string)round(microtime(true) * 1000);
                    $transaction->save();

                    return [
                        'result' => [
                            'perform_time' => (integer)$transaction->perform_time,
                            'transaction' => $transaction->paycom_transaction_id,
                            'state' => $transaction->state,
                        ]
                    ];
                }
            }
            else{
                if($transaction->state == PaymeData::STATE_COMPLETED){
                    return [
                        'result' => [
                            'perform_time' => (integer)$transaction->perform_time,
                            'transaction' => $transaction->paycom_transaction_id,
                            'state' => $transaction->state,
                        ]
                    ];
                }
                else{
                    return [
                        'jsonrpc' => "2.0",
                        'error' => [
                            'code' => -31008,
                            'message' => "Невозможно выполнить операцию."
                        ]
                    ];
                }
            }
        }
    }

    public static function CheckTransaction($id, $param_id)
    {
        $transaction = OrderTransaction::where(['param_id' => $param_id])->first();
        if($transaction == null){
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ]
            ];
        }

        return [
            'result' => [
                'create_time' => OrderTransaction::datetime2timestamp($transaction->create_time),
                'perform_time' => (integer)$transaction->perform_time,
                'cancel_time' => (integer)$transaction->cancel_time,
                'transaction' => $transaction->paycom_transaction_id,
                'state' => $transaction->state,
                'reason' => $transaction->reason,
            ]
        ];
    }

    public static function CancelTransaction($id, $param_id, $reason)
    {
        $transaction = OrderTransaction::where(['param_id' => $param_id])->first();

        if($transaction == null){
            if($reason != null){
                return [
                    'jsonrpc' => "2.0",
                    'error' => [
                        'code' => -31003,
                        'message' => "Транзакция не найдена."
                    ]
                ];
            }else{
                return [
                    'jsonrpc' => "2.0",
                    'error' => [
                        'code' => -32504,
                        'message' => "Недостаточно привилегий для выполнения метода."
                    ]
                ];
            }
        }
        else{
            if($transaction->state == PaymeData::STATE_CREATED){
                $transaction->state = PaymeData::STATE_CANCELLED;
                $transaction->reason = $reason;
                $transaction->cancel_time = (string)round(microtime(true) * 1000); ///risk xatolik boliwi mumkin
                $transaction->save();

                $bill = Bills::where('transaction_id', $transaction->id)->where('type','order')->where('psystem', 'Payme')->where('status', 'created')->first();
                $bill->status = 'canceled';
                $bill->save();

                $order = Order::find($transaction->order_id);
                $order->state = PaymeData::STATE_CANCELLED;
                $order->change_state = date('Y-m-d H:i:s');
                $order->save();

                return [
                    'result' => [
                        'transaction' => $transaction->paycom_transaction_id,
                        'cancel_time' => (integer)$transaction->cancel_time,
                        'state' => $transaction->state,
                    ]
                ];
            }
            else{
                if($transaction->state == PaymeData::STATE_COMPLETED){
                    if( true ){
                        $transaction->state = PaymeData::STATE_CANCELLED_AFTER_COMPLETE;
                        $transaction->reason = $reason;
                        $transaction->cancel_time = (string)round(microtime(true) * 1000); ///risk xatolik boliwi mumkin
                        $transaction->save();

                        $bill = Bills::where('transaction_id', $transaction->id)->where('type','order')->where('psystem', 'Payme')->where('status', 'completed')->first();
                        $bill->status = 'canceled after complete';
                        $bill->save();

                        $order = Order::find($transaction->order_id);
                        $order->state = PaymeData::STATE_CANCELLED_AFTER_COMPLETE;
                        $order->change_state = date('Y-m-d H:i:s');
                        $order->save();

                        return [
                            'result' => [
                                'transaction' => $transaction->paycom_transaction_id,
                                'cancel_time' => (integer)$transaction->cancel_time,
                                'state' => $transaction->state,
                            ]
                        ];
                    }
                    else{
                        return [
                            'jsonrpc' => "2.0",
                            'error' => [
                                'code' => -31007,
                                'message' => "Заказ выполнен. Невозможно отменить транзакцию. Товар или услуга предоставлена покупателю в полном объеме."
                            ]
                        ];
                    }
                }
                else{
                    return [
                        'result' => [
                            'transaction' => $transaction->paycom_transaction_id,
                            'cancel_time' => (integer)$transaction->cancel_time,
                            'state' => $transaction->state,
                        ]
                    ];
                }
            }
        }
    }

    public static function GetStatement($id, $from, $to)
    {
        $result = [];
        $transactions = OrderTransaction::whereBetween('paycom_time', [$from, $to])->get();

        if($transactions->count() == 0){
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ]
            ];
        }

        foreach ($transactions as $transaction) {
            $result [] = [
                'id' => $transaction->paycom_transaction_id,
                'time' => $transaction->paycom_time,
                'amount' => $transaction->amount,
                'account' => [
                    'order_id' => $transaction->order_id,
                ],
                'create_time' => $transaction->create_time,
                'perform_time' => $transaction->perform_time,
                'cancel_time' => $transaction->cancel_time,
                'transaction' => '',//$transaction->paycom_transaction_id,
                'state' => $transaction->state,
                'reason' => $transaction->reason,
                'receivers' => $transaction->receivers,
            ];
        }

        return [
            'result' => [
                'transactions' => $result,
            ]
        ];
    }

    public static function ChangePassword($password)
    {
        if(null == null){
            return [
                'jsonrpc' => "2.0",
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ]
            ];
        } else{
            return [
                'result' => [
                    'success' => true
                ]
            ];
        }

    }



}
