# Hangman game

Hangman is an old school game, where the goal is simply to find the missing word (here I used only nouns).
You will be presented with a number of blank spaces representing the missing letters you need to find.
If your chosen letter exists in the answer, then all places in the answer where that letter appear will be revealed.
Every time you guess a letter wrong you loose a life (you have 6 lives) and the hangman begins to appear, piece by piece.


## DEMO

https://tadassapitavicius.com/hangman

## Technologies used


- Php 7.2
- Laravel 7.28.4
- VueJs 2.6.12 
- MySql 8.0.22
- Sass 1.30.0
- PhpUnit 8.5.9
- Composer 2.0.8 for php packages
- NodeJs 6.14.11 for npm packages

## How to deploy

1. Copy all files from this repo
1. Make sure you have right technologies installed
1. Copy .env.example and rename it to .env (if you using unix operating system just run this command in app root `mv .env.example .env`)
1. Run `composer install` and `npm install`(needed dependencies will be installed)
1. Then run `php artisan key:generate` and replace database credentials inside .env file
1. Migrate tables by running `php artisan migrate`
    1. (optional) PHPUnit database migration command "php artisan migrate --database=mysql_testing"
    1. (optional) `php artisan test` to run your unit tests
1. Registration route `your_url/corona/register`, after registration you will be able to login
   1. For safety after registration you should disable admin registration route from casual users,
      change .env environmental variable "REGISTRATION" to false
1. Once you logged in, you will be able to add, edit, delete words for this game  

