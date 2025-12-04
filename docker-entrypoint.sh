#!/bin/bash
set -e

# Caching configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Running migrations
echo "Running migrations..."
php artisan migrate --force

# Starting Apache
echo "Starting Apache..."
exec apache2-foreground
