CREATE DATABASE yeticave DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title CHAR(64) NOT NULL
);

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_completion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title CHAR(128) NOT NULL,
    description_lot CHAR,
    user_file CHAR(128) NOT NULL,
    starting_price INT NOT NULL,
    bid_step INT NOT NULL,
    current_price INT NOT NULL,
    category_id INT NOT NULL,
    creation_user_id INT,
    winning_user_id INT,
    status TINYINT DEFAULT 0
);

CREATE TABLE rates
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_posting TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  lot_price INT NOT NULL,
  lot_id INT NOT NULL,
  user_id INT NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    e_mail CHAR(128) NOT NULL UNIQUE,
    name CHAR(64) NOT NULL,
    password CHAR(64) NOT NULL,
    user_file CHAR(128),
    contacts CHAR(64),
    lot_id INT,
    rate_id INT
);

