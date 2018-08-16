# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [1.0.1] - 2018-08-16
- Override `createFromFormat` method to return WordPress DateTime object.
- Use new `create_from_format` method instead of override, due to method signature Travis errors for different PHP versions.
- Improved support for timezones.

## 1.0.0
- First release.

[unreleased]: https://github.com/pronamic/wp-datetime/compare/1.1.0...HEAD
[1.1.0]: https://github.com/pronamic/wp-datetime/compare/1.0.0...1.1.0
