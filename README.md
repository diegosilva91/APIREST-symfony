# APIREST-symfony

````
 composer create-project symfony/skeleton 
````

````
symfony server:start
````
Install ORM and entities package
````
composer requiere symfony/orm-pack
````
Install access to URL package
````
composer require annotations
````
Config your dotenv
Run for create a schema
````
bin/console doctrine:database:create
````
Run for migrations
````
bin/console make:migration
bin/console doctrine:migrations:migrate
````
