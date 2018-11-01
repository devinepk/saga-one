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
        $now = now();

        DB::table('users')->insert([
            'name' => 'Ben Patterson',
            'email' => 'bmizepatterson@gmail.com',
            'password' => bcrypt('benpatterson'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
