<?php

namespace NovatoPro\Lrp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NovatoPro\Lrp\Commands\LrpCommand;

class LrpServiceProvider extends PackageServiceProvider
{
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
            ->hasMigrations(array('create_roles_table','create_role_user_table','create_permissions_table','create_permission_role_table'))
            ->hasCommand(LrpCommand::class);
    }
}
