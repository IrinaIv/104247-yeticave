CREATE DATABASE IF NOT EXISTS yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
  USE yeticave;

CREATE TABLE categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  alias CHAR(128),
  title CHAR(128)
);
CREATE UNIQUE INDEX c_alias ON categories(alias);
CREATE UNIQUE INDEX c_title ON categories(title);

CREATE TABLE lots (
  lot_id INT AUTO_INCREMENT PRIMARY KEY,
  author_id INT,
  winner_id INT DEFAULT NULL,
  category_id INT,
  name CHAR(128),
  description CHAR(255),
  image CHAR(255),
  price INT,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_closed TIMESTAMP,
  bet_step INT
);

CREATE TABLE bets (
  bet_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  lot_id INT,
  date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  price INT
);
CREATE INDEX bets_date_created ON bets(date_created);

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128),
  email CHAR(128),
  password CHAR(255),
  date_registered TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  avatar CHAR(255),
  contacts CHAR(255)
);
CREATE UNIQUE INDEX u_email ON users(email);
CREATE INDEX users_email ON users(email);