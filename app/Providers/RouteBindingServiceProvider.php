<?php

namespace App\Providers;

use mmghv\LumenRouteBinding\RouteBindingServiceProvider as BaseServiceProvider;

class RouteBindingServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the service provider
     */
    public function boot()
    {
        // The binder instance
        $binder = $this->binder;

        $binder->bind('quiniela', 'App\Quiniela');
        $binder->bind('game', 'App\Game');
        $binder->bind('quiniela_predication', 'App\QuinielaPredications');
        $binder->bind('quiniela_award', 'App\QuinielaAward');
        $binder->bind('quiniela_invitation', 'App\QuinielaInvitations');
        $binder->bind('location', 'App\Locations');
        $binder->bind('user', 'App\Users');
        $binder->bind('countries_groups', 'App\CountriesGroups');
        $binder->bind('quiniela_users', 'App\QuinielaUsers');
        $binder->bind('quiniela_type', 'App\QuinielaType');
        $binder->bind('countries', 'App\Countries');
        $binder->bind('structure', 'App\Structure');
        $binder->bind('groups', 'App\Groups');
        $binder->bind('administrator', 'App\Administrator');
        $binder->bind('configuration', 'App\Configuration');

        // Here we define our bindings
    }
}