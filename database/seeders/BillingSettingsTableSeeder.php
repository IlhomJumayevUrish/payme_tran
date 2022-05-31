<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BillingSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('billing_settings')->delete();

        \DB::table('billing_settings')->insert(array(
            array('id' => '1','psystem' => 'Payme','name' => 'Merchant ID','key' => 'payme_user_merchant_id','description' => 'Payme Merchant ID','value' => '61232d72754e932e68ff0fdf','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '2','psystem' => 'Payme','name' => 'Ключ','key' => 'payme_user_key','description' => 'Payme Key','value' => 'xDdesRQGO9?MsphPvZtH1jDjHzAQfXwFxCbE','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '3','psystem' => 'Payme','name' => 'Минимальная сумма','key' => 'payme_user_min_amount','description' => 'Payme Minimum Amount','value' => '500','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '4','psystem' => 'Payme','name' => 'Максимальная сумма','key' => 'payme_user_max_amount','description' => 'Payme Maximum Amount','value' => '30000000','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 12:58:00'),
            array('id' => '5','psystem' => 'Payme','name' => 'Merchant ID','key' => 'payme_order_merchant_id','description' => 'Payme Merchant ID','value' => '61232d72754e932e68ff0fdh','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 13:05:19'),
            array('id' => '6','psystem' => 'Payme','name' => 'Ключ','key' => 'payme_order_key','description' => 'Payme Key','value' => 'xDdesRQGO9?MsphPvZtH1jDjHzAQfXwFxCbO','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 13:05:19'),
            array('id' => '7','psystem' => 'Payme','name' => 'Минимальная сумма','key' => 'payme_order_min_amount','description' => 'Payme Minimum Amount','value' => '500','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 15:57:40'),
            array('id' => '8','psystem' => 'Payme','name' => 'Максимальная сумма','key' => 'payme_order_max_amount','description' => 'Payme Maximum Amount','value' => '20000000','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 13:05:19'),
            array('id' => '9','psystem' => 'Payme','name' => 'Реквизиты платежа имя','key' => 'payme_user_name','description' => 'Payme Реквизиты платежа имя','value' => 'user_id','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '10','psystem' => 'Payme','name' => 'Реквизиты платежа имя','key' => 'payme_order_name','description' => 'Payme Реквизиты платежа имя','value' => 'order_id','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '11','psystem' => 'Click','name' => 'Service ID','key' => 'click_user_service_id','description' => 'Click Service ID','value' => '17118','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '12','psystem' => 'Click','name' => 'Ключ','key' => 'click_user_key','description' => 'Click Key','value' => 'xbFZg7UCDa1M','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '13','psystem' => 'Click','name' => 'Минимальная сумма','key' => 'click_user_min_amount','description' => 'Click Minimum Amount','value' => '5000','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 14:11:17'),
            array('id' => '14','psystem' => 'Click','name' => 'Максимальная сумма','key' => 'click_user_max_amount','description' => 'Click Maximum Amount','value' => '10000000','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '15','psystem' => 'Click','name' => 'Service ID','key' => 'click_order_service_id','description' => 'Click Service ID','value' => '17115','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 13:12:56'),
            array('id' => '16','psystem' => 'Click','name' => 'Ключ','key' => 'click_order_key','description' => 'Click Key','value' => 'xbFZg7UCDa1p','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 13:06:52'),
            array('id' => '17','psystem' => 'Click','name' => 'Минимальная сумма','key' => 'click_order_min_amount','description' => 'Click Minimum Amount','value' => '700','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 14:11:41'),
            array('id' => '18','psystem' => 'Click','name' => 'Максимальная сумма','key' => 'click_order_max_amount','description' => 'Click Maximum Amount','value' => '60000000','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 13:06:52'),
            array('id' => '19','psystem' => 'Click','name' => 'Merchant ID','key' => 'click_user_merchant_id','description' => 'Click Merchant ID','value' => '12400','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-27 18:33:03'),
            array('id' => '20','psystem' => 'Click','name' => 'Merchant ID','key' => 'click_order_merchant_id','description' => 'Click Merchant ID','value' => '12401','created_at' => '2021-08-27 18:33:03','updated_at' => '2021-08-28 13:06:52')
        ));


    }
}
