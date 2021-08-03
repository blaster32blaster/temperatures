#!/bin/bash
ENV=/var/www/html/.env
EXAMPLE=/var/www/html/.env.example
    if [ -f "$ENV" ]
    then
        echo "$ENV exists, not creating"
    else
        echo "$ENV doesn't exist, checking for example to copy ..."
        if [ -f "$EXAMPLE" ]
        then
            echo "$EXAMPLE does exist, copying to .env"
            cp /var/www/html/.env.example /var/www/html/.env
        else
            echo ".env.example not found, .env not created"
        fi
    fi

echo "running composer install"
cd /var/www/html &&
composer install

echo "running migrate install"
cd /var/www/html &&
php artisan migrate:install

echo "running migrate"
cd /var/www/html &&
php artisan migrate

echo "running seeders"
cd /var/www/html &&
php artisan db:seed

echo "running world:init"
cd /var/www/html &&
php artisan world:init

echo "running npm install"
cd /var/www/html &&
npm install

echo "creating storage link"
cd /var/www/html &&
php artisan storage:link

echo "running npm run dev"
cd /var/www/html &&
npm run dev

apachectl -D FOREGROUND
