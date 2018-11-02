<?php

use Illuminate\Database\Seeder;

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
            'id' => 1,
            'name' => 'Ben Patterson',
            'email' => 'bmizepatterson@gmail.com',
            'password' => bcrypt('benpatterson'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Bobby Bob',
            'email' => 'bobbybob@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Bobbert Bob',
            'email' => 'bobbertbob@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'id' => 4,
            'name' => 'Bonnie Bobbington',
            'email' => 'bonniebobbington@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'id' => 5,
            'name' => 'Boris Bobford',
            'email' => 'borisbobford@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'id' => 6,
            'name' => 'Billy Bobbly',
            'email' => 'billybobbly@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'id' => 7,
            'name' => 'Bongo Bor',
            'email' => 'bongobor@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
