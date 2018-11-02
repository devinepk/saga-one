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

        // Journal 1
        DB::table('journal_user')->insert([
            'journal_id' => 1,
            'user_id' => 2,
            'next_user_id' => 3,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => 1,
            'user_id' => 3,
            'next_user_id' => 4,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => 1,
            'user_id' => 4,
            'next_user_id' => 5,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => 1,
            'user_id' => 5,
            'next_user_id' => 2,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);


        // Journal 2
        DB::table('journal_user')->insert([
            'journal_id' => 2,
            'user_id' => 2,
            'next_user_id' => 6,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => 2,
            'user_id' => 6,
            'next_user_id' => 7,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => 2,
            'user_id' => 7,
            'next_user_id' => 2,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);


        // Other journals belong to Ben alone
        DB::table('journal_user')->insert([
            'journal_id' => 3,
            'user_id' => 1,
            'next_user_id' => null,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => 4,
            'user_id' => 1,
            'next_user_id' => null,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('journal_user')->insert([
            'journal_id' => 5,
            'user_id' => 1,
            'next_user_id' => null,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
