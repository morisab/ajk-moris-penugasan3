# Penugasan 3 AJK - CI/CD

Penugasan 3 AJK, menerapkan implementasi CI/CD pada aplikasi Tamiyochi menggunakan Github Actions dan Docker. <br>
Dikerjakan oleh Mohammad Idris Arif Budiman (5025221114)

## Daftar Isi

- [Deskripsi](#deskripsi)
- [Docker](#docker)
- [Github Actions](#github-actions)
- [Cara Kerja](#cara-kerja)
- [Screenshot](#screenshot)

## Deskripsi

Penugasan ini bertujuan untuk menerapkan CI/CD pada aplikasi Tamiyochi menggunakan Github Actions dan Docker. Ketika terjadi perubahan pada repository Github, Github Actions akan melakukan proses build, membuat image baru, dan mengupdate image pada Docker Hub. Selanjutnya, di server hanya perlu melakukan pull image dan menjalankan container baru.

## Docker

Dibuat Dockerfile dan docker-compose.yml untuk melakukan kontainerisasi aplikasi Tamiyochi. Dockerfile digunakan untuk membuat image aplikasi Tamiyochi. Dockerfile ini terdapat pada repository Github. Selain itu, docker-compose.yml digunakan untuk menjalankan container aplikasi Tamiyochi. Docker-compose.yml ini terdapat pada server.

### Dockerfile

```Dockerfile
FROM ubuntu:latest

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

COPY . /var/www/html

RUN chmod -R 777 /var/www/html

COPY .env.example /var/www/html/.env

WORKDIR /var/www/html

RUN composer install && \
    yarn --ignore-engines && \
    yarn build

RUN chown -R www-data:www-data /var/www/html/storage/logs/

COPY nginx-template.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default
RUN chmod +x entrypoint.sh

EXPOSE 80

CMD ["./entrypoint.sh"]
```

**Penjelasan:** <br>
- `FROM ubuntu:latest` : Menggunakan image Ubuntu sebagai base image.
- `RUN apt-get update && apt-get install -y ...` : Menginstall beberapa package yang dibutuhkan.
- `COPY . /var/www/html` : Menyalin seluruh file pada repository ke dalam container.
- `RUN chmod -R 777 /var/www/html` : Mengubah permission seluruh file pada repository.
- `COPY .env.example /var/www/html/.env` : Menyalin file .env.example ke file .env dalam container.
- `WORKDIR /var/www/html` : Menentukan working directory.
- `RUN composer install && ...` : Menjalankan perintah composer install dan yarn build.
- `RUN chown -R www-data:www-data /var/www/html/storage/logs/` : Mengubah ownership dari folder storage/logs.
- `COPY nginx-template.conf /etc/nginx/sites-enabled/` : Menyalin file nginx-template.conf ke dalam container. File ini digunakan sebagai konfigurasi Nginx untuk aplikasi Tamiyochi.
- `RUN rm /etc/nginx/sites-enabled/default` : Menghapus file default pada folder sites-enabled.
- `RUN chmod +x entrypoint.sh` : Mengubah permission file entrypoint.sh menjadi executable.
- `EXPOSE 80` : Menentukan port yang akan di-expose oleh container. 
- `CMD ["./entrypoint.sh"]` : Menjalankan file entrypoint.sh. File ini berisi perintah seperti pada script bash di bawah ini.

```bash
#!/bin/bash

sleep 60
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
service php8.2-fpm restart
service nginx restart
tail -f /dev/null
```

- `sleep 60` : Menunggu 60 detik. Ini untuk memastikan bahwa container mysql sudah berjalan sehingga perintah selanjutnya dapat dieksekusi.
- `php artisan key:generate` : Membuat key baru untuk aplikasi Laravel.
- `php artisan migrate` : Menjalankan migration untuk membuat tabel-tabel yang dibutuhkan.
- `php artisan db:seed` : Menjalankan seeder untuk mengisi data ke dalam tabel.
- `php artisan storage:link` : Membuat symlink dari folder storage ke folder public.
- `service php8.2-fpm restart` : Restart service php8.2-fpm untuk menerapkan perubahan.
- `service nginx restart` : Restart service nginx untuk menerapkan perubahan.

### docker-compose.yml

```yaml
version: "3.8"

services:
  mysql:
    image: mysql
    container_name: database
    restart: always
    environment:
      MYSQL_DATABASE: pbkk
      MYSQL_ALLOW_EMPTY_PASSWORD: "yes"
    networks:
      - laravel-network

  app:
    image: morisab/tamiyochi
    container_name: app
    ports:
      - "80:80"
    depends_on:
      - mysql
    networks:
      - laravel-network

networks:
  laravel-network:
    name: budi-net
    driver: bridge
```

**Penjelasan:** <br>
- `mysql` : Service untuk menjalankan container mysql.
    - `image: mysql` : Menggunakan image mysql sebagai base image.
    - `container name: database` : Menentukan nama container yang akan dijalankan.
    - `restart: always` : Menjalankan ulang container jika terjadi error.
    - `environment: ...` : Menentukan environment variable yang dibutuhkan.
    - `networks: ...` : Menentukan network yang digunakan.
- `app` : Service untuk menjalankan container aplikasi Tamiyochi.
    - `image: morisab/tamiyochi` : Menggunakan image aplikasi Tamiyochi yang sudah di-push ke Docker Hub.
    - `container name: app` : Menentukan nama container yang akan dijalankan.
    - `ports: ...` : Menentukan port yang akan di-expose oleh container.
    - `depends_on: ...` : Menentukan service yang harus dijalankan terlebih dahulu.
    - `networks: ...` : Menentukan network yang digunakan.
- `networks` : Menentukan network yang digunakan.
    - `name: budi-net` : Menentukan nama network yang digunakan.
    - `driver: bridge` : Menentukan driver yang digunakan.