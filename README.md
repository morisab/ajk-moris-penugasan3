# How to run the project

## Clone the repository

```sh
git clone https://github.com/mvinorian/tamiyochi-laravel
```

## Install composer dependency

```sh
composer install
```

## Install node dependency

```sh
yarn
```

## Copy environment

```sh
cp .env.example .env
```

## Change database in environment

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pbkk
DB_USERNAME=root
DB_PASSWORD=
```

## Generate laravel key

```sh
php artisan key:generate
```

## Migrate database

```sh
php artisan migrate
```

## Seed database

```sh
php artisan db:seed
```

## Link storage

```sh
php artisan storage:link
```

## Run node

```sh
yarn dev
```

## Run laravel

```sh
php artisan serve
```
