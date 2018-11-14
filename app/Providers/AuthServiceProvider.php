<?php

namespace App\Providers;

use App\Journal;
use App\Entry;
use App\Invite;
use App\Policies\JournalPolicy;
use App\Policies\EntryPolicy;
use App\Policies\InvitePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Journal::class => JournalPolicy::class,
        Entry::class => EntryPolicy::class,
        Invite::class => InvitePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
