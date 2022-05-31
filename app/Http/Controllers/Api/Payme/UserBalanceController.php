<?php

namespace App\Http\Controllers\Api\Payme;

use App\Http\Controllers\Controller;
use App\Models\Api\Payme\UserTransaction;
use Illuminate\Http\Request;

class UserBalanceController extends Controller
{
    public function actionApi(Request $request)
    {
        $method = $request->get('method');
        $params = $request->get('params');
        $id = $request->get('id');

        if ($method == 'CheckPerformTransaction') {
            $amount = $params['amount'];
            $user_id = null;
            if (isset($params['account']['user_id'])) $user_id = $params['account']['user_id'];

            $result = UserTransaction::CheckPerformTransaction($id, $amount, $user_id);
            return $result;
        }

        if ($method == 'CreateTransaction') {
            $param_id = $params['id'];
            $time = $params['time'];
            $amount = $params['amount'];
            $user_id = null;
            if (isset($params['account']['user_id'])) $user_id = $params['account']['user_id'];


            $result = UserTransaction::CreateTransaction($id, $param_id, $time, $amount, $user_id);
            return $result;
        }

        if ($method == 'PerformTransaction') {
            $param_id = $request['params']['id'];

            $result = UserTransaction::PerformTransaction($id, $param_id);
            return $result;
        }

        if ($method == 'CheckTransaction') {
            $param_id = $params['id'];

            $result = UserTransaction::CheckTransaction($id, $param_id);
            return $result;
        }

        if ($method == 'CancelTransaction') {
            $reason = null;
            if (isset($params['reason'])) $reason = $params['reason'];
            $param_id = $params['id'];

            $result = UserTransaction::CancelTransaction($id, $param_id, $reason);
            return $result;
        }

        if ($method == 'GetStatement') {
            $from = $params['from'];
            $to = $params['to'];

            $result = UserTransaction::GetStatement($id, $from, $to);
            return $result;
        }

        if ($method == 'ChangePassword') {
            $password = $params['password'];

            $result = UserTransaction::ChangePassword($password);
            return $result;
        }
    }
}
