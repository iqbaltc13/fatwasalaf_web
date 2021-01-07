$path='/var/www/myduma-web'
cd $path
echo "--------------------------------------- PULL START -------------------------------------"
echo "pulling branch master from directory ".$path
git_url='git pull https://ramadhanrosihadi@gitlab.com/artcak/duma/myduma-web.git master'
$git_url
# composer dump-autoload
# php artisan migrate
echo "--------------------------------------- PULL END ---------------------------------------"

