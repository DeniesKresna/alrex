<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([[
              'name' => 'Denies Kresna B',
              'username' => 'denies',
              'password' => app('hash')->make('12345'),
              'email' => 'batkorumbawa@gmail.com',
              'role' => 'superadmin',
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],
      ]);
      DB::table('symbols')->insert([[
              'id' => 1,
              'symbol_name' => 'Euro US Dollar',
              'symbol_code' => 'EUR/USD',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 2,
              'symbol_name' => 'Euro Swiss Franc',
              'symbol_code' => 'EUR/CHF',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 3,
              'symbol_name' => 'Euro Japanese Yen',
              'symbol_code' => 'EUR/JPY',
              'symbol_decimal' => 2,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 4,
              'symbol_name' => 'Euro British Pound',
              'symbol_code' => 'EUR/GBP',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 5,
              'symbol_name' => 'Euro New Zealand Dollar',
              'symbol_code' => 'EUR/NZD',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 13,
              'symbol_name' => 'Australian Dollar US Dollar',
              'symbol_code' => 'AUD/USD',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 18,
              'symbol_name' => 'US Dollar Canadian Dollar',
              'symbol_code' => 'USD/CAD',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 19,
              'symbol_name' => 'US Dollar Swiss Franc',
              'symbol_code' => 'USD/CHF',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 20,
              'symbol_name' => 'US Dollar Japanese Yen',
              'symbol_code' => 'USD/JPY',
              'symbol_decimal' => 2,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 21,
              'symbol_name' => 'US Dollar New Zealand Dollar',
              'symbol_code' => 'USD/NZD',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 35,
              'symbol_name' => 'Canadian Dollar Japanese Yen',
              'symbol_code' => 'CAD/JPY',
              'symbol_decimal' => 2,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 39,
              'symbol_name' => 'British Pound US Dollar',
              'symbol_code' => 'GBP/USD',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ],[
              'id' => 49,
              'symbol_name' => 'Swiss Franc New Zealand Dollar',
              'symbol_code' => 'CHF/NZD',
              'symbol_decimal' => 4,
              'created_at' => date('Y-m-d H:i:s'),
              'updated_at' => date('Y-m-d H:i:s')
            ]
      ]);
    }
}
