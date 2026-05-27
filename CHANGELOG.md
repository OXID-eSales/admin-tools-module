# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [undecided] - unreleased

### Changed
- Update module to work with OXID eShop 7.6

## [2.0.0] - 2026-05-13

### Added
- Template chain cache clearing support (admin dropdown option and `clearTemplateChainCache` GraphQL mutation)
- GraphQL schema cache clearing support via `clearGraphQLSchemaCache` GraphQL mutation (only reachable when `oe_graphql_base` is active)
- Event subscriber `InvalidateGraphQLSchemaCacheEventSubscriber` that clears the GraphQL schema cache on `ClearShopCacheEvent` 

### Changed
- Updated to work with OXID eShop 7.5.x
- Minimum PHP version is now 8.3, tested up to PHP 8.5
- GraphQL cache clear operations changed from queries to mutations
- `ServiceInterface` extended with `clearCurrentShopTemplateChainCache()` and `clearCurrentShopGraphQLSchemaCache()`


## [1.1.0] - 2025-11-06

### Changed
- Update to work with OXID eShop 7.4.x

## [1.0.0] - 2025-06-11

### Changed
- Update install instructions in readme

## [1.0.0-rc.1] - 2025-04-25

### Added
- First version of the module

[2.0.0]: https://github.com/OXID-eSales/admin-tools-module/compare/v1.1.0...v2.0.0
[1.1.0]: https://github.com/OXID-eSales/admin-tools-module/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/OXID-eSales/admin-tools-module/compare/v1.0.0-rc.1...v1.0.0
[1.0.0-rc.1]: https://github.com/OXID-eSales/admin-tools-module/releases/tag/v1.0.0-rc.1