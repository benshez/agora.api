echo Doctrine 2 Migrations v0.1
echo ==================================

php ../vendor/doctrine/migrations/bin/doctrine-migrations migrations:status

php ../vendor/doctrine/migrations/bin/doctrine-migrations migrations:migrate

php ../vendor/doctrine/migrations/bin/doctrine-migrations migrations:migrate 0

read -p "Press enter to continue"