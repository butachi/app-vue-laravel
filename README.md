# This repository is base repos. it used to create the app at the first step.

# 1. api folder: it is backend code of application, it also support api to frontend
- It containers laravel and Dockerfile. At the current. It is only Dockerfile

# 2. frontend folder: it is frontend code of application. the users will be active with frontend
- It containers Vue and Dockerfile

# 3. deployment: this folder holding the config files

# How to use it
- clone this repository to create a new application
    


# build images:
1. Dockerizing a Laravel API
- create the laravel resource
    composer create-project laravel/laravel .
- docker build -t api:0.1 -f ./api/Dockerfile --build-arg user=butachi --build-arg uid=1000 .
- docker run -it --rm api:0.1

2. Dockerizing a Vue app
- use npm create vue@latest
- run: npm install & npm run dev -> default, it's using the port: 5173
Change the port to 8080, you need update file vite.config.js with server.port and run command: npm run dev -- --host 0.0.0.0
- docker build -t frontend:0.1 -f ./frontend/Dockerfile --target=dev .
- docker run -it -p 8080:8080 --rm frontend:0.1

3. Dockerizing a scheduler and a worker


# docker compose with services
- frontend
it's related to vue js
- api: it's related to php-fpm
- database
redis & mysql
- migrate
from api/Dockerfile to migrate data
- nginx
it's related to web server (api:9000)
- reverse proxy
it redirect to frontend or nginx container
- scheduler and worker
They are basically the same as the api service but they target specific build stages.
Supervisor is running in worker service.
- update
Run file sh to execute the php artisan scripts:

# Run command for development
Start the application (-d runs in detached mode so it runs in the background)
```
docker compose up or docker compose up -d 
```

Execute commands in a give container. 
```
docker compose exec api bash (php artisan tinker)
```

Restart the given service. We often use this command to restart the worker
```
docker compose restart <service>
```

Rebuilds the images and then starts the whole project. It's useful when you're modifying the Dockerfile and test if it works
```
docker compose up --build
```

Show log of given service. If you don't specify the service it shows every container.
```
docker compose log -f --tail=400 <service>
```

Stops and removes containers.
```
docker compose down
```
# Manually building from the source
- Clone this repo `git clone https://github.com/butachi/app-vue-laravel.git`
- `copy .env-example .env`
- `cd api` then `cp .env-example .env` and `composer install`
- `cd frontend` then run `npm install`
- At root folder. run command `docker compose up`
- Check url frontend: http://localhost:3000/ and backend: http://localhost:3000/api

