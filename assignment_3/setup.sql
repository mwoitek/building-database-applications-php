/* To get started, run the following SQL commands: */

/* Create a database: */
CREATE DATABASE misc;

/* Create a user to connect to the database: */
GRANT ALL ON misc.* TO `fred`@`localhost` IDENTIFIED BY 'zap';

/* Select the newly created database: */
USE misc;

/* Create the 'autos' table in the 'misc' database: */
CREATE TABLE autos (
    autos_id INTEGER NOT NULL KEY AUTO_INCREMENT,
    make VARCHAR(255),
    model VARCHAR(255),
    year INTEGER,
    mileage INTEGER
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
