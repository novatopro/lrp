<?php

namespace NovatoPro\Lrp;

use Livewire\Livewire;
use NovatoPro\Lrp\Http\Livewire\RolePermission;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LrpServiceProvider extends PackageServiceProvider
{

    public function bootingPackage()
    {
        Livewire::component('role-permission', RolePermission::class);
    }
    
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lrp')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoutes('web')
            ->hasMigrations(array('create_roles_table', 'create_role_user_table', 'create_permissions_table', 'create_permission_role_table'))
            // ->hasCommand(LrpCommand::class)
            ;
    }

    
    
}
