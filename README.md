# DWS WordPress Framework - Helpers

**Contributors:** Antonius Hegyes, Deep Web Solutions GmbH  
**Requires at least:** 5.5  
**Tested up to:** 5.7  
**Requires PHP:** 7.4  
**Stable tag:** 1.1.1  
**License:** GPLv3 or later  
**License URI:** http://www.gnu.org/licenses/gpl-3.0.html  


## Description

[![Build Status](https://travis-ci.com/deep-web-solutions/wordpress-framework-helpers.svg?branch=master)](https://travis-ci.com/deep-web-solutions/wordpress-framework-helpers)
[![Maintainability](https://api.codeclimate.com/v1/badges/b777a17778d2969dfa84/maintainability)](https://codeclimate.com/github/deep-web-solutions/wordpress-framework-helpers/maintainability)

A set of helpers to kick-start WordPress development. This package is designed to contain small, helpful, static snippets 
that can be reused throughout different projects. Documentation can be found at https://docs.deep-web-solutions.com/


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
