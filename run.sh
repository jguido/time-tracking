#!/bin/sh
port=53201
DOMAIN_NAME="project1.app"
FILE_NAME="project1_app"
if [ -z "$1" ]
    then
        echo "Info: No Environment is given will take prod as <env>"
else
    ENV=$1
fi
case $ENV in
    dev)
        echo "-- DEV"
        if [ ! -z "$2" ]
            then
            DOMAIN_NAME=$2
            FILE_NAME=${DOMAIN_NAME}| sed 's/\./_/g'
        fi
        echo "Add $DOMAIN_NAME in hosts file"
        echo "127.0.0.1 $DOMAIN_NAME" | sudo tee -a /etc/hosts
        break ;;
    prod)
        echo "-- PROD"
        break ;;
    *)
        echo "Erro : bad option $ENV!"
        echo "option should be prod|dev"
        exit 0
        break ;;
esac

storage_dir='/tmp/storage/'$FILE_NAME
image_name=$FILE_NAME'_mysql'

mkdir -p $storage_dir


echo 'Will try yo kill container if exists'
docker kill $image_name
docker rm $image_name

echo 'Launch container from mysql image'
docker run --name $image_name -v $storage_dir:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=dbpass -p $port:3306 -d mysql

echo '-----------------------------------------------------------'
echo '| update your parameters.yml with these values'
echo '| host : '`docker inspect --format '{{ .NetworkSettings.IPAddress }}' $image_name`
echo '| port : '"$port"
echo '| user : root'
echo '| password : dbpass'
echo '|'
echo '| you should be able to run : '
echo '| mysql -u root -pdbpass -h 0.0.0.0 --port='"$port"
echo '| or'
echo '| mysql -u root -pdbpass -h '`docker inspect --format '{{ .NetworkSettings.IPAddress }}' $image_name`
echo '| or even better'
echo '| mysql -u root -pdbpass -h '`docker inspect --format '{{ .NetworkSettings.IPAddress }}' $image_name` '< your_dump.sql'
echo '-----------------------------------------------------------'

#composer update
php app/console cache:clear --env=$ENV
php app/console assets:install --symlink
php app/console assetic:dump

php app/console doctrine:database:create && php app/console doctrine:schema:create && php app/console doctrine:fixtures:load -n

#php app/console server:run 127.0.0.1:8050


