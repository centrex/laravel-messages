# CLAUDE.md

## Package Overview

`centrex/laravel-messages` — Messaging system for Laravel with models, concerns, and facades.

Namespace: `Centrex\Messages\`  
Service Provider: `MessagesServiceProvider`  
Facade: `Facades/Messages`

## Commands

Run from inside this directory (`cd laravel-messages`):

```sh
composer install          # install dependencies
composer test             # full suite: rector dry-run, pint check, phpstan, pest
composer test:unit        # pest tests only
composer test:lint        # pint style check (read-only)
composer test:types       # phpstan static analysis
composer test:refacto     # rector refactor check (read-only)
composer lint             # apply pint formatting
composer refacto          # apply rector refactors
composer analyse          # phpstan (alias)
composer build            # prepare testbench workbench
composer start            # build + serve testbench dev server
```

Run a single test:
```sh
vendor/bin/pest tests/ExampleTest.php
vendor/bin/pest --filter "test name"
```

## Structure

```
src/
  Messages.php
  MessagesServiceProvider.php
  Facades/
  Commands/
  Concerns/
  Models/
config/config.php
database/migrations/
tests/
workbench/
```

## Key Concepts

- `Concerns/` traits: add to any model to make it messageable
- `Models/Message`: stores message content, sender, recipient polymorphically
- Supports thread-based or direct messaging patterns

## Conventions

- PHP 8.2+, `declare(strict_types=1)` in all files
- Pest for tests, snake_case test names
- Pint with `laravel` preset
- Rector targeting PHP 8.3 with `CODE_QUALITY`, `DEAD_CODE`, `EARLY_RETURN`, `TYPE_DECLARATION`, `PRIVATIZATION` sets
- PHPStan at level `max` with Larastan
