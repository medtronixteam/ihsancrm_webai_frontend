#!/bin/bash
sleep 20

echo "Running composer install..."
composer install

echo "Running migrations..."
php artisan migrate

echo "Adding storage shortcut folder in public folder..."
php artisan storage:link

echo "Clearing caches..."
php artisan optimize:clear

echo "delete log file"
rm -rf /var/www/storage/logs/laravel.log

echo "schedule work"
php artisan schedule:work &

echo "Running npm install..."
npm install

echo "Running npm run dev on all network interfaces in the background..."
npm run dev -- --host 0.0.0.0 &

echo "Running socket server in the background..."
php artisan websockets:serve &

echo "Starting the Laravel app on all network interfaces..."
php artisan serve --host=0.0.0.0 --port=8000
