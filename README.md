# Laravel 6.2 - Template Scutum

## Very Quick start

-   git clone 'https://gitlab.com/artcak/starterProject/web/laravel6.2-scutum.git'
-   composer install
-   composer run-script post-root-package-install
-   setting .env
-   php artisan migrate
-   php artisan key:generate
-   php artisan passport:install --force
-   php artisan db:seed --class=DatabaseSeeder

## Permission

sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
sudo chmod -R 775 public/uploads
chmod a+rwx public/uploads -R

php artisan migrate:rollback
php artisan migrate
php artisan db:seed --class=JenisLayananSeeder
php artisan db:seed --class=JenisPembayaranSeeder
php artisan db:seed --class=StatusTabunganUmrahSeeder
php artisan db:seed --class=StatusTabunganHajiSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=FaqSeeder
php artisan db:seed --class=SyaratKetentuanSeeder
php artisan db:seed --class=PaketTabunganHajiSeeder
php artisan db:seed --class=PaketTabunganUmrahSeeder
php artisan db:seed --class=NotifikasiGroupSeeder
php artisan db:seed --class=NotifikasiActionSeeder
