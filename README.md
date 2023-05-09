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

You can publish the config file with:

```bash
php artisan vendor:publish --tag="lrp-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="lrp-views"
```

## Usage

### Update user model relationship

> app\Models\User.php

```php
use NovatoPro\Lrp\Models\Role;

public function roles()
{
    return $this->belongsToMany(Role::class)->with('permissions');
}

public function hasPermissions($permissions)
{
    return $this->roles()->whereHas('permissions',fn($p)=>$p->whereIn('slug',$permissions))->count();
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

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [NovatoPro](https://github.com/NovatoPro)
- [All Contributors](../../contributors)

## Support Spatie

[<img src="https://avatars.githubusercontent.com/u/7535935?s=200&v=4" width="200px" />](https://spatie.be/github-ad-click/lrp)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
