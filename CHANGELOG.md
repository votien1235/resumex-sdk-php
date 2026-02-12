# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2026-02-12

### Added

- Support for Japanese CV template (`professional-grid`) with `webCv` field
- Comprehensive field reference documentation for all templates
- Example code for Japanese CV (履歴書) generation

### Changed

- Updated API payload structure to flat format (non-breaking, backwards compatible)
- Improved documentation with separate examples for standard CV and Japanese CV
- Updated Complete Integration Example with modern payload structure

### Fixed

- Fixed HMAC signature generation for Unicode characters (Japanese text)
- Use `JSON_UNESCAPED_UNICODE` flag for consistent signature calculation

### Documentation

- Added Field Reference section with tables for all supported fields
- Added Japanese CV specific fields documentation (webCv)
- Updated code examples throughout README

## [1.0.0] - 2026-02-11

### Added

- Initial release
- `Client` class with HMAC-SHA256 signature authentication
- `CV` resource: generate, get, enhance, delete methods
- `Partner` resource: getQuota, getUsage, getDashboard methods
- `Templates` resource: list, get methods
- Laravel Service Provider with auto-discovery
- Laravel Facade for easy usage
- Comprehensive error handling with `ResumeXException`
- Configuration file for Laravel
- Full documentation and examples
