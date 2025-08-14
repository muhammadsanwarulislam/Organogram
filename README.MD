composer config repositories.local path /var/www/sanwarul-organogram
composer require sanwarul/organogram @dev

php artisan vendor:publish --provider="Sanwarul\Organogram\Providers\OrganogramServiceProvider" --tag="organogram-seeders"

php artisan vendor:publish --provider="Sanwarul\Organogram\Providers\OrganogramServiceProvider" --tag="organogram-migrations"

php artisan organogram:seed

php artisan organogram:install
