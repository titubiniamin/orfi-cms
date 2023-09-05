## ORFI CMS Installation

### Clone the repository

    git clone https://github.com/titubiniamin/orfi-cms.git

### Switch to the repo folder

    cd orfi-cms

### PHP Version will be

    ^7.4.*

### Install all the dependencies using composer

    composer install

### Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

### Generate a new application key & Optimize clear

    php artisan key:generate
    php artisan optimize:clear


### Database configuration in .env file

    DB_DATABASE=orfi_cms
    DB_USERNAME=root
    DB_PASSWORD=


### For Create table & Seed data

    php artisan migrate --seed


### Start the local development server

    php artisan serve



### App URL

    http://localhost:8000
