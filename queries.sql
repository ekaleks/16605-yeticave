INSERT INTO users (date_registration, e_mail, name, password, user_file, contacts, lot_id, rate_id) VALUES
('2019-01-01 15:00:53', 'kate@yandex.ru', 'kat', '789W789', NULL, NULL, NULL, NULL),
('2019-02-01 12:00:44', 'vasya@mail.ru', 'vasya', '123r654', NULL, NULL, NULL, NULL),
('2019-02-11 13:00:00', 'tim@mail.ru', 'tim', 'qwerty12345', NULL, NULL, NULL, NULL);


INSERT INTO categories (title) VALUES
('Доски и лыжи'),
('Крепления'),
('Ботинки'),
('Одежда'),
('Инструменты'),
('Разное');

INSERT INTO lots (date_creation, date_completion, title, description_lot, user_file, starting_price, bid_step, current_price, category_id,
creation_user_id, winning_user_id, status) VALUES

( NULL, NULL, '2014 Rossignol District Snowboard', NULL, 'img/lot-1.jpg', 10999, 1000, 10999, 1, 1, NULL, 1),
( NULL, NULL, 'DC Ply Mens 2016/2017 Snowboard', NULL,'img/lot-2.jpg', 159999, 1000, 159999, 1, 2, NULL, 1),
( NULL, NULL, 'Крепления Union Contact Pro 2015 года размер L/XL', NULL, 'img/lot-3.jpg', 8000, 1000, 8000, 2, 3, NULL, 1),
( NULL, NULL, 'Ботинки для сноуборда DC Mutiny Charocal', NULL, 'img/lot-4.jpg', 10999, 1000, 10999, 3, 1, NULL, 1),
( NULL, NULL, 'Куртка для сноуборда DC Mutiny Charocal', NULL, 'img/lot-5.jpg', 7500, 1000,7500, 4, 2, NULL, 1),
( NULL, NULL, 'Маска Oakley Canopy', NULL, 'img/lot-6.jpg', 5400, 1000, 5400, 6, 3, NULL, 1);

INSERT INTO rates (date_posting, lot_price, lot_id, user_id ) VALUES
(NULL, 11999, 1, 1),
(NULL, 12099, 1, 2);

/*Несколько SQL запросов для тренировки*/
SELECT title FROM categories;

SELECT title, starting_price, user_file, current_price, category_id  FROM lots WHERE status=1;

SELECT l.title, c.title FROM lots l JOIN categories c ON l.category_id = c.id WHERE l.id = 2;

UPDATE lots SET title = '2020 Rossignol District Snowboard' WHERE id = 1;

SELECT l.title, r.lot_price FROM rates r JOIN lots l ON r.lot_id = l. id WHERE r.date_posting >= NOW() AND l.id = 1;
