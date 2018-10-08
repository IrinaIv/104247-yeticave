CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
  USE yeticave;

CREATE TABLE categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128),
  description CHAR(255)
);
CREATE UNIQUE INDEX c_name ON categories(name);
CREATE UNIQUE INDEX c_desc ON categories(description);

CREATE TABLE lots (
  lot_id INT AUTO_INCREMENT PRIMARY KEY,
  autor_id INT,
  winner_id INT,
  category_id INT,
  name CHAR(128),
  description CHAR(255),
  image CHAR(255),
  price INT,
  date_created TIMESTAMP,
  date_closed TIMESTAMP,
  bet_step INT
);

CREATE TABLE bets (
  bet_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  lot_id INT,
  date_created TIMESTAMP,
  price INT
);

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  lot_id INT,
  bet_id INT,
  name CHAR(128),
  email CHAR(128),
  password CHAR(128),
  date_registered TIMESTAMP,
  avatar CHAR(255),
  contacts CHAR(255)
);
CREATE UNIQUE INDEX u_email ON users(email);

ALTER TABLE lots ADD FOREIGN KEY (autor_id) REFERENCES users(user_id);
ALTER TABLE lots ADD FOREIGN KEY (winner_id) REFERENCES users(user_id);
ALTER TABLE lots ADD FOREIGN KEY (category_id) REFERENCES categories(category_id);

ALTER TABLE bets ADD FOREIGN KEY (user_id) REFERENCES users(user_id);
ALTER TABLE bets ADD FOREIGN KEY (lot_id) REFERENCES lots(lot_id);

ALTER TABLE users ADD FOREIGN KEY (lot_id) REFERENCES lots(lot_id);
ALTER TABLE users ADD FOREIGN KEY (bet_id) REFERENCES bets(bet_id);