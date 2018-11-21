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
            'name' => 'Ben Patterson',
            'email' => 'bmizepatterson@gmail.com',
            'password' => bcrypt('benpatterson'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'name' => 'Bobby Bob',
            'email' => 'bobbybob@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'name' => 'Bobbert Bob',
            'email' => 'bobbertbob@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'name' => 'Bonnie Bobbington',
            'email' => 'bonniebobbington@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'name' => 'Boris Bobford',
            'email' => 'borisbobford@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'name' => 'Billy Bobbly',
            'email' => 'billybobbly@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'name' => 'Bongo Bor',
            'email' => 'bongobor@gmail.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            'name' => 'Alex Patterson',
            'email' => 'alexkpatterson@gmail.com',
            'password' => bcrypt('alexpatterson'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Add 10 more random users just for good measure
        factory(App\User::class, 10)->create();
    }
}
