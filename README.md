# Guess My Numbers

## Introduction

Guess My Numbers is a game designed by Josh Gottsegen. It involves a 3 x 3 grid of squares where each row represents a guess attempt and each column represents a number.

Every 12 hours, the numbers will change. If a user successfully guesses the numbers, they will have the opportunity
to put in their own numbers as well as a link to their personal website / twitter / etc. that will then be available
on the application once the 24 hours of the existing numbers is up.

## Local Development

This application runs using Laravel 9.x and PHP 8.1.4. It is configured to use a docker container.
Please install Docker Desktop to get started.

1. Ensure Docker Desktop is running.
2. Clone the repository onto your local machine.
3. In your terminal, navigate to the directory of the repository.
4. Install Laravel Sail locally or globally.

    -   Install PHP composer. [How to install Composer on Mac OS](https://pilsniak.com/install-composer-mac-os)
        ```bash
        brew install composer
        ```
    -   Install Laravel Sail. [Laravel and Docker: A guide to using Laravel Sail](https://blog.logrocket.com/laravel-and-docker-a-guide-to-using-laravel-sail/)
        ```bash
        composer require laravel/sail:1.0.1 --dev
        alias sail='bash vendor/bin/sail'
        ```

5. Run `sail up` to create containers and serve the application
6. `sail yarn install`
7. `sail yarn watch`
8. `sail composer install`
9. Run frontend `sail yarn watch`
10. Navigate to the application at: http://localhost/

## Local Development without docker

1. Install node 14.17.3, yarn 1.22.18, npm 6.14.13, PHP 8.1.7, Composer 2.3.7
2. composer install
3. yarn install
4. Install Xampp(or Mamp for Max) and run MySQL server.
5. config .env from .env.example (remember to use 127.0.0.1 instead of localhost)
4. php artisan serve
5. yarn hot

## Technologies Used

-   Laravel 9.x
-   PHP 8.1.4
-   Vue.js 3.x

## Deployment Process

This application will be deployed via Laravel Vapor.

See the Laravel Vapor documentation for more information. [How to Deploy Project with Laravel Vapor?](https://www.itsolutionstuff.com/post/how-to-deploy-project-with-laravel-vaporexample.html)
```bash
alias vapor='php vendor/bin/vapor'
vapor login
```
Deploying Production: `vapor deploy production`

Deploying Staging: `vapor deploy staging`

Configuring ENVs: `vapor env:pull **environment**` && `vapor env:push **environment**`
