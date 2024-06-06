FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache \
    npm \
    curl \
    git \
    unzip \
    bash && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    npm install -g yarn && \
    docker-php-ext-install pdo pdo_mysql

COPY ./Tamiyochi/ /var/www/html/

COPY ./Tamiyochi/.env.example /var/www/html/.env

WORKDIR /var/www/html

RUN composer install --no-dev --no-interaction --no-progress --no-suggest --quiet

RUN yarn && yarn build

RUN chmod -R 777 /var/www/html/ && chown -R www-data:www-data /var/www/html/

EXPOSE 9000

CMD ["./entrypoint.sh"]