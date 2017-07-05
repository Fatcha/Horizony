target_folder="/home/horizony/domains/stage.horizony.io/laravel"
src_folder=$1
echo "-----------------------"
echo "User name $USER "
echo "-----------------------"
cd ${src_folder}
#npm & gulp
npm install
npm build

echo "-----------------------"
echo "|    Composer Update"
echo "-----------------------"
composer update

yes |  cp -r ${src_folder}/* ${target_folder}





###################
#Move to folder
###################
echo "-----------------------"
echo "Move to folder: "${target_folder}
echo "-----------------------"
cd ${target_folder}

#remove current .env

echo "---> Move file for production"
rm .env
rm ./public/.htaccess
rm ./public/robots.txt
#copy the new one
yes |  cp  ${src_folder}/.env.staging ./.env
yes |  cp  ${src_folder}/public/.htaccess.staging ./public/.htaccess

yes |  cp  ${src_folder}/public/robots.staging.txt ./public/robots.txt

echo "---> migrate DB"
#migrate DB
php artisan migrate --force

chown horizony:horizony ./ -R
chmod 775 ./storage -R
chmod 775 ./bootstrap/cache -R