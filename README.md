## About Auxyl Store Admin

Admin panel ini berfungsi untuk mengatur pengelolaan produk, pesanan, hingga complain dan promo. Berikut adalah cara untuk menginstall nya di laptop Anda:

- Setelah mengclone dari github, buat file .env dengan mengcopas dari file .env.example
- Buat database baru dengan nama db_auxyl , collation utf8mb4_unicode_ci , dan update config db Anda di file .env sesuai dengan db yang baru dibuat 
- Jalankan composer install
- Jalankan php artisan key:generate
- Jalankan php artisan migrate:fresh --seed
- Jalankan php artisan serve , dan buka localhost:8000
- Login sesuai dengan seed user yang ada di file database/seeds/UsersTableSeeder.php
- Selesai
