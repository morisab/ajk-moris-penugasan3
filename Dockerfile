FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache \
    npm \
    curl \
    git \
    unzip \
    bash && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    npm install -g yarn && \
    docker-php-ext-install pdo_mysql

COPY . /var/www/html

RUN chmod -R 777 /var/www/html

COPY .env.example /var/www/html/.env

WORKDIR /var/www/html

RUN composer install && yarn && yarn build

EXPOSE 9000

CMD ["./entrypoint.sh"]
