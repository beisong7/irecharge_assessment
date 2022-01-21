## Test Configuration
- Use the information below to setup project on your machine

##### Requirements for your machine:

- PHP7.4^
- MySQL

##### Steps to Set up

- Create a new database (eg: test_db) on MySQL (phpMyAdmin)
- Copy & rename the file .env.example to .env at the root directory 
- Replace ``` laravel ``` with ``` test_db ``` on line 12 of the .env file 
- update line 13 & 14 based on your system MySQL settings on the .env file

#### Run the following on Terminal from the root of the project
- ``` composer install ```  to install the required dependencies
- ``` php artisan key:generate ``` to generate the default application key
- ``` php artisan migrate --seed ```  to load the database with the basic information
- serve application with ``` php artisan serve ``` or on homestead

- view API docs [here!](https://laravel.com/docs/routing). 