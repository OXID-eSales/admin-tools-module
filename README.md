# OXID eShop Admin-Tools Module

[![Development](https://github.com/OXID-eSales/admin-tools-module/actions/workflows/trigger.yaml/badge.svg?branch=b-7.3.x)](https://github.com/OXID-eSales/admin-tools-module/actions/workflows/trigger.yaml)
[![Latest Version](https://img.shields.io/packagist/v/OXID-eSales/admin-tools-module?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/oxid-esales/admin-tools-module)
[![PHP Version](https://img.shields.io/packagist/php-v/oxid-esales/admin-tools-module)](https://github.com/oxid-esales/admin-tools-module)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_admin-tools-module&metric=alert_status)](https://sonarcloud.io/dashboard?id=OXID-eSales_admin-tools-module)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_admin-tools-module&metric=coverage)](https://sonarcloud.io/dashboard?id=OXID-eSales_admin-tools-module)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_admin-tools-module&metric=sqale_index)](https://sonarcloud.io/dashboard?id=OXID-eSales_admin-tools-module)

This module adds admin tools to the OXID eShop Admin Backoffice, allowing admins to select and clear specific or all subshop caches via a dropdown in the header.

## Features

- Provides an admin toolbar dropdown for cache management. 
- Allows selective or complete cache removal. 
- Optionally integrates with OXAPI GraphQL for cache clearing via API.
- Includes **ShopController as a service** for better modularity.

## Branch Compatibility

* 1.x versions (or b-7.3.x branch) are compatible with latest shop compilation 7.3.x resp. b-7.3.x  shop compilation branches

### Install and activate

```bash
# Install desired version of oxid-esales/admin-tools, in this case - latest released 1.x version.
# 
$ composer require oxid-esales/admin-tools ^1.0.0 
```

You should run migrations both after installing the module and after each module update:

```bash
$ ./vendor/bin/oe-eshop-doctrine_migration migrations:migrate oe_admintools
```

```bash
# Activate the module
# 
$ ./vendor/bin/oe-console oe:module:activate oe_admintools
```

## Cache Clearing Options

This module provides **multiple cache clearing mechanisms**.  
The available options can be accessed via **Admin UI** or **OXAPI GraphQL**.

### Available Cache Removal Types

| **Cache Type**           | **Description** |
|--------------------------|----------------|
| **Template Cache**       | Removes compiled **Twig template files**. |
| **Internal Cache**       | Clears OXID eShop’s **internal caching mechanism**. |
| **Container Cache**      | Clears the **dependency injection container cache** (Symfony-based). |
| **Module Caches**        | Clears caches related to **installed modules**. |
| **All Caches**           | Performs a **complete cache reset** (combining all above caches). |

## Usage

This assumes you have OXID eShop (at least `OXID-eSales/oxideshop_ce: v7.3.0` component, which is part of the `7.3.0` compilation) up and running.

Admin Panel Usage
- Go to the Admin Backoffice. 
- Locate the Cache Clear Dropdown in the header. 
- Select the cache type you want to clear. 
- Click Clear Cache.

## OXAPI Integration

The module extends **GraphQL API (OXAPI)**, allowing cache clearing via API.

```bash
# Install and activate compatible version of oxid-esales/graphql-base, in this case - latest released 10.x version.
# 
$ composer require oxid-esales/graphql-base ^11.0.0
$ ./vendor/bin/oe-eshop-doctrine_migration migrations:migrate oe_graphql_base
$ ./vendor/bin/oe-console oe:module:activate oe_graphql_base
```

### Available GraphQL Queries

| **Query Name**             | **Functionality** |
|----------------------------|------------------|
| `clearTemplateCache`       | Clears template-related cache. |
| `clearInternalCache`       | Clears internal system cache. |
| `clearContainerCache`      | Clears DI container cache. |
| `clearModuleCaches`        | Clears module-related cache. |
| `clearCaches`              | Clears all caches at once. |


### OXAPI Authentication Requirements

To clear caches via GraphQL API, a user **must be authenticated** and have the required permissions.

### **Authentication Details**
- Requires a **valid OXAPI JWT token** in the `Authorization` header.
- The user must belong to the **"gqladmintoolscache"** user group.

### **Example GraphQL Request**
Here’s how to **clear all caches** using GraphQL.

#### **GraphQL Query**
```graphql
query {
  clearCaches
}
```

Only a logged in user with sufficient OXAPI permission will be permitted to call these queries.
'Logged in' means valid OXAPI JWT with sufficient permissions is sent in Authorization Bearer Header.
User in question must be a member of 'gqladmintoolscache' usergroup.


## Controller as a Service

The module provides **ShopController as a service**, making it **extendable, testable, and reusable**.

### **Example: ShopController**
The **ShopController** is now registered as a **service** in `Shop/Controller/services.yaml`:

```yaml
services:
  OxidEsales\AdminTools\CacheClear\Shop\Controller\ShopController:
    tags:
      - { name: 'oxid.controller', controller_key: 'admintoolscacheclear' }
    public: true
```

# Development installation on OXID eShop SDK

The installation instructions below are shown for the current [SDK](https://github.com/OXID-eSales/docker-eshop-sdk)
for shop 7.3. Make sure your system meets the requirements of the SDK.

0. Ensure all docker containers are down to avoid port conflicts

1. Clone the SDK for the new project
```shell
echo MyProject && git clone https://github.com/OXID-eSales/docker-eshop-sdk.git $_ && cd $_
```

2. Clone the repository to the source directory
```shell
git clone --recurse-submodules https://github.com/OXID-eSales/admin-tools-module.git --branch=b-7.3.x ./source
```

3. Run the recipe to setup the development environment
```shell
./source/recipes/setup-development.sh
```

You should be able to access the shop via
- Frontend http://localhost.local
- Admin Panel: http://localhost.local/admin
  - (credentials: noreply@oxid-esales.com / admin)

### Running tests locally

Check the "scripts" section in the `composer.json` file for the available commands. Those commands can be executed
by connecting to the php container and running the command from there, example:

```shell
make php
composer tests-coverage
```

Commands can be also triggered directly on the container with docker compose, example:

```shell
docker compose exec -T php composer tests-coverage
```

## License

OXID Module and Component License, see [LICENSE file](LICENSE).
