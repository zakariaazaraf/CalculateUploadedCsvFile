/* Create DB */ 
CREATE DATABASE `uploadcsv`;

/* Create Table */
CREATE TABLE `file` (
    `category` varchar(40) NOT NULL,
    `price` decimal(5, 2) NOT NULL,
    `amount` tinyint(4) NOT NULL
);