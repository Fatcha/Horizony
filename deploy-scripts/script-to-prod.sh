
# first minify css
cd /var/lib/jenkins/workspace/horizony-staging
npm run prod

yes | cp -rf /var/lib/jenkins/workspace/horizony-staging/* /home/horizony/prod/

###################
#Move to folder
###################
cd /home/horizony/prod/
#remove current .env
rm .env

#copy the new one
yes | cp  /var/lib/jenkins/workspace/horizony-staging/.env.production ./.env
yes | cp  /var/lib/jenkins/workspace/horizony-staging/.htaccess.production ./public/.htaccess

yes | cp  /var/lib/jenkins/workspace/horizony-staging/robots.production.txt ./public/robots.txt

#composer
composer update

#migrate DB
php artisan migrate

chown horizony:horizony ./ -R
chmod 775 ./storage -R
chmod 775 ./bootstrap/cache -R







#target_folder="/home/horizony/prod/"
#src_folder=$1
#echo "-----------------------"
#echo "User name $USER "
#echo "-----------------------"
#cd ${src_folder}
##npm & gulp
#npm install
#npm build

#echo "-----------------------"
#echo "|    Composer Update"
#echo "-----------------------"
#composer update

#yes |  cp -r ${src_folder}/* ${target_folder}





###################
#Move to folder
###################
#echo "-----------------------"
#echo "Move to folder: "${target_folder}
#echo "-----------------------"
#cd ${target_folder}

#remove current .env

#echo "---> Move file for production"
#rm .env
#rm ./public/.htaccess
#rm ./public/robots.txt
#copy the new one
#yes |  cp  ${src_folder}/.env.production ./.env
#yes |  cp  ${src_folder}/public/.htaccess.production ./public/.htaccess

#yes |  cp  ${src_folder}/public/robots.production.txt ./public/robots.txt

#echo "---> migrate DB"
#migrate DB
#php artisan migrate --force

#chown horizony:horizony ./ -R
#chmod 775 ./storage -R
#chmod 775 ./bootstrap/cache -R

