> [!IMPORTANT]
> **This package is no longer maintained.** Folded into [`ahegyes/wp-framework-core`](https://github.com/ahegyes/wordpress-framework) as part of the v2 framework rewrite. The repository remains available for historical reference.

---

# DWS WordPress Framework - Helpers

[![GPLv3 License](https://img.shields.io/badge/License-GPL%20v3-yellow.svg)](https://opensource.org/licenses/)
[![PHP Syntax Errors](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/php-syntax-errors.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/php-syntax-errors.yml)
[![PHP Quality Assurance](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/php-quality-assurance.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/php-quality-assurance.yml)
[![Codeception Tests](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/codeception-tests.yml/badge.svg)](https://github.com/deep-web-solutions/wordpress-framework-helpers/actions/workflows/codeception-tests.yml)


## Description

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

The bootstrapper module itself will run on any PHP version back to 5.3 -- however, it will do so only to let the user know
that they should update to at least PHP 8.4. As of writing this (December 2024), more than half the WordPress installations
use version 6.7 so we won't be supporting anything below that.

If you're using older versions of either one, you should really consider upgrading at least for security reasons.

- Is this bug-free?

Hopefully yes, probably not. If you found any problems, please raise an issue on Github!


## Changelog

### 2.0.0 (TBD)
* Entire rewrite to cut down on verbosity, constants, and improve performance.
