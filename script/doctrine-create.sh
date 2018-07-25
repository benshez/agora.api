echo Doctrine 2 Database Generator v0.1
echo ==================================

php ../vendor/doctrine/orm/bin/doctrine orm:schema-tool:create

php ../vendor/doctrine/orm/bin/doctrine orm:schema-tool:update

read -p "Press enter to continue"