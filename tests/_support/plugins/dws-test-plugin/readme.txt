=== DWS WordPress Framework Test Plugin ===

Contributors: Antonius Hegyes, Deep Web Solutions GmbH
Requires at least: 5.4
Tested up to: 5.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

[![Build Status](https://travis-ci.org/Deep-Web-Solutions-GmbH/wordpress-framework-test-plugin.svg?branch=master)](https://travis-ci.org/Deep-Web-Solutions-GmbH/wordpress-framework-test-plugin)

A barebones WP plugin based on the DWS WP Framework used for running tests.

== Contributing ==

If you have discovered any problems with this code, please open an issue on GitHub. We really, really appreciate it!

If you want to make some changes yourself that you think would benefit the whole community, feel free to fork this
repository and make a pull request.

== Frequently Asked Questions ==

* What does this plugin do?

This WP plugin doesn't really have a use on its own. It was built as an empty shell that hosts other DWS WordPress Framework
libraries in Codeception tests on Travis CI.

* How do I use this?

This answer will explain how to prepare the plugin for testing a DWS WordPress Framework.

Clone this repository inside the library's /tests/_support folder (preferably inside a 'plugins' sub-folder). Modify
the 'composer.json' file to require the DWS library you want to test (you probably want to use the 'master@dev' dependency
version) and any dependencies you still need.

Configure your Travis-CI configuration file for the DWS library to install WordPress, copy and activate your _support copy
of the plugin inside WP's plugins folders, and whatever else you need to run the tests on the current version of the library.

== Changelog ==

= 1.0.0 (May 1, 2020) =
* First official release.