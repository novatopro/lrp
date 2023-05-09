<?php

namespace NovatoPro\Lrp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NovatoPro\Lrp\Commands\LrpCommand;
use Livewire\Livewire;
use NovatoPro\Lrp\Http\Livewire\RolePermission;
use Illuminate\View\Compilers\BladeCompiler;


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
            // ->hasViews()
            ->hasMigrations(array('create_roles_table', 'create_role_user_table', 'create_permissions_table', 'create_permission_role_table'))
            ->hasCommand(LrpCommand::class);
    }

    public function register()
    {
        $this->app->afterResolving(BladeCompiler::class, function () {
            if (class_exists(Livewire::class)) {
                Livewire::component('role-permission', RolePermission::class);
            }
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lrp');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views'),
        ], 'lrp-views');

        $this->loadRoutesFrom(__DIR__ . '/../routes/lrp.php');

        $this->publishes([
            __DIR__ . '/../routes/lrp.php' => base_path('routes/lrp.php'),
        ], 'lrp-routes');

    }
}
