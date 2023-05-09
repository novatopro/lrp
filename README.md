# This is a basic package for laravel roles and permissions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/novatopro/lrp.svg?style=flat-square)](https://packagist.org/packages/novatopro/lrp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/novatopro/lrp/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/novatopro/lrp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/novatopro/lrp/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/novatopro/lrp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/novatopro/lrp.svg?style=flat-square)](https://packagist.org/packages/novatopro/lrp)

This package provide basic roles and permissions, this readme.md contains examples of usage.

## Installation

You can install the package via composer:

```bash
composer require novatopro/lrp
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="lrp-migrations"
php artisan migrate
```

## Usage

### Update user model relationship

> app\Models\User.php

```php
use NovatoPro\Lrp\Traits\UserLrp;

class User extends Authenticatable
{
    use UserLrp;
}

```

### Update boot method in AuthServiceProvider

> app\Providers\AuthServiceProvider.php

```php
Gate::define('access', function (User $user, ...$permissions) {
    return $user->hasPermissions($permissions);
});
```

### Examples
```php
use NovatoPro\Lrp\Models\Role;
use NovatoPro\Lrp\Models\Permission;
// Example user credentials
$credentials = [
    'name'=>'Example User',
    'email'=>'developer.user@example.com',
    'password'=>'password'
];

// Create example user
$user = User::updateOrCreate(['email'=>$credentials['email']],['name'=>$credentials['name'],'password'=>Hash::make($credentials['password'])]);

// Create example role
$role = Role::updateOrCreate(['name'=>'Developer Features','slug'=>'developer-features']);

// Create example permission
$permission = Permission::updateOrCreate(['name'=>'Dev','slug'=>'dev','description'=>'Can see features in development']);

// Add permision to role without remove, without duplicate
$role->permissions()->syncWithoutDetaching($permission->id);

// Add role to user without remove, without duplicate
$user->roles()->syncWithoutDetaching($role->id);

// Check permissions in controllers
if($user->can('access', ['developer','dev','develop'])){
    // Can see features in development
}else{
    // Can't see features in development
}

// Authorize with permissions
use Illuminate\Support\Facades\Gate;
Gate::authorize('access','dev');
```

```php
// Check permissions in blade
@can('access', ['developer','dev','develop'])
    <h1>Can see features in development</h1>
@else
    <h1>Can't see features in development</h1>
@endcan
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
