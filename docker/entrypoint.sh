#!/bin/sh

#On error no such file entrypoint.sh, execute in terminal - dos2unix .docker\entrypoint.sh --env=test
composer install
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console lexik:jwt:generate-keypair --skip-if-exists

php-fpm
