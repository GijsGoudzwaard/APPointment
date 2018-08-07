### Introduction
APPointment is a SaaS with which you can easily keep track of your appointments and those of other departments or companies. 
![Screenshot](https://github.com/GijsGoudzwaard/APPointment/blob/develop/screenshot.png)

### Features
 - Business management
   - Appointments 
   - Clients Addressbook
   - Staff
 - Scheduling view with [fullcalendar](https://fullcalendar.io/)
 - Subdomains for all your other departments or companies.
 - API with which you can book appointments, check availability and more
 - Click anywhere on the calendar to create an appointment on that date and time.


### Default login credentials:  
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
`$ composer install --no-scripts`  
`$ npm install`  
`$ bower install`  
`$ gulp`  
`$ cp .env.example .env` and edit the needed variables  
`$ php artisan generate:key`
  
**Setup the database**  
`$ php artisan migrate`  
`$ php artisan db:seed`  

### Adding test data
`$ php artisan db:seed --class=TestDataSeeder`  
`$ php artisan cache:clear`
