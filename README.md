# Mobile App Subscriptions

## Installation
Clone Repository

````
git clone https://github.com/cllakyz/mobile_app_subscriptions.git
````

Copy & rename api/.env.example to api/.env file

````
cp api/.env.example api/.env
````

Docker Containers run

````
docker-compose up -d
````

Composer install

````
docker exec -ti api_container_id composer install
````

Generate laravel app key

````
docker exec -ti api_container_id php artisan key:generate
````

Npm install

````
docker exec -ti api_os_container_id npm install
````