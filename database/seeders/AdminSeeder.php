<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'phone' => '08989484920',
            'email' => 'siremo@admin.com',
            'password' => bcrypt('@RizkiHutama1'),
            'role' => 1,
            'created_at' => now(),
        ]);
    }
}
