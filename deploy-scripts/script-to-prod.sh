
# first minify css
cd /home/bambo/atlassian-bamboo-5.13.1/xml-data/build-dir/SIL-SWL5-JOB1/
gulp --production

yes | cp -rf /home/bambo/atlassian-bamboo-5.13.1/xml-data/build-dir/SIL-SWL5-JOB1/* /home/silverworld/web/silver-world.net/laravel5/production/

###################
#Move to folder
###################
cd /home/silverworld/web/silver-world.net/laravel5/production/
#remove current .env
rm .env

#copy the new one
yes | cp  /home/bambo/atlassian-bamboo-5.13.1/xml-data/build-dir/SIL-SWL5-JOB1/.env.production ./.env
yes | cp  /home/bambo/atlassian-bamboo-5.13.1/xml-data/build-dir/SIL-SWL5-JOB1/web/.htaccess.production ./web/.htaccess

yes | cp  /home/bambo/atlassian-bamboo-5.13.1/xml-data/build-dir/SIL-SWL5-JOB1/web/robots.production.txt ./web/robots.txt

#composer
composer update

#migrate DB
php artisan migrate

chown silverworld:silverworld ./ -R
chmod 775 ./storage -R
chmod 775 ./bootstrap/cache -R

gulp --production