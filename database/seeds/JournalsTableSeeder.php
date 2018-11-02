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

        // Dummy users
        $ben = \App\User::where('email', 'bmizepatterson@gmail.com')->firstOrFail();
        $bobbyBob = \App\User::where('email', 'bobbybob@gmail.com')->firstOrFail();
        $bobbertBob = \App\User::where('email', 'bobbertbob@gmail.com')->firstOrFail();
        $bonnieBobbington = \App\User::where('email', 'bonniebobbington@gmail.com')->firstOrFail();
        $borisBobford = \App\User::where('email', 'borisbobford@gmail.com')->firstOrFail();
        $billyBobbly = \App\User::where('email', 'billybobbly@gmail.com')->firstOrFail();
        $bongoBor = \App\User::where('email', 'bongobor@gmail.com')->firstOrFail();

        DB::table('journals')->insert([
            'title' => 'Journal 1',
            'description' => 'A journal for friends',
            'creator_id' => $bobbyBob->id,
            'current_user_id' => $bobbyBob->id,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'Journal 2',
            'description' => 'A journal for family',
            'creator_id' => $bobbyBob->id,
            'current_user_id' => $bobbyBob->id,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'Journal 3',
            'description' => 'A journal for friends and family',
            'creator_id' => $ben->id,
            'current_user_id' => $ben->id,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'Journal 4',
            'description' => 'A journal with a long description veggies es bonus vobis, proinde vos postulo essum magis',
            'creator_id' => $ben->id,
            'current_user_id' => $ben->id,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journals')->insert([
            'title' => 'A Journal with No Description',
            'description' => null,
            'creator_id' => $ben->id,
            'current_user_id' => $ben->id,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
