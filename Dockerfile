FROM ubuntu:latest

# Install required packages
RUN apt-get update && apt-get install -y \
    software-properties-common \
    curl \
    git \
    nginx \
    nodejs \
    npm \
    unzip && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-cli \
    php8.2-curl \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    npm install --global yarn && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Copy only composer and yarn dependency files
COPY composer.json composer.lock /var/www/html/
COPY package.json yarn.lock /var/www/html/

WORKDIR /var/www/html

# Install composer and yarn dependencies
RUN composer install && \
    yarn --ignore-engines && \
    yarn build

# Copy the rest of the application files
COPY . /var/www/html

RUN chmod -R 777 /var/www/html

COPY .env.example /var/www/html/.env

RUN chown -R www-data:www-data /var/www/html/storage/logs/

COPY nginx-template.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default
RUN chmod +x entrypoint.sh

EXPOSE 80

CMD ["./entrypoint.sh"]
