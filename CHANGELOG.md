# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [1.2.1] - 2021-04-26
- Happy 2021.

## [1.2.0] - 2020-10-08
- Added DateTimeImmutable class.
- Added `DateTime::create_from_immutable( \DateTimeImmutable $object )` method.
- Added `DateTimeImmutable::create_from_mutable( \DateTime $object )` method.
- Override upstream `DateTime::createFromImmutable( $object )` method.
- Override upstream `DateTimeImmutable::createFromMutable( $object )` method.
- Override upstream `DateTimeInterface::createFromFormat( $format, $time, $timezone = null )` method.
- Updated copyright.

## [1.1.1] - 2019-12-17
- Fix for WordPress core trac ticket 48319 (https://core.trac.wordpress.org/ticket/48319).
- Updated PHP compatibility test version to PHP 5.6.
- Updated tests.

## [1.1.0] - 2019-08-26
- Introduced a format translate function, will not switch to local timezone.

## [1.0.2] - 2018-09-12
- Fixed issue on PHP 5.6 or lower.

## [1.0.1] - 2018-08-16
- Override `createFromFormat` method to return WordPress DateTime object.
- Use new `create_from_format` method instead of override, due to method signature Travis errors for different PHP versions.
- Improved support for timezones.

## 1.0.0
- First release.

[unreleased]: https://github.com/pronamic/wp-datetime/compare/1.2.1...HEAD
[1.2.1]: https://github.com/pronamic/wp-datetime/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/pronamic/wp-datetime/compare/1.1.1...1.2.0
[1.1.1]: https://github.com/pronamic/wp-datetime/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/pronamic/wp-datetime/compare/1.0.2...1.1.0
[1.0.2]: https://github.com/pronamic/wp-datetime/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/pronamic/wp-datetime/compare/1.0.0...1.0.1
