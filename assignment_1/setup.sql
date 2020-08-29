/* To get started, run the following SQL commands: */

/* Create a database: */
CREATE DATABASE misc;

/* Create a user to connect to the database: */
GRANT ALL ON misc.* TO `fred`@`localhost` IDENTIFIED BY 'zap';

/* Select the newly created database: */
USE misc;

/* Create the 'autos' table in the 'misc' database: */
CREATE TABLE autos (
    auto_id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY,
    make VARCHAR(128),
    year INTEGER,
    mileage INTEGER
);
