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

```

Dockerfile ini digunakan untuk membuat image aplikasi Tamiyochi. Menggunakan base image php:8.2-fpm-alpine. Kemudian, melakukan update dan install beberapa package yang dibutuhkan, seperti npm, curl, git, unzip, bash, dan composer. Selanjutnya, menginstall composer dan yarn. Kemudian, menginstall ekstensi pdo_mysql untuk menghubungkan aplikasi dengan database MySQL. Selanjutnya, menyalin kode aplikasi ke dalam container dan mengubah permission file. Menyalin file .env.example ke dalam container. Menjalankan perintah composer install dan yarn untuk menginstall dependency aplikasi. Terakhir, mengekspose port 9000 dan menjalankan script entrypoint.sh.

#### entrypoint.sh

```bash
#!/bin/bash

php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php-fpm
```

Script entrypoint.sh ini digunakan untuk menjalankan beberapa perintah saat container dijalankan. Pertama, script ini akan mengenerate key baru untuk aplikasi, melakukan migrasi database, melakukan seeding database, dan membuat symlink untuk storage. Terakhir, script ini akan menjalankan php-fpm untuk menjalankan aplikasi.


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
    healthcheck:
      test: ["CMD", "mysqladmin" ,"ping", "-h", "localhost"]
      timeout: 20s
      retries: 10

  app:
    image: morisab/tamiyochi:latest
    container_name: app
    networks:
      - laravel-network
    depends_on:
      mysql:
        condition: service_healthy

  nginx:
    image: nginx:latest
    container_name: nginx
    ports:
      - "80:80"
    volumes:
      - ./nginx.conf:/etc/nginx/nginx.conf
    networks:
      - laravel-network
    depends_on:
      - app

networks:
  laravel-network:
    name: budi-net
    driver: bridge
```

File docker-compose.yml ini digunakan untuk menjalankan container aplikasi Tamiyochi. File ini terdiri dari tiga service, yaitu mysql, app, dan nginx. Service mysql digunakan untuk menjalankan database MySQL. Service app digunakan untuk menjalankan aplikasi Tamiyochi. Service nginx digunakan untuk menjalankan web server Nginx. Service app akan bergantung pada service mysql dan service nginx akan bergantung pada service app. File ini juga mendefinisikan sebuah network yang digunakan oleh ketiga service tersebut.

#### nginx.conf

```
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

File nginx.conf ini digunakan untuk konfigurasi Nginx. File ini akan digunakan oleh service nginx pada docker-compose.yml. File ini akan mengatur Nginx untuk mendengarkan pada port 80, mengarahkan root direktori ke /var/www/html/public, dan mengatur konfigurasi PHP-FPM.

## Github Actions
Pada repository Github, dibuat file `.github/workflows/deploymen.yml` untuk melakukan proses CI/CD menggunakan Github Actions. File ini akan dijalankan setiap kali terjadi perubahan pada repository Github. File ini akan melakukan proses build, membuat image baru, mengupdate image pada Docker Hub, dan menjalankan docker-compose di server. Berikut adalah isi file `deployment.yml`:

```yaml
name: Docker build and deploy

on:
  push:
    branches:
      - main

jobs:
  build_and_push:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Set up Docker Buildx
        uses: docker/setup-buildx-action@v3

      - name: Login to DockerHub
        uses: docker/login-action@v3
        with:
          username: ${{ secrets.DOCKERHUB_USERNAME }}
          password: ${{ secrets.DOCKERHUB_TOKEN }}

      - name: Build and push
        id: build
        uses: docker/build-push-action@v5
        with:
          context: .
          push: true
          tags: morisab/tamiyochi
          cache-from: type=gha
          cache-to: type=gha,mode=max

  deploy:
    needs: build_and_push
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v4
      - name: Copy Nginx configuration and Docker-Compose file
        uses: appleboy/scp-action@master
        with:
          host: ${{ secrets.HOST_IP }}
          username: moris
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          source: "./nginx-template.conf, ./docker-compose.yml"
          target: "~/tamiyochi/"
          overwrite: true

      - name: Execute remote ssh commands
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST_IP }}
          username: moris
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          script: |
            cd ~/tamiyochi
            sudo docker pull morisab/tamiyochi:latest
            sudo docker compose down
            sudo docker compose up -d
```

File ini terdiri dari dua jobs, yaitu build_and_push dan deploy. Job build_and_push akan dijalankan ketika terjadi push pada branch main. Job ini akan melakukan checkout kode, setup Docker Buildx, login ke Docker Hub, build dan push image baru ke Docker Hub. Job ini menggunakan beberapa action dari Docker, yaitu actions/checkout, docker/setup-buildx-action, docker/login-action, dan docker/build-push-action serta menggunakan cache untuk mempercepat proses build. Job deploy akan dijalankan setelah job build_and_push selesai. Job ini akan melakukan checkout kode, mengcopy file konfigurasi Nginx dan docker-compose, dan menjalankan perintah SSH untuk melakukan pull image baru dari Docker Hub dan menjalankan container baru menggunakan docker-compose.

## Cara Kerja

1. Developer melakukan perubahan pada repository Github.
2. Github Actions akan mendeteksi perubahan dan menjalankan job build_and_push.
3. Job build_and_push akan melakukan checkout kode, setup Docker Buildx, login ke Docker Hub, build dan push image baru ke Docker Hub.
4. Setelah proses build selesai, Github Actions akan menjalankan job deploy.
5. Job deploy akan melakukan SSH ke server, menghapus container dan image lama, pull image baru dari Docker Hub, dan menjalankan container baru menggunakan docker-compose.
6. Aplikasi Tamiyochi akan dijalankan pada server.

## Screenshot

Berikut adalah screenshot dari proses CI/CD menggunakan Github Actions dan Docker:

Kondisi ketika mengakses IP server sebelum container dijalankan:

![server_before](https://cdn.discordapp.com/attachments/1233979634672996424/1239927539636371537/image.png?ex=66475702&is=66460582&hm=7d5346fb56c516b08f3ec1fdcc5690c1a5fbf0f1ecaab1fb0b94bc5f8a407683&)

Dapat dilihat muncul pesan "This site can't be reached". Karenanya, aplikasi Tamiyochi belum dijalankan.

Kemudian dilakukan perubahan pada repository untuk mentrigger Github Actions:

![gitpush](https://cdn.discordapp.com/attachments/1233979634672996424/1239928904559624192/image.png?ex=6644b547&is=664363c7&hm=a9fbd45aa5b51923064aedb97634492ead984df068372e1bdffdb287b34b0d51&)

Kemudian jika dilihat pada Actions, terdapat workflow yang sedang berjalan:

![workflow](https://cdn.discordapp.com/attachments/1233979634672996424/1239933274516750388/image.png?ex=6644b959&is=664367d9&hm=435887ac1fe9e8fc9a230cc8837978538d230c9caf59f75953381ee71d4624a2&)

Ketika diklik pada workflow yang sedang berjalan maka akan muncul job yang sedang berjalan:

![job_running](https://cdn.discordapp.com/attachments/1233979634672996424/1239933274927923271/image.png?ex=6644b959&is=664367d9&hm=215468168ce3dc27c02f5d0b1e37d6c9977d50bd721e90e0f62f42a72f7e23ff&)

Ketika job selesai, maka akan muncul tanda centang hijau pada job tersebut:

![job_done](https://cdn.discordapp.com/attachments/1233979634672996424/1239935190894247976/image.png?ex=6644bb22&is=664369a2&hm=0bea3ae128bc7621d16b40764827276c627a4746183b69541fca0e7e871844d1&)

Apabila diklik pada job tersebut, maka akan muncul log dari job tersebut:

![build_and_push](https://cdn.discordapp.com/attachments/1233979634672996424/1239935386189303890/image.png?ex=6644bb50&is=664369d0&hm=73e4f7312f4d5e76c06acbdfda81fcd159ebebb965d89d443513aad81c0c72e6&)

![deploy](https://cdn.discordapp.com/attachments/1233979634672996424/1239935386562592878/image.png?ex=6644bb51&is=664369d1&hm=6502f024d2d6872ed19d6bdbcdae9eeedd876174f01232f031d36b8a1d81a70e&)

Setelah proses selesai, maka aplikasi Tamiyochi akan dijalankan pada server:

![server_after](https://cdn.discordapp.com/attachments/1233979634672996424/1239935283458211900/image.png?ex=6644bb38&is=664369b8&hm=911c744d88547e0e726273e7c99fb36822517e71c82ad776b8ccae6bbaefbbee&)