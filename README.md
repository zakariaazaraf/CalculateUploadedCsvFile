# CALCULATE UPLOADED CSV FILE

## Description

This Project upload a csv file and process some calculation on it and desplay result that will generate Downloadable File

## SETUP

- Install Project On Your Localhost
- Create Database And File Table => Check db.sql File
- Changle config.php With Your DB Setting { DB_HOST, DB_USER, DB_PASS, DB_NAME } Here "app/config/config.php"
- Install PHPunit 9 for testing
  - To Install PHPUnit Use : composer require --dev phpunit/phpunit ^9
  - To Run Test Use : ./vendor/bin/phpunit
  - Change { DB_HOST, DB_USER, DB_PASS, DB_NAME } DB Settings In UploadTest.php File Here "test/UploadTest.php"
