Symfony for Continuous Delivery
===============================

This is a skeleton project for using Symfony in a Continuous Delivery pipeline.

Used libraries for Testing:

* [Doctrine DataFixtures](https://github.com/doctrine/data-fixtures)
* [PHPUnit](https://github.com/sebastianbergmann/phpunit)
* [Behat](https://github.com/Behat/Behat) w/ [Mink](https://github.com/minkphp/Mink)

Used libraries for Continuous Delivery:

* [Doctrine Migrations](https://github.com/doctrine/migrations)
* [Lexik Maintenance](https://github.com/lexik/LexikMaintenanceBundle)

## Usage

0. Fork the project
1. Edit `parameters.yml`, `composer.json`, etc. according to your needs
2. Don't forget to create a `phpunit.xml` and `behat.yml` files!
3. Put `release.sh` and `test.sh` files in a Continuous Integration server (e.g. Jenkins, TeamCity, etc.)
4. Have fun! :)
