<p align="center">
  <img src="https://sentry-brand.storage.googleapis.com/sentry-logo-black.png" alt="Sentry" width="240" />
</p>

# Sentry for Laravel applications

[![Version][badge_packagist_version]][link_packagist]
[![PHP Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

This package allows you to:

- Integrate package [`avto-dev/app-version-laravel`][package_app_version] with [`sentry/sentry-laravel`][package_sentry_laravel].

> Full documentation can be [found here][sentry_php_docs]

## Install

Require this package with composer using the following command:

```bash
$ composer require avto-dev/sentry-laravel "^2.3"
```

> Installed `composer` is required ([how to install composer][getcomposer]).

> You need to fix the major version of package.

Add Sentry reporting to `./app/Exceptions/Handler.php`:

```php
<?php

namespace App\Exceptions;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    // ...

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public function report(\Exception $exception): void
    {
        if ($this->container->bound('sentry') && $this->shouldReport($exception)) {
            try {
                $this->container->make('sentry')->captureException($exception);
            } catch (\Exception $e) {
                $this->container->make(\Psr\Log\LoggerInterface::class)->error(
                    'Cannot capture exception with sentry: ' . $e->getMessage(), ['exception' => $e]
                );
            }
        }

        parent::report($exception);
    }

    // ...
}
```

Create the Sentry configuration file (`./config/sentry.php`) with this command:

> If you already have `./config/sentry.php` file - rename it using next command:
>
> ```bash
> $ test -f ./config/sentry.php && mv ./config/sentry.php ./config/sentry.php.old
> ```

```bash
$ php artisan vendor:publish --tag=sentry-config --force
```

And edit it on your choice.

### Testing with Artisan

You can test your configuration using the provided `artisan` command:

```bash
$ php artisan sentry:test
[sentry] Client DSN discovered!
[sentry] Generating test event
[sentry] Sending test event
[sentry] Event sent: e6442bd7806444fc8b2710abce3599ac
```

## Local development

When Sentry is installed in your application it will also be active when you are developing.

If you don't want errors to be sent to Sentry when you are developing set the DSN value to `null` (define `SENTRY_LARAVEL_DSN=null` in your `.env` file).

## Using Laravel log channels

> Note: If you’re using log channels to log your exceptions and are also logging exceptions to Sentry in your exception handler (as you would have configured above) exceptions might end up twice in Sentry

To configure Sentry as a log channel, add the following config to the `channels` section in `./config/logging.php`:

```php
<?php

return [
    'channels' => [

        // ...

        'sentry' => [
            'driver' => 'sentry',
        ],
    ],
];
```

After you configured the Sentry log channel, you can configure your app to both log to a log file and to Sentry by modifying the log stack:

```php
<?php

return [
    'channels' => [

        'stack' => [
            'driver'   => 'stack',
            'channels' => ['single', 'sentry'], // Add the Sentry log channel to the stack
        ],

        // ...
    ],
];
```

Optionally, you can set the logging level and if events should bubble on the driver:


And modify next lines:

```php
<?php

return [
    'channels' => [

        // ...

        'sentry' => [
            'driver' => 'sentry',
            'level'  => null, // The minimum monolog logging level at which this handler will be triggered
                              // For example: `\Monolog\Logger::ERROR`
            'bubble' => true, // Whether the messages that are handled can bubble up the stack or not
        ],
    ],
];
```

### Naming you log channels

If you have multiple log channels you would like to filter on inside the Sentry interface, you can add the `name` attribute to the log channel. It will show up in Sentry as the `logger` tag, which is filterable.

For example:

```php
<?php

return [
    'channels' => [

        // ...

        'my_stacked_channel' => [
            'driver'   => 'stack',
            'channels' => ['single', 'sentry'],
            'name'     => 'my-channel'
        ],
    ],
];
```

You’re now able to log errors to your channel:

```php
<?php

\Illuminate\Support\Facades\Log::channel('my_stacked_channel')->error('My error');
```

And Sentry's `logger` tag now has the channel's `name`. You can filter on the "my-channel" value.

### Testing

For package testing we use `phpunit` framework and `docker-ce` + `docker-compose` as develop environment. So, just write into your terminal after repository cloning:

```bash
$ make build
$ make latest # or 'make lowest'
$ make test
```

## Changes log

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changes_log].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/avto-dev/sentry-laravel.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/avto-dev/sentry-laravel.svg?longCache=true
[badge_build_status]:https://img.shields.io/github/workflow/status/avto-dev/sentry-laravel/tests/master
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/sentry-laravel/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/sentry-laravel.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avto-dev/sentry-laravel.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avto-dev/sentry-laravel.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avto-dev/sentry-laravel/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avto-dev/sentry-laravel.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avto-dev/sentry-laravel.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/avto-dev/sentry-laravel/releases
[link_packagist]:https://packagist.org/packages/avto-dev/sentry-laravel
[link_build_status]:https://github.com/avto-dev/sentry-laravel/actions
[link_coverage]:https://codecov.io/gh/avto-dev/sentry-laravel/
[link_changes_log]:https://github.com/avto-dev/sentry-laravel/blob/master/CHANGELOG.md
[link_issues]:https://github.com/avto-dev/sentry-laravel/issues
[link_create_issue]:https://github.com/avto-dev/sentry-laravel/issues/new/choose
[link_commits]:https://github.com/avto-dev/sentry-laravel/commits
[link_pulls]:https://github.com/avto-dev/sentry-laravel/pulls
[link_license]:https://github.com/avto-dev/sentry-laravel/blob/master/LICENSE
[getcomposer]:https://getcomposer.org/download/
[package_app_version]:https://github.com/avto-dev/app-version-laravel
[package_sentry_laravel]:https://github.com/getsentry/sentry-laravel
[sentry_php_docs]:https://docs.sentry.io/platforms/php/laravel/
