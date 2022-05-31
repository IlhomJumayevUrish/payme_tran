<?php

namespace App\Models\Api\Click;

use App\Models\BillingSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickData extends Model
{
    use HasFactory;

    const STATUS_CANCEL = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $order_min_amount = 50000;
    public $order_max_amount = 1000000000;
    public $order_secret_key = null;

    public $user_min_amount = 50000;
    public $user_max_amount = 1000000000;
    public $user_secret_key = null;

    public function __construct()
    {
        $this->order_min_amount = BillingSetting::getValue('click_order_min_amount');
        $this->order_max_amount = BillingSetting::getValue('click_order_max_amount');
        $this->order_secret_key = BillingSetting::getValue('click_order_key');

        $this->user_min_amount = BillingSetting::getValue('click_user_min_amount');
        $this->user_max_amount = BillingSetting::getValue('click_user_max_amount');
        $this->user_secret_key = BillingSetting::getValue('click_user_key');

    }

    static public function getMessage($value)
    {
        $messages = array(
            0 => array("error"=>"0","error_note" =>"Success"),
            1 => array("error"=>"-1","error_note"=>"SIGN CHECK FAILED!"),
            2 => array("error"=>"-2","error_note"=>"Incorrect parameter amount"),
            3 => array("error"=>"-3","error_note"=>"Action not found"),
            4 => array("error"=>"-4","error_note"=>"Already paid"),
            5 => array("error"=>"-5","error_note"=>"User does not exist"),
            6 => array("error"=>"-6","error_note"=>"Transaction does not exist"),
            7 => array("error"=>"-7","error_note"=>"Failed to update user"),
            8 => array("error"=>"-8","error_note"=>"Error in request from click"),
            9 => array("error"=>"-9","error_note"=>"Transaction cancelled"),
            'n' => array("error"=>"-n","error_note"=>"Unknown Error"),
        );
        return $messages[$value];
    }
}
