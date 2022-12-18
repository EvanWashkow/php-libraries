# PHP Libraries

This is a common set of libraries that bring PHP into the 21st century, creating a far more sane - and safe - development experience.

It is specifically designed to handle PHP, so you don't have to, with strict types and solid object-oriented design practices from a developer with 10+ years of experience. This means, no more indeterminate types and no more trying to track down a bunch of functions (looking at you arrays).

This library adheres to PSR-12 standards and best software design practices such as S.O.L.I.D., resulting in very flexible and maintainable code. It is also extremely well tested, following real T.D.D. strategies.

## Components

1. [Types](./src/Type)
2. [Type Interfaces](./src/TypeInterface)

## Local Development Setup
1. Install
   1. Docker
   2. NPM
2. In a terminal shell, run `bin/init`
3. While working, periodically run
   * `bin/unitTest`
   * `bin/phpinsights fix -- src tests`

## Local Development
* Composer
  * `bin/composer install`: installs packages from the versions specified in the `composer.lock` file
  * `bin/composer update`: updates packages and updates their version numbers in the `composer.lock` file
* PHPInsights
  * `bin/phpinsights`: check code quality of `src` (default)
  * `bin/phpinsights fix -- src tests`: run code fixer
  * `bin/phpinsights analyse -- src tests`: check code quality of `src` and `tests`
  * `bin/phpinsights --help`: help docs