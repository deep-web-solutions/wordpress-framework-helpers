# Changelog

## 1.7.1, 1.7.2 (February 11th, April 14th 2022)
* Removed the usage of deprecated FILTER_SANITIZE_STRING filter.
* Added new helper for converting between a filesystem path and a website URL.
* Fixed: bug in Misc::wp_parse_args_recursive when the default is an array but the passed on argument isn't.
* Small overall performance tweaks.

## 1.7.0 (January 13th, 2022)
* Updated hooks to conform to new format in the rest of the framework.
* Renamed `WP_Users::logout_user` to `WP_Users::logout` for consistency.
* Improved upon the `Request::is_type` method inline with WC deprecations in 6.0.
* Introduced a new helper class for working with constants.
* Enhanced the `Misc::wp_parse_args_recursive` helper.
* Enhanced the `Misc::get_midnight_unix_timestamp` helper.
* `AssetsHelpersTrait` no longer automatically includes the `FilesystemAwareTrait`.
* Inverted the parameter order of `Strings::replace_placeholders` for consistency.
* Better handling of error for the `Objects` helpers.
* Added more automated testing.

## 1.6.0, 1.6.1 (December 2nd, December 10th, 2021)
* Removed `Assets::wrap_string_in_style_tags` and `Assets::wrap_string_in_script_tags helpers`.
* Added methods `Assets::maybe_get_minified_path` and `Assets::maybe_get_mtime_version`.
* Better filesystem detection for assets helpers.

## 1.5.4, 1.5.5, 1.5.6 (November 16th, November 22nd, November 24th 2021)
* `Strings::maybe_cast` returns default if string is null.
* `Users::get` supports guests.
* Added new polyfill `Arrays::is_list`.

## 1.4.6, 1.5.0, 1.5.1, 1.5.2 , 1.5.3(October 27th, October 28th, October 29th, November 1st, November 3rd, 2021)
* `Users::has_roles` default logical operator is now 'or'.
* `Users::has_roles` and `Users::has_capabilities` now also accept a string as a first parameter.
* Fixed `Strings::maybe_cast` wrong placement of parenthesis.
* `Files::has_extension` now uses the newly-introduced `Strings::maybe_prefix` helper.
* Make use of `wp_normalize_path` for better support of cross-OS website migrations.
* RequestTypesEnum was removed. Use strings.
* Moved the WordPress subnamespace one level up.
* Asset handle and hook tag extras can now be a single string as well.
* Enhanced the asset helpers trait.

## 1.4.2, 1.4.3, 1.4.4, 1.4.5 (September 9th, September 15th, September 18th, September 23rd, 2021)
* Special handling for trying to cast a null to boolean. Now it will return the default instead of false.
* Made coding rules exceptions more specific.
* Improved REST API detection to remove false positives on AJAX requests.
* Added new helpful string helpers.
* Fixed the default of `Strings::maybe_cast`.

## 1.4.1 (August 19th, 2021)
* Changed the joining separator for hooks tags.

## 1.4.0 (May 28th, 2021)
* New validation & sanitization API.
* Most old validation API has been renamed to casting.
* Added array validation.
* Replaced all references to `sprintf` with `wp_sprintf`.
* Fixed some bugs in the `Users` class.
* Overall performance tweaks.

## 1.3.2, 1.3.3 (May 25th, 2021)
* Added more security helpers.
* Tweaked validation helpers.
* Added defaults for the $default argument for validation helpers.

## 1.3.1 (May 22rd, 2021)
* Tweaked data type resolvers to handle more cases.
* Added string validation helpers.

## 1.3.0 (May 21nd, 2021)
* Added new data type helpers for resolving a value from a potential callable.

## 1.2.1 (April 23rd, 2021)
* Migrated from Travis CI to Github Actions.
* Documentation updates.

## 1.2.0 (April 11th, 2021)
* Added new object helpers for working with trait inheritance.
* Helper Objects::class_uses_deep_list are now guaranteed to return the traits in declaration order top-bottom.
* The helper Objects::class_uses_deep now returns a tree-like structure of the inheritance pattern.

## 1.1.2 (April 9th, 2021)
* Updated development tools.

## 1.1.1 (April 2nd, 2021)
* Updated version constant.

## 1.1.0 (April 2nd, 2021)
* Improved safe-string formation.
* Added more string transformation helpers.

## 1.0.2 (March 19th, 2021)
* Created an export of all used WP functions and classes.
* Tweaked development tools configurations.
* Added some missing ABSPATH guards and backslashes to disambiguate global namespace references.
* Enhanced an arrays helper (edge-case).

## 1.0.1 (March 16th, 2021)
* Tweaked the `dws_wp_framework_get_helpers_init_status` function.

## 1.0.0 (March 16th, 2021)
* First official release.
