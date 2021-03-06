<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(JournalsTableSeeder::class);
        $this->call(JournalUserTableSeeder::class);
        $this->call(EntriesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
    }
}
