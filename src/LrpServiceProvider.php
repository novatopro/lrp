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
            ->hasMigration('create_lrp_table')
            ->hasCommand(LrpCommand::class);
    }
}
