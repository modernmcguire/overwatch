# Changelog

All notable changes to `overwatch` will be documented in this file.

## 2.0.0 - Laravel 11, 12 & 13 support - 2026-08-28

Adds Laravel 13 support, tightens the version constraints, and fixes three things that were quietly broken. **This is a major release — see Upgrading below.**

### Breaking changes

**Minimum versions raised to PHP 8.2 and Laravel 11.** Laravel 8, 9, and 10 are all past security EOL and can't coexist with Laravel 13-era tooling.

**Constraints are bounded again.** 1.4.0 shipped with unbounded minimums (`illuminate/contracts: >=8.0`), which let composer install any future major untested. Those are now explicit ranges:

| | 1.4.0 | 2.0.0 |
|---|---|---|
| `php` | `^7.4\|^8.0` | `^8.2` |
| `illuminate/contracts` | `>=8.0` | `^11.0\|^12.0\|^13.0` |
| `illuminate/routing` | `>=8.0` | `^11.0\|^12.0\|^13.0` |
| `spatie/laravel-package-tools` | `^1.0` | `^1.92` |

#### Upgrading

If you're on Laravel 11 or newer, `composer update modernmcguire/overwatch` is all it takes — there are no API changes.

If you're on Laravel 10 or older, stay on `^1.4` until you upgrade the framework. One thing to check either way: if any of your metrics define `const KEY`, that override **now actually takes effect** (see below), so the key in your Overwatch payload will change from the snake-cased class name to your `KEY` value. Anything consuming those keys downstream needs to expect the corrected name.

### Fixes

- **The documented `const KEY` override never worked.** `Overwatch::run()` called `defined($class::KEY)`, which passes the constant's *value* to `defined()` rather than its name — so a metric declaring `KEY = 'app_users'` was still keyed `total_users`, and the `null` default emitted a PHP 8.1+ deprecation on every single metric. Now resolved with `$class::KEY ?? Str::snake(...)`, covered by a regression test.
- **The test suite was running zero tests while reporting success.** `phpunit.xml.dist` declared `<coverage>` reports, which makes PHPUnit 12 abort with `No code coverage driver available` and exit 0 without running anything. Coverage still works via `composer test-coverage`.
- **PHPStan config was a hard error** under PHPStan 2 / Larastan 3 (`checkMissingIterableValueType` was removed). Also added `configDirectories` so Larastan's `noEnvCallsOutsideOfConfig` rule stops false-positiving on `config/overwatch.php`.
- README metric examples imported `Modernmcguire\Overwatch\Metric`; the class is actually `Modernmcguire\Overwatch\Metrics\Metric`.

### Tooling

`nunomaduro/larastan` → `larastan/larastan: ^3` (the old package is abandoned), plus testbench `^9|^10|^11`, canvas `^9|^10|^11`, Pest `^3|^4`, collision `^8`, and PHPStan rules `^2`.

CI now covers **PHP 8.2–8.5 × Laravel 11/12/13** (20 combinations, all green) instead of Laravel 10 alone. Workflow actions bumped to current majors: `actions/checkout` v3→v7, `git-auto-commit-action` v4→v7, `ramsey/composer-install` v2→v4, `dependabot/fetch-metadata` v1.6→v3.1, `laravel-pint-action` 2.3→2.6. This supersedes #17 and #18.

**Full changelog**: https://github.com/modernmcguire/overwatch/compare/1.4.0...2.0.0

## 1.4.0 - 2026-01-21

**Full Changelog**: https://github.com/modernmcguire/overwatch/compare/1.3.0...1.4.0

## Laravel 11 Support - 2024-05-07

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.2.0 to 2.3.0 by @dependabot in https://github.com/modernmcguire/overwatch/pull/13
* Bump dependabot/fetch-metadata from 1.4.0 to 1.5.1 by @dependabot in https://github.com/modernmcguire/overwatch/pull/14
* Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/modernmcguire/overwatch/pull/16

**Full Changelog**: https://github.com/modernmcguire/overwatch/compare/1.2.0...1.3.0

## 1.2.0 - 2023-05-02

- Refactor to allow for expansion of entry points
- Add `overwatch:metrics` command
- Rename `overwatch:generate` command
- Introduce Metric base class

**Full Changelog**: https://github.com/modernmcguire/overwatch/compare/1.1.4...1.2.0

## 1.1.4 - 2023-05-01

### What's Changed

- - added timezone check by @gnarhard in https://github.com/modernmcguire/overwatch/pull/12
  
- 
- 
- - added helper text after command by @gnarhard in https://github.com/modernmcguire/overwatch/pull/11
  
- 
- 

**Full Changelog**: https://github.com/modernmcguire/overwatch/compare/v1.1.2...1.1.4

## v1.1.3 - 2023-05-01

Added output text after running secret generation command.

## v1.1.0 - 2023-04-28

Uses a custom encryption key instead of the app key.

## 1.0.1 - 2023-04-28

**Full Changelog**: https://github.com/modernmcguire/overwatch/compare/0.0.3...1.0.1

## v1.0.0 - 2023-04-27

**Full Changelog**: https://github.com/modernmcguire/overwatch/compare/0.0.3...v1.0.0

## v0.0.3 - 2023-04-27

Added PHP version first-party data.
