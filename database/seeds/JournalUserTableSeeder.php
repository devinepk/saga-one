<?php

use Illuminate\Database\Seeder;

class JournalUserTableSeeder extends Seeder
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

        // Dummy journals
        $journal1 = \App\Journal::where('title', 'Journal 1')->firstOrFail();
        $journal2 = \App\Journal::where('title', 'Journal 2')->firstOrFail();
        $journal3 = \App\Journal::where('title', 'Journal 3')->firstOrFail();
        $journal4 = \App\Journal::where('title', 'Journal 4')->firstOrFail();
        $journalNoDescription = \App\Journal::where('title', 'A Journal with No Description')->firstOrFail();

        // Journal 1
        DB::table('journal_user')->insert([
            'journal_id' => $journal1->id,
            'user_id' => $bobbyBob->id,
            'next_user_id' => $bobbertBob->id,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => $journal1->id,
            'user_id' => $bobbertBob->id,
            'next_user_id' => $bonnieBobbington->id,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => $journal1->id,
            'user_id' => $bonnieBobbington->id,
            'next_user_id' => $borisBobford->id,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => $journal1->id,
            'user_id' => $borisBobford->id,
            'next_user_id' => $bobbyBob->id,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);


        // Journal 2
        DB::table('journal_user')->insert([
            'journal_id' => $journal2->id,
            'user_id' => $bobbyBob->id,
            'next_user_id' => $billyBobbly->id,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => $journal2->id,
            'user_id' => $billyBobbly->id,
            'next_user_id' => $bongoBor->id,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => $journal2->id,
            'user_id' => $bongoBor->id,
            'next_user_id' => $bobbyBob->id,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);


        // Other journals belong to Ben alone
        DB::table('journal_user')->insert([
            'journal_id' => $journal3->id,
            'user_id' => $ben->id,
            'next_user_id' => null,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => $journal4->id,
            'user_id' => $ben->id,
            'next_user_id' => null,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => $journalNoDescription->id,
            'user_id' => $ben->id,
            'next_user_id' => null,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
