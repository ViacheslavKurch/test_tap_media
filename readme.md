Project is written on [Laravel framework (version 5.6)](https://laravel.com/docs/5.6)

## Deploy

1. Clone repository
2. Run "composer update" in the project directory.
2. Rename .env.example to .env
3. Change database connection credentials in the .env file in the project directory:
   DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
4. Run migrations "php artisan migrate" in the project directory.
5. Generate key "php artisan key:generate" in the project directory.