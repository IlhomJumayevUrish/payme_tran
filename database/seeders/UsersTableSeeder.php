<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'balance' => 0,
                'created_at' => '2021-08-13 17:14:37',
                'email' => 'aziz@mail.com',
                'name' => 'Aliev Aziz',
                'id' => 1,
                'password' => '$2y$10$ZfFObuKNUcJTLqLYDbi3jucJMKj.KR3wTb.OGCJ0EtUpyyea0VlyC',
                'updated_at' => '2021-08-13 17:14:37',
            ),
        ));


    }
}
