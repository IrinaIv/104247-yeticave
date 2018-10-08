USE yeticave;

INSERT INTO
  categories(alias, title)
VALUES
  ('boards', 'Доски и лыжи'),
  ('mounting', 'Крепления'),
  ('shoes', 'Ботинки'),
  ('clothes', 'Одежда'),
  ('tools', 'Инструменты'),
  ('other', 'Разное');

INSERT INTO
  users(name, email, password, avatar)
VALUES
  ('Анна', 'anna@m.ru', '0B14D501A594442A01C6859541BCB3E8164D183D32937B851835442F69D5C94E', 'img/user.jpg'),
  ('Антон', 'anton@m.ru', '6CF615D5BCAAC778352A8F1F3360D23F02F34EC182E259897FD6CE485D7870D4', 'img/user.jpg'),
  ('Валерия', 'valeriya@m.ru', '5906AC361A137E2D286465CD6588EBB5AC3F5AE955001100BC41577C3D751764', 'img/user.jpg'),
  ('Виктор', 'viktor@m.ru', 'B97873A40F73ABEDD8D685A7CD5E5F85E4A9CFB83EAC26886640A0813850122B', 'img/user.jpg');

INSERT INTO
  lots(author_id, category_id, name, description, image, started_price)
VALUES
  (3, 1, '2014 Rossignol District Snowboard', 'Доска', 'img/lot-1.jpg', 10999),
  (2, 1, 'DC Ply Mens 2016/2017 Snowboard', 'Доска', 'img/lot-2.jpg', 159999),
  (1, 2, 'Крепления Union Contact Pro 2015 года размер L/XL', 'Крепления', 'img/lot-3.jpg', 8000),
  (1, 3, 'Ботинки для сноуборда DC Mutiny Charocal', 'Ботинки', 'img/lot-4.jpg', 10999),
  (4, 4, 'Куртка для сноуборда DC Mutiny Charocal', 'Куртка', 'img/lot-5.jpg', 7500),
  (2, 6, 'Маска Oakley Canopy', 'Маска', 'img/lot-6.jpg', 5400);

INSERT INTO
  bets(user_id, lot_id, price)
VALUES
  (1, 1, 15000),
  (2, 2, 170000),
  (3, 3, 10000),
  (4, 4, 12000),
  (3, 5, 8000),
  (4, 6, 6000);

/* Получить все категории */
SELECT * FROM categories;






/* Получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену последней ставки, количество ставок, название категории */
SELECT name, started_price, image, price, title FROM lots
JOIN bets ON lots.lot_id = bets.lot_id
JOIN categories ON lots.category_id = categories.category_id
WHERE date_closed IS NULL;

/* Как вывести последнюю цену ставки */
SELECT bets.lot_id, name, started_price, image, COUNT(bet_id) AS bets_count, MAX(bets.price), title FROM lots
JOIN bets ON lots.lot_id = bets.lot_id
JOIN categories ON lots.category_id = categories.category_id
WHERE date_closed IS NULL
GROUP BY bets.lot_id;







/* Показать лот по его id. Получите также название категории, к которой принадлежит лот */
SELECT lots.*, title FROM lots
JOIN categories ON lots.category_id = categories.category_id
WHERE lot_id = 1;

/* Обновить название лота по его идентификатору */
UPDATE lots
SET name = 'Board'
WHERE lot_id = 3;

/* Получить список самых свежих ставок для лота по его идентификатору */
SELECT * FROM bets
WHERE lot_id = 1
ORDER BY date_created DESC;