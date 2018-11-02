<?php

use Illuminate\Database\Seeder;

class JournalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('journals')->insert([
            'id' => 1,
            'title' => 'Journal 1',
            'description' => 'A journal for friends',
            'creator_id' => 2,
            'current_user_id' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'id' => 2,
            'title' => 'Journal 2',
            'description' => 'A journal for family',
            'creator_id' => 2,
            'current_user_id' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'id' => 3,
            'title' => 'Journal 3',
            'description' => 'A journal for friends and family',
            'creator_id' => 2,
            'current_user_id' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'id' => 4,
            'title' => 'Journal 4',
            'description' => 'A journal with a long description veggies es bonus vobis, proinde vos postulo essum magis',
            'creator_id' => 2,
            'current_user_id' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'id' => 5,
            'title' => 'A Journal with No Description',
            'description' => null,
            'creator_id' => 2,
            'current_user_id' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
