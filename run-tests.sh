#!/bin/bash

################################################################################
# Run all PHPUnit tests for this project
################################################################################

# Change to this project's root directory
cd $(dirname "$0")

# Variables
phpUnitPath="vendor/bin/phpunit"

# If PHPUnit is not installed, install it (via Composer) now
if [[ ! -f $phpUnitPath ]]
then
    sudo composer install
fi

# Run the PHPUnit test
if [[ -f $phpUnitPath ]]
then
    sudo chmod 775 $phpUnitPath
    $phpUnitPath
else
    echo "PHPUnit has not been added to composer. Do so in order to run these tests."
fi
