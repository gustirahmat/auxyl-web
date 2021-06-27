web: vendor/bin/heroku-php-nginx -C nginx.conf public/
worker: php artisan queue:work --sleep=3 --tries=3 --queue=high,default
release: php artisan migrate --force && php artisan clear-compiled && php artisan optimize:clear && php artisan optimize
