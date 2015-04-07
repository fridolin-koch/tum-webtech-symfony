Project setup
------------

###Requirements

* PHP >= 5.5 with cURL, intl, imap, apc
* A [MySQL](http://dev.mysql.com/downloads/mysql/) Server
* OR: Vagrant

###Setup

1. Clone project
2. Copy `app/config/parameters.yml.dist` to `app/config/parameters.yml`
3. Configure the database connection in `app/config/parameters.yml`
4. Get Composer `$ curl -s http://getcomposer.org/installer | php`
5. Install vendors `$ php composer.phar install`
6. Create database schema: $ php app/console doctrine:schema:create
7. Load defaults `$ php app/console doctrine:fixtures:load`
8. Start webserver `$ php app/console server:run`