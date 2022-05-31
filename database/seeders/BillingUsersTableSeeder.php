<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BillingUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('billing_users')->delete();

        \DB::table('billing_users')->insert(array (
            0 =>
            array (
                'balance' => 0,
                'created_at' => '2021-08-13 17:14:37',
                'email' => 'billing@admin.com',
                'name' => 'Billing System Admin',
                'id' => 1,
                'password' => '$2y$10$ZfFObuKNUcJTLqLYDbi3jucJMKj.KR3wTb.OGCJ0EtUpyyea0VlyC',
                'updated_at' => '2021-08-13 17:14:37',
            ),
        ));


    }
}
