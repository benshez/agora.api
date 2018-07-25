#!/bin/sh

# Doctrine 2 Entities Generator v0.1
# ==================================

# Requirements
# ============
# It's necessary to create a composer project before exec this script.
# More info about composer at https://getcomposer.org/doc/00-intro.md


echo Doctrine 2 Entities Generator v0.1
echo ==================================

# Remove ./mapping directory before
rm -rf ./mapping

# Create mapping directory
mkdir ./mapping
mkdir ./mapping/yaml
mkdir ./mapping/xml
mkdir ./mapping/entities

# Read the ./cli-config.php (by default) and generate mapping yaml files to ./config/yaml directory
php ./vendor/doctrine/orm/bin/doctrine orm:convert-mapping --namespace="AgoraApi\\Application\\Entities\\" --force --from-database yml ./mapping/yaml

# Read the ./cli-config.php (by default) and generate mapping yaml files to ./config/yaml directory
php ./vendor/doctrine/orm/bin/doctrine orm:convert-mapping --namespace="AgoraApi\\Application\\Entities\\" --force --from-database xml ./mapping/xml

# Generate models to ./src directory
php ./vendor/doctrine/orm/bin/doctrine orm:generate-entities --generate-annotations=false --update-entities=true --generate-methods=false ./mapping/entities

# Update schema
php ./vendor/doctrine/orm/bin/doctrine orm:schema-tool:update --force --complete --dump-sql

# Validate schema
php ./vendor/doctrine/orm/bin/doctrine orm:validate-schema

read -p "Press enter to continue"