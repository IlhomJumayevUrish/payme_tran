<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingSetting extends Model
{
    use HasFactory;
    protected $table = 'billing_settings';
    protected $guarded = [];

    static function getSettings($psystem){
        return BillingSetting::where('key','LIKE',$psystem.'%')->get();
    }

    static function updateSettings($data){
        foreach ($data as $key => $value){
            $setting = BillingSetting::where('key', $key)->first();
            $setting->update(['value' => $value]);
        }
    }

    static function getValue($psystem){
        $response = BillingSetting::where('key', $psystem)->first();
        if ($response != null){
            $response = $response->value;
        }
        return $response;
    }
}
