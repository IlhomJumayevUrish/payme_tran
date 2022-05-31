<?php

namespace App\Http\Controllers\Api\Click;

use App\Http\Controllers\Controller;
use App\Models\Api\Bills;
use App\Models\Api\Click\ClickData;
use App\Models\Api\Click\ClickOrderTransaction;
use App\Models\Api\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ClickOrderController extends Controller
{
    private $reqData = [];
    private $bill; // init into validateData()

    public function actionPrepare()
    {
        $this->reqData = $_POST;
        $this->validateData();
        $checkExists = ClickOrderTransaction::where(['click_trans_id' => $this->reqData['click_trans_id']])->first();

        if ($checkExists !== NULL) {
            if ($checkExists->status == ClickData::STATUS_CANCEL) {
                //Transaction cancelled
                die(json_encode(ClickData::getMessage('9')));
            } //Already paid
            else die(json_encode(ClickData::getMessage('4')));
        }

        //Error in request from click
        if (!$this->reqData['error'] == 0) die(json_encode(ClickData::getMessage('8')));

        $order = Order::find($this->reqData['merchant_trans_id']);

        $bill = new Bills();
        $bill->user_id = $order->id;
        $bill->amount = $this->reqData['amount'];
        $bill->status = 'created';
        $bill->type = 'order';
        $bill->psystem = 'Click';
        $bill->description = 'Пополнение счета через Click';
        $bill->save();

        $newTransaction = new ClickOrderTransaction;
        $newTransaction->bill_id        = $this->reqData['merchant_trans_id'];
        $newTransaction->click_trans_id = $this->reqData['click_trans_id'];
        $newTransaction->service_id     = $this->reqData['service_id'];
        $newTransaction->amount         = $this->reqData['amount'];
        $newTransaction->sign_time      = $this->reqData['sign_time'];
        $newTransaction->click_paydoc_id = $this->reqData['click_paydoc_id'];
        $newTransaction->create_time    = time();
        $newTransaction->status         = ClickData::STATUS_INACTIVE;

        if ($newTransaction->save()) {
            $bill->update(['transaction_id' => $newTransaction->id]);
            $merchant_prepare_id = $newTransaction->id;
            $return_array = array(
                'click_trans_id' => $this->reqData['click_trans_id'],        // ID Click Trans
                'merchant_trans_id' => $this->reqData['merchant_trans_id'],  // ID платежа в биллинге Поставщика
                'merchant_prepare_id' => $merchant_prepare_id                // ID платежа для подтверждения
            );

            $result = array_merge(ClickData::getMessage('0'), $return_array);

            die(json_encode($result));
        }
        // other case report: Unknown Error
        die(json_encode(1));
    }

    public function actionComplete()
    {
        $this->reqData = $_POST;

        //if not validated it is end point
        $this->validateData();

        //Error in request from click

        if (empty($this->reqData['merchant_prepare_id'])) die(json_encode(ClickData::getMessage('8')));

        // --------------------------------------------------------------------------- Start trasaction DB
        $merchant_prepare_id = $this->reqData['merchant_prepare_id'];
        if(strlen($this->reqData['merchant_prepare_id']) > 11) $merchant_prepare_id = 0;

        $order = Order::find($this->reqData['merchant_trans_id']);
        $bill = Bills::where('user_id', $this->reqData['merchant_trans_id'])->where('transaction_id', $merchant_prepare_id)->where('type', 'order')->where('psystem', 'Click')->first();

        if ($order == null){
            die(json_encode(ClickData::getMessage('6')));
        }

        $transaction = ClickOrderTransaction::where(
            [
                'id' => $merchant_prepare_id,
                'bill_id' => $this->reqData['merchant_trans_id'],
                'click_trans_id' => $this->reqData['click_trans_id'],
                'click_paydoc_id' => $this->reqData['click_paydoc_id'],
                'service_id' => $this->reqData['service_id'],
            ]
        )->first();

        if ($transaction !== NULL) {

            if ($this->reqData['error'] == 0) {

                if ($this->reqData['amount'] == $transaction->amount) {

                    if ($transaction->status == ClickData::STATUS_INACTIVE) {

                        $transaction->status = ClickData::STATUS_ACTIVE;

                        if (!$transaction->save()) {
                            die(json_encode(ClickData::getMessage('n')));
                        }

                        if(!empty($bill)){
                            $bill->status = 'completed';
                            $bill->date_pay = date('Y-m-d H:i:s');
                            $bill->save();

                            $order->state = 2;
                            $order->change_state = date('Y-m-d H:i:s');
                            $order->save();
                        }

                        $return_array = [
                            'click_trans_id' => $transaction->click_trans_id,
                            'merchant_trans_id' => $bill->user_id,
                            'merchant_confirm_id' => $transaction->id,
                        ];

                        $result = array_merge(ClickData::getMessage('0'), $return_array);

                        die(json_encode($result));
                    }

                    elseif ($transaction->status == ClickData::STATUS_CANCEL) {
                        //"Transaction cancelled"
                        die(json_encode(ClickData::getMessage('9')));
                    }

                    elseif ($transaction->status == ClickData::STATUS_ACTIVE) {
                        die(json_encode(ClickData::getMessage('4')));
                    }

                    else die(json_encode(ClickData::getMessage('n')));

                } else {
                    if ($transaction->status == ClickData::STATUS_INACTIVE)
                        //"Incorrect parameter amount"
                        die(json_encode(ClickData::getMessage('2')));
                }
            } elseif ($this->reqData['error'] < 0) {

                if ($this->reqData['error'] == -5017) {
                    // "Transaction cancelled"

                    if ($transaction->status != ClickData::STATUS_ACTIVE) {
                        $transaction->status = ClickData::STATUS_CANCEL;
                        if ($transaction->save()) {
                            // "Transaction cancelled"
                            $bill->update(['status' => 'canceled']);
                            $order->update(['state' => '-1']);
                            die(json_encode(ClickData::getMessage('9')));
                        }
                        die(json_encode(ClickData::getMessage('n')));
                    }

                    else die(json_encode(ClickData::getMessage('n')));
                }

                elseif ($this->reqData['error'] == -1 && $transaction->status == ClickData::STATUS_ACTIVE) {
                    die(json_encode(ClickData::getMessage('4')));
                }

                else die(json_encode(ClickData::getMessage('n')));
            }

            // error > 0
            else {
                die(json_encode(ClickData::getMessage('n')));
            }
        }

        // Transaction is null
        else {
            // Transaction does not exist
            die(json_encode(ClickData::getMessage('6')));
        }
        print_r(ClickData::getMessage(0));
    }

    private function validateData()
    {
        //check complete parameters: Unknown Error
        if ((!isset($this->reqData['click_trans_id'])) ||
            (!isset($this->reqData['service_id'])) ||
            (!isset($this->reqData['click_paydoc_id'])) ||
            (!isset($this->reqData['merchant_trans_id'])) ||
            (!isset($this->reqData['amount'])) ||
            (!isset($this->reqData['action'])) ||
            (!isset($this->reqData['sign_time'])) ||
            (!isset($this->reqData['sign_string'])) ||
            (!isset($this->reqData['error']))
        ) {
            die(json_encode(ClickData::getMessage('n')));
        }
        $setting = new ClickData();

        // Формирование ХЭШ подписи
        $sign_string_veryfied = md5(
            $this->reqData['click_trans_id'] .
            $this->reqData['service_id'] .
            $setting->order_secret_key .
            $this->reqData['merchant_trans_id'] .
            (($this->reqData['action'] == 1) ? $this->reqData['merchant_prepare_id'] : '') .
            $this->reqData['amount'] .
            $this->reqData['action'] .
            $this->reqData['sign_time']
        );
        if ($this->reqData['sign_string'] != $sign_string_veryfied) {
            die(json_encode(ClickData::getMessage('1')));
        }

        // Check Actions: Action not found
        if (!in_array($this->reqData['action'], [0, 1])) die(json_encode(ClickData::getMessage('3')));

        $bill_id = $this->reqData['merchant_trans_id'];
        if(strlen($this->reqData['merchant_trans_id']) > 11) $bill_id = 0;
        $this->bill = Order::find($bill_id);
        if ($this->bill === NULL) {
            // User does not exist
            die(json_encode(ClickData::getMessage('5')));
        }

        if ($this->bill->state == 2){
            die(json_encode(ClickData::getMessage('4')));
        }


        // Check sum: Incorrect parameter amount
        if (($this->reqData['amount'] < $setting->order_min_amount) || ($this->reqData['amount'] > $setting->order_max_amount) || ($this->reqData['amount'] != $this->bill->amount)) {
            die(json_encode(ClickData::getMessage('2')));
        }
    }

}
