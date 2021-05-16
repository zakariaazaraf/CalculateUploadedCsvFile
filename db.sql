/* Create DB */ 
CREATE DATABASE `uploadcsv`;

/* Create Table */
CREATE TABLE `file` (
    `category` VARCHAR(80) NOT NULL,
    `price` DECIMAL(5, 2) NOT NULL,
    `amount` INT NOT NULL
);