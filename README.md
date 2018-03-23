<p align="center">
  <img src="https://sentry-brand.storage.googleapis.com/sentry-logo-black.png" alt="Sentry" width="240" />
</p>

# Sentry for Laravel applications

[![Version][badge_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![StyleCI][badge_styleci]][link_styleci]
[![Coverage][badge_coverage]][link_coverage]
[![Code Quality][badge_quality]][link_coverage]
[![Issues][badge_issues]][link_issues]
[![License][badge_license]][link_license]
[![Downloads count][badge_downloads_count]][link_packagist]

Данный пакет предназначен для того, чтоб упростить работу c Sentry, так как:

 - Данные, отправляемые на сервер Sentry "подписываются" текущей версией приложения (которую возвращает пакет `avto-dev/app-version-laravel`);
 - Конфигурационный файл `./config/sentry.php` имеет более подробную документацию.

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require avto-dev/sentry-laravel "^1.0"
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

### Тестирование

Для тестирования данного пакета используется фреймворк `phpunit`. Для запуска тестов выполните в терминале:

```shell
$ git clone git@github.com:avto-dev/sentry-laravel.git ./sentry-laravel && cd $_
$ composer install
$ composer test
```

## Поддержка и развитие

Если у вас возникли какие-либо проблемы по работе с данным пакетом, пожалуйста, создайте соответствующий `issue` в данном репозитории.

Если вы способны самостоятельно реализовать тот функционал, что вам необходим - создайте PR с соответствующими изменениями. Крайне желательно сопровождать PR соответствующими тестами, фиксирующими работу ваших изменений. После проверки и принятия изменений будет опубликована новая минорная версия.

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].

[badge_version]:https://img.shields.io/packagist/v/avto-dev/sentry-laravel.svg?style=flat&maxAge=30
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/sentry-laravel.svg?style=flat&maxAge=30
[badge_license]:https://img.shields.io/packagist/l/avto-dev/sentry-laravel.svg?style=flat&maxAge=30
[badge_build_status]:https://scrutinizer-ci.com/g/avto-dev/sentry-laravel/badges/build.png?b=master
[badge_styleci]:https://styleci.io/repos/126222307/shield
[badge_coverage]:https://scrutinizer-ci.com/g/avto-dev/sentry-laravel/badges/coverage.png?b=master
[badge_quality]:https://scrutinizer-ci.com/g/avto-dev/sentry-laravel/badges/quality-score.png?b=master
[badge_issues]:https://img.shields.io/github/issues/avto-dev/sentry-laravel.svg?style=flat&maxAge=30
[link_packagist]:https://packagist.org/packages/avto-dev/sentry-laravel
[link_styleci]:https://styleci.io/repos/126222307/
[link_license]:https://github.com/avto-dev/sentry-laravel/blob/master/LICENSE
[link_build_status]:https://scrutinizer-ci.com/g/avto-dev/sentry-laravel/build-status/master
[link_coverage]:https://scrutinizer-ci.com/g/avto-dev/sentry-laravel/?branch=master
[link_issues]:https://github.com/avto-dev/sentry-laravel/issues
[getcomposer]:https://getcomposer.org/download/
[package_app_version]:https://github.com/avto-dev/app-version-laravel
[package_sentry_laravel]:https://github.com/getsentry/sentry-laravel
