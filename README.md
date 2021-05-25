# DWS WordPress Framework - Helpers

**Contributors:** Antonius Hegyes, Deep Web Solutions GmbH  
**Requires at least:** 5.5  
**Tested up to:** 5.7  
**Requires PHP:** 7.4  
**Stable tag:** 1.3.4  
**License:** GPLv3 or later  
**License URI:** http://www.gnu.org/licenses/gpl-3.0.html  


## Description

[![GPLv3 License](https://img.shields.io/badge/License-GPL%20v3-yellow.svg)](https://opensource.org/licenses/)
[![PHP Syntax Errors](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/php-syntax-errors.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/php-syntax-errors.yml)
[![WordPress Coding Standards](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/wordpress-coding-standards.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/wordpress-coding-standards.yml)
[![Codeception Tests](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/codeception-tests.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/codeception-tests.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/b777a17778d2969dfa84/maintainability)](https://codeclimate.com/github/deep-web-solutions/wordpress-framework-helpers/maintainability)

A set of helpers to kick-start WordPress development. This package is designed to contain small, helpful, static snippets 
that can be reused throughout different projects.


## Documentation

Documentation for this module and the rest of the DWS WP Framework can be found [here](https://framework.deep-web-solutions.com/helpers-module/motivation).


## Installation

The package is designed to be installed via Composer. It may work as a stand-alone but that is not officially supported.
The package's name is `deep-web-solutions/wp-framework-helpers`.

If the package will be used outside a composer-based installation, e.g. inside a regular WP plugin, you should install
using the `--ignore-platform-reqs` option. If you don't do that, the bundled `DWS WordPress Framework - Bootstrapper` package 
will only be able to perform checks for the WordPress version because composer will throw an error in case of an incompatible PHP version.


## Contributing

Contributions both in the form of bug-reports and pull requests are more than welcome!


## Frequently Asked Questions

- Will you support earlier versions of WordPress and PHP?

Unfortunately not. PHP 7.3 is close to EOL (March 2021), and we consider 7.4 to provide a few features that are absolutely amazing.
Moreover, WP 5.5 introduced a few new features that we really want to use as well, and we consider it to be one of the first versions
of WordPress to have packed a more-or-less mature version of Gutenberg.

If you're using older versions of either one, you should really consider upgrading at least for security reasons.

- Is this bug-free?

Hopefully yes, probably not. If you found any problems, please raise an issue on Github!


## Changelog

### 1.3.4 (TBD)
* Added array validation.

### 1.3.2, 1.3.3 (May 25th, 2021)
* Added more security helpers.
* Tweaked validation helpers.
* Added defaults for the $default argument for validation helpers.

### 1.3.1 (May 22rd, 2021)
* Tweaked data type resolvers to handle more cases.
* Added string validation helpers.

### 1.3.0 (May 21nd, 2021)
* Added new data type helpers for resolving a value from a potential callable.

### 1.2.1 (April 23rd, 2021)
* Migrated from Travis CI to Github Actions.
* Documentation updates.

### 1.2.0 (April 11th, 2021)
* Added new object helpers for working with trait inheritance.
* Helper Objects::class_uses_deep_list are now guaranteed to return the traits in declaration order top-bottom.
* The helper Objects::class_uses_deep now returns a tree-like structure of the inheritance pattern.

### 1.1.2 (April 9th, 2021)
* Updated development tools.

### 1.1.1 (April 2nd, 2021)
* Updated version constant.

### 1.1.0 (April 2nd, 2021)
* Improved safe-string formation.
* Added more string transformation helpers.

### 1.0.2 (March 19th, 2021)
* Created an export of all used WP functions and classes.
* Tweaked development tools configurations.
* Added some missing ABSPATH guards and backslashes to disambiguate global namespace references.
* Enhanced an arrays helper (edge-case).

### 1.0.1 (March 16th, 2021)
* Tweaked the `dws_wp_framework_get_helpers_init_status` function.

### 1.0.0 (March 16th, 2021)
* First official release.
