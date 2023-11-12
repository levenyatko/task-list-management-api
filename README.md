# Task list management API

The API allows user to manage a list of tasks. To access the list of tasks the user must be logged in the system. The user has access only to their tasks without the possibility to assign a task to another user.

## Installation

1. Clone project to your local mashine
2. In the project root make a copy a .env.example file and name it .env
3. Move to the laravel-app directory
4. Here you need make a copy a .env.example file and name it .env . make sure that variables with the same names have the same value in both .env files
5. Back to the project root and run the following commands
 ```
   docker-compose build
   docker-compose up -d
```
6. Install Laravel in the php service using the following commands
```
    docker compose exec php composer install
    docker-compose run --rm artisan key:generate
    docker-compose run --rm artisan migrate:fresh --seed
    docker-compose run --rm artisan passport:install
```

## Usage

### Default users
There are two users in the application dummy data:
1.
```
    email: firstuser@gmail.com
    password: Password123
```
2.
```
    email: seconduser@gmail.com
    password: Password123
```

## Documentation

You can find API documentation 
[here](https://editor.swagger.io/?url=https://raw.githubusercontent.com/levenyatko/task-list-management-api/main/openapi.json) 

