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
            'title' => 'Journal 1',
            'description' => 'A journal for friends',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'Journal 2',
            'description' => 'A journal for family',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'Journal 3',
            'description' => 'A journal for friends and family',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'Journal 4',
            'description' => 'A journal with a long description veggies es bonus vobis, proinde vos postulo essum magis',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'A Journal with No Description',
            'description' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
