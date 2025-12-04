#!/usr/bin/env bash
# exit on error
set -o errexit

npm install
npm run build

composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force
