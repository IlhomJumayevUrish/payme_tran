<?php

namespace App\Models\Api\Payme;

use App\Models\BillingSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymeData extends Model
{
    use HasFactory;

    public $order_min_amount = 50000;
    public $order_max_amount = 1000000000;
    public $user_min_amount = 50000;
    public $user_max_amount = 1000000000;

    const TIMEOUT = 43200000;
    const STATE_CREATED                  = 1;
    const STATE_COMPLETED                = 2;
    const STATE_CANCELLED                = -1;
    const STATE_CANCELLED_AFTER_COMPLETE = -2;

    const REASON_RECEIVERS_NOT_FOUND         = 1;
    const REASON_PROCESSING_EXECUTION_FAILED = 2;
    const REASON_EXECUTION_FAILED            = 3;
    const REASON_CANCELLED_BY_TIMEOUT        = 4;
    const REASON_FUND_RETURNED               = 5;
    const REASON_UNKNOWN                     = 10;

    public function __construct()
    {
        $this->order_min_amount = BillingSetting::getValue('payme_order_min_amount')*100;
        $this->order_max_amount = BillingSetting::getValue('payme_order_max_amount')*100;
        $this->user_min_amount = BillingSetting::getValue('payme_user_min_amount')*100;
        $this->user_max_amount = BillingSetting::getValue('payme_user_max_amount')*100;
    }


    public static function datetime2timestamp($datetime)
    {
        if ($datetime) {
            return 1000 * strtotime($datetime);
        }
        return $datetime;
    }

    public static function timestamp2seconds($timestamp)
    {
        // is it already as seconds
        if (strlen((string)$timestamp) == 10) {
            return $timestamp;
        }

        return floor(1 * $timestamp / 1000);
    }

    public static function timestamp2datetime($timestamp)
    {
        // if as milliseconds, convert to seconds
        if (strlen((string)$timestamp) == 13) {
            $timestamp = PaymeData::timestamp2seconds($timestamp);
        }

        // convert to datetime string
        return date('Y-m-d H:i:s', $timestamp);
    }
}
