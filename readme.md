## APPointment

![Screenshot](https://github.com/GijsGoudzwaard/APPointment/blob/develop/screenshot.png)

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