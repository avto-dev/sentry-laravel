<p align="center">
  <img src="https://sentry-brand.storage.googleapis.com/sentry-logo-black.png" alt="Sentry" width="240" />
</p>

# Sentry for Laravel applications

[![Version][badge_packagist_version]][link_packagist]
[![Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Code quality][badge_code_quality]][link_code_quality]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

Данный пакет предназначен для того, чтоб упростить работу c Sentry, так как:

 - Данные, отправляемые на сервер Sentry "подписываются" текущей версией приложения (которую возвращает пакет `avto-dev/app-version-laravel`);
 - Конфигурационный файл `./config/sentry.php` имеет более подробную документацию.

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require avto-dev/sentry-laravel "^1.3"
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].

> Обратите внимание на то, что необходимо фиксировать мажорную версию устанавливаемого пакета.

Если вы используете Laravel версии 5.5 и выше, то сервис-провайдер данного пакета будет зарегистрирован автоматически. В противном случае вам необходимо самостоятельно зарегистрировать сервис-провайдер в секции `providers` файла `./config/app.php`:

```php
'providers' => [
    // ...
    AvtoDev\Sentry\SentryServiceProvider::class,
]
```

Установив данный пакет в ваше приложение также будут установлены следующие:

 1. **[avto-dev/app-version-laravel][package_app_version]** - менеджер версии Laravel-приложения;
 1. **[sentry/sentry-laravel][package_sentry_laravel]** - клиент для работы с Sentry.

Сервис-провайдеры которых будут зарегистрированы автоматически, вам остается только опубликовать конфигурационный файл пакета `avto-dev/app-version-laravel` с помощью команды:

```shell
$ php artisan vendor:publish --provider="AvtoDev\\AppVersion\\AppVersionServiceProvider"
```

И произвести инициализацию конфигурационного файла Sentry (если конфигурационный файл `./config/sentry.php` уже присутствует - он будет обновлён, сохранив ранее установленные значения и предварительно создав резервную копию рядом):

```shell
$ php artisan sentry:init
```

Если пакет `sentry/sentry-laravel` ранее не был проинтегрирован в ваше приложение - пожалуйста, **произведите его интеграцию** согласно [описанию в его репозитории][package_sentry_laravel]. В противном случае просто удалите зависимость `sentry/sentry-laravel` из вашего `composer.json` *(за его наличие и управление версией отвечает данный пакет)*.

## Использование

Так как основное предназначение данного пакета - произвести "связывание" двух других - он не имеет каких-либо особенностей в эксплуатации.

### Testing

For package testing we use `phpunit` framework. Just write into your terminal:

```shell
$ git clone git@github.com:avto-dev/sentry-laravel.git ./sentry-laravel && cd $_
$ composer install
$ composer test
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
[badge_build_status]:https://travis-ci.org/avto-dev/sentry-laravel.svg?branch=master
[badge_code_quality]:https://img.shields.io/scrutinizer/g/avto-dev/sentry-laravel.svg?maxAge=180
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/sentry-laravel/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/sentry-laravel.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avto-dev/sentry-laravel.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avto-dev/sentry-laravel.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avto-dev/sentry-laravel/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avto-dev/sentry-laravel.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avto-dev/sentry-laravel.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/avto-dev/sentry-laravel/releases
[link_packagist]:https://packagist.org/packages/avto-dev/sentry-laravel
[link_build_status]:https://travis-ci.org/avto-dev/sentry-laravel
[link_coverage]:https://codecov.io/gh/avto-dev/sentry-laravel/
[link_changes_log]:https://github.com/avto-dev/sentry-laravel/blob/master/CHANGELOG.md
[link_code_quality]:https://scrutinizer-ci.com/g/avto-dev/sentry-laravel/
[link_issues]:https://github.com/avto-dev/sentry-laravel/issues
[link_create_issue]:https://github.com/avto-dev/sentry-laravel/issues/new/choose
[link_commits]:https://github.com/avto-dev/sentry-laravel/commits
[link_pulls]:https://github.com/avto-dev/sentry-laravel/pulls
[link_license]:https://github.com/avto-dev/sentry-laravel/blob/master/LICENSE
[smspilot_home]:https://smspilot.ru/
[smspilot_get_api_key]:https://smspilot.ru/my-settings.php#api
[smspilot_sender_names]:https://smspilot.ru/my-sender.php
[laravel_notifications]:https://laravel.com/docs/5.5/notifications
[getcomposer]:https://getcomposer.org/download/
[package_app_version]:https://github.com/avto-dev/app-version-laravel
[package_sentry_laravel]:https://github.com/getsentry/sentry-laravel
