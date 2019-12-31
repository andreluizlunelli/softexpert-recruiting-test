composer install --ignore-platform-reqs

docker-compose run database createdb -p 5432 -h database app