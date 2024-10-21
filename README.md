App - Vue - Laravel Project

- backend uses Laravel framework (Laravel 11)
- frontend uses Vue framework (Vue 3)
- frontend connect with backend via sanctum api

The project use docker to create dev server env and docker swarm to create production server env
#### Server env
1. Frontend (how to install Vue 3)
- build the backend:0.1 image
```
docker build -t backend:0.1 -f ./backend/Dockerfile --build-arg user=butachi --build-arg uid=1000 .
```

- build dev image for frontend
``
docker build -t frontend:0.1 -f ./frontend/Dockerfile --target=dev .

docker run -it -p 3000:80 --rm --name frontend frontend:0.1

``
- build scheduler and worker image


#### Design

1. Build Login
    Layout: Login/Register/Change or Forget password

    API: /Login/Register/Forget Password/Change password

2. Profile User
3. Learning English


