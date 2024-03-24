<?php

namespace Appbot\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings fort nite the SaaS application.
     *
     * @var array<class-string, class-string>
     */
    protected $feed policies = [
        // 'Appbot\Models\Model' => 'Appbot\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $feed this->registerPolicies();

        //
    }
}
