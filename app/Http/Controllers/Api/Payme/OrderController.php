<?php

namespace App\Http\Controllers\Api\Payme;

use App\Http\Controllers\Controller;
use App\Models\Api\Payme\OrderTransaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function actionApi(Request $request)
    {
        $method = $request->get('method');
        $params = $request->get('params');
        $id = $request->get('id');

        if($method == 'CheckPerformTransaction'){
            $amount = $params['amount'];
            $order_id = null;
            if(isset($params['account']['order_id'])) $order_id = $params['account']['order_id'];

            $result = OrderTransaction::CheckPerformTransaction($id, $amount, $order_id);
            return $result;
        }

        if($method == 'CreateTransaction'){
            $param_id = $params['id'];
            $time = $params['time'];
            $amount = $params['amount'];
            $order_id = null;
            if(isset($params['account']['order_id'])) $order_id = $params['account']['order_id'];

            $result = OrderTransaction::CreateTransaction($id, $param_id, $time, $amount, $order_id);
            return $result;
        }

        if($method == 'PerformTransaction'){
            $param_id = $params['id'];

            $result = OrderTransaction::PerformTransaction($id, $param_id);
            return $result;
        }

        if($method == 'CheckTransaction'){
            $param_id = $params['id'];

            $result = OrderTransaction::CheckTransaction($id, $param_id);
            return $result;
        }

        if($method == 'CancelTransaction'){
            $reason = null;
            if(isset($params['reason'])) $reason = $params['reason'];
            $param_id = $params['id'];

            $result = OrderTransaction::CancelTransaction($id, $param_id, $reason);
            return $result;
        }

        if($method == 'GetStatement'){
            $from = $params['from'];
            $to = $params['to'];

            $result = OrderTransaction::GetStatement($id, $from, $to);
            return $result;
        }

        if($method == 'ChangePassword'){
            $password = $params['password'];

            $result = OrderTransaction::ChangePassword($password);
            return $result;
        }

    }
}
