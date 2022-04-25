# Guess My Numbers

## Introduction
Guess My Numbers is a game designed by Josh  Gottsegen and developed by Tyler Pendleton. It involves a 3 x 3 grid 
of squares where each row represents a guess attempt and each column represents a number.

Every 24 hours, the numbers will change. If a user successfully guesses the numbers, they will have the opportunity 
to put in their own numbers as well as a link to their personal website / twitter / etc. that will then be available
on the application once the 24 hours of the existing numbers is up.

## Local Development
This application runs using Laravel 9.x and PHP 8.1.4. It is configured to use a docker container.
Please install Docker Desktop to get started.

1. Ensure Docker Desktop is running.
2. Clone the repository onto your local machine.
3. In your terminal, navigate to the directory of the repository.
4. Run `sail up` to create containers and serve the application
5. Navigate to the application at: http://localhost/

## Technologies Used
* Laravel 9.x
* PHP 8.1.4
* Vue.js 3.x

## Deployment Process
This application will be deployed via Laravel Vapor.

See the Laravel Vapor documentation for more information.

Deploying Production: `vapor deploy production`

Deploying Staging: `vapor deploy staging`

Configuring ENVs: `vapor env:pull **environment**` && `vapor env:push **environment**`
