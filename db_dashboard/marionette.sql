CREATE DATABASE marionette_dashboard;

USE marionette_dashboard;

CREATE TABLE members (
 id INT(10) PRIMARY KEY NOT NULL AUTO_INCREMENT,
 f_name VARCHAR(100),
 l_name VARCHAR(100),
 email VARCHAR(100),
 gender VARCHAR(20)
);