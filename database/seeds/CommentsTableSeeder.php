<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entry = App\Entry::where('title', 'i am so ready for christmasssss')->firstOrFail();

        // Dummy users
        $ben = \App\User::where('email', 'bmizepatterson@gmail.com')->firstOrFail();
        $bobbyBob = \App\User::where('email', 'bobbybob@gmail.com')->firstOrFail();
        $bobbertBob = \App\User::where('email', 'bobbertbob@gmail.com')->firstOrFail();
        $bonnieBobbington = \App\User::where('email', 'bonniebobbington@gmail.com')->firstOrFail();
        $borisBobford = \App\User::where('email', 'borisbobford@gmail.com')->firstOrFail();
        $billyBobbly = \App\User::where('email', 'billybobbly@gmail.com')->firstOrFail();
        $bongoBor = \App\User::where('email', 'bongobor@gmail.com')->firstOrFail();

        $users = [$ben, $bobbyBob, $bobbertBob, $bonnieBobbington, $borisBobford, $billyBobbly, $bongoBor];


        // Create 10 random comments
        for ($i = 0; $i < 10; $i++) {
            $time = now()->subMinutes(rand(0, 300));

            DB::table('comments')->insert([
                'message' => str_random(rand(10, 300)),
                'entry_id' => $entry->id,
                'user_id' => $users[rand(0, count($users)-1)]->id,
                'created_at' => $time,
                'updated_at' => $time
            ]);
        }
    }
}
