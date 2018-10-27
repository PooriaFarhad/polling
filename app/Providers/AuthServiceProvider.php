<?php

namespace App\Providers;

use App\Policies\PollOptionPolicy;
use App\Policies\PollPolicy;
use App\Poll;
use App\PollOption;
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
        PollOption::class => PollOptionPolicy::class,
        Poll::class => PollPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('name', function() {

        });
    }
}
