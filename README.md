# birdvision-cms
bird vision cms interview assignment

## Steps to install CMS

# Laravel 10 and pgsql 16

1. github public repo: https://github.com/brajdhan/birdvision-cms.git
2. composer install
3. node install
4. create database in pgsql
5. connect db .env file and  other futures variable values or copy .env example file and gererate APP_KEY.
    imp points for connections

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=
    DB_USERNAME=postgres
    DB_PASSWORD=

    if you want used queues sync or database then use any one

    QUEUE_CONNECTION=database
    QUEUE_CONNECTION=sync

    Send email notifications

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=465
    MAIL_USERNAME=''
    MAIL_PASSWORD=''
    MAIL_ENCRYPTION=ssl
    MAIL_FROM_ADDRESS=''
    MAIL_FROM_NAME="${APP_NAME}"

    Scout used for filters / searching customers and sales

    SCOUT_DRIVER=database

6. migrate database using command 
 php artisan migrate --seed

and run project
php artisan serve
npm run dev
php artisan queue:work   if you used database 

and login with these credentials
1. Admin User
 email=> admin@bird.com 
 password => password

2. Sale Manager User
    email = salemanager@bird.com
    password = password


# API sanctum

1. Login API
2. GET Customers list
3. GET Sales List with customer
4. Logout
