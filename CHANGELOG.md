# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

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
