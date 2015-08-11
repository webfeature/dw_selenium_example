# denkwerk selenium example

## Requirements
* Composer
* Selenium Standalone Server
* WebDriver for Browser

### Get composer
Following instructions on https://getcomposer.org/

### Get Selenium Standalone Server and WebDriver for Browser
Following instructions on http://www.seleniumhq.org/download/

## Installation and running
Build project

    composer install

Start selenium server

    java -jar path/to/selenium-standalone.jar

Execute test

    vendor/bin/phpunit src/
