# Sistem Informasi Perancangan Rental Mobil Berbasis Web (siremo)

# Author: Rizki Hutama

## Dibuat menggunakan
-- php 7.4.24
-- laravel 8.68.1
-- node.js 8.4.0
-- PostgreSQL 14.1

### Ada beberapa tools yang harus disiapkan untuk menjalankan aplikasi ini

- web browser
- [postgresSQL](https://www.postgresql.org/)
- [composer](https://getcomposer.org)
- [node.js](https://nodejs.org/)
- [xampp](https://www.apachefriends.org/xampp-files/7.4.27/xampp-windows-x64-7.4.27-2-VC15-installer.exe)

### Jalankan perintah berikut BERURUTAN!
```sh
cp .env.example .env
```

lalu buat database dengan nama yang sama di file ```.env```

```sh
composer install
```

```sh
npm install
npm run dev
```

```sh
php artisan key:generate
```

```sh
php artisan storage:link
```

```sh
php artisan migrate
```

```sh
php artisan db:seed AdminSeeder
```

```sh
php artisan serve
```

#### Buka di web browser dengan link ```localhost:8000```

#### login admin :

> email : ```siremo@admin.com```
> pass  : ```@RizkiHutama1```