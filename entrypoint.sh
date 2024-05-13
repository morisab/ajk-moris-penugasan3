#!/bin/bash

sleep 60
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
service php8.2-fpm restart
service nginx restart
tail -f /dev/null