## Introduction
APPointment is a SaaS with which you can easily keep track of your appointments and those of other departments or companies. 
![Screenshot](https://github.com/GijsGoudzwaard/APPointment/blob/develop/screenshot.png)

Default login credentials:  
Email: `glados@aperturelabaratories.com`  
Password: `changeme`

### Prerequisites
 - PHP 7+
 - MySQL
 - composer
 - NPM
 - Bower
 - Gulp

### Installation
**Setup the files**  
`$ composer install`  
`$ npm install`  
`$ bower install`  
`$ gulp`  
  
**Setup the database**  
`$ php artisan migrate`  
`$ php artisan db:seed`  

### Adding test data
`$ php artisan db:seed --class=TestDataSeeder`  
`$ php artisan cache:clear`
