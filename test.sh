#!/bin/bash

################################################################################
# Run all PHPUnit tests for this project
################################################################################

# Change to this project's root directory
cd $(dirname "$0")

# Variables
phpUnitBin="vendor/bin/phpunit"

# If PHPUnit is not installed, install it (via Composer) now
if [[ ! -f $phpUnitBin ]]
then
    sudo composer install
fi

# Run the PHPUnit test
if [[ -f $phpUnitBin ]]
then
    chmod 775 $phpUnitBin
    $phpUnitBin
else
    echo "PHPUnit has not been added to composer. Do so in order to run these tests."
fi
