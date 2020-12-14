# Classic Hangman game

* Laravel
* Mysql
* VueJS
* phpUnit

# DEMO

https://tadas-hangman.herokuapp.com/

## How to deploy

1. Rename env.example to .env and put your MySql database credentials
1. Run "php artisan key:generate"
1. Run "php artisan migrate"
    1. (optional) For testing database migration "php artisan migrate --database=mysql_testing"
1. If you want to disable admin registration change env "REGISTRATION" to false

* you need to make sure that you have composer and lamp stack installed on your machine


