# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## Unreleased

### Changed

- Maximal `illuminate/*` packages version now is `6.*`

### Added

- GitHub actions for a tests running

## v2.1.0

### Changed

- Default environment name (in sample config) `SERVER_NAME` changed to `APP_SERVER_NAME`

## v2.0.0

### Added

- Docker-based environment for development
- Project `Makefile`

### Changed

- Minimal `PHP` version now is `^7.1.3`
- Minimal `Laravel` version now is `5.6.x`
- Maximal `Laravel` version now is `5.8.x`
- Dependency `laravel/framework` changed to `illuminate/*`
- `\AvtoDev\Sentry\SentryServiceProvider` &rarr; `\AvtoDev\Sentry\ServiceProvider`
- Composer scripts
- `sentry.php` config file stub
- Package service-provider don't register service-providers from another packages
- Package `avto-dev/app-version-laravel` is optional dependency now

### Removed

- Artisan command `sentry:init`

## v1.3.1

### Changed

- Maximal `phpunit` version now is `7.4.x`. Reason - since `7.5.0` frameworks contains assertions like `assertIsNumeric`, `assertIsArray` and others, already declared in `AdditionalAssertsTrait`

## v1.3.0

### Changed

- Maximal PHP version now is undefined
- Maximal Laravel version now is `5.7.*`
- CI changed to [Travis CI][travis]
- [CodeCov][codecov] integrated
- Issue templates updated

[travis]:https://travis-ci.org/
[codecov]:https://codecov.io/

## v1.2.0

### Changed

- Up minimal sentry package version

## v1.1.0

### Changed

- CI config updated
- Required minimal PHPUnit version now `5.7.10`
- Disabled HTML coverage report (CI errors)
- Unimportant PHPDoc blocks removed

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
