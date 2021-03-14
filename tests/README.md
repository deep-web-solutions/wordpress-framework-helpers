# How to test the package

## Setup

1) Create a WordPress test instance. You can use your preferred method of setting up development environments, e.g. VVV, Docker, Local by Flywheel etc.
1) Create a separate database for acceptance+functional tests. For example, for `DB_USER` 'wp' and `DB_HOST` 'localhost':

    * mysql -u root -p -e "CREATE DATABASE if not exists helpers_tests"
    * mysql -u root -p -e "GRANT ALL PRIVILEGES ON helpers_tests.* TO 'wp'@'localhost';"

1) Copy the `_support/dws-wp-helpers-test-plugin` folder to your instance's `wp-content/plugins` folder and install dependencies with `composer install --ignore-platform-reqs`.
1) Copy the `.dist.env` file to `.env.testing` and fill in your local environment variables.
1) Copy the `codeception.local.yml` file to `codeception.yml` and adjust, if needed.


## Running Tests

#### Integration tests

From the test plugin's directory, run `./vendor/bin/codeception run wpunit` or `composer run-script test:integration`.

#### Unit tests

From the test plugin's directory, run `./vendor/bin/codeception run unit` or `composer run-script test:unit`.
