DROP DATABASE IF EXISTS things;

CREATE DATABASE things;

USE things;
	 
CREATE TABLE projects (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR (200)
);
INSERT INTO project (name)
VALUES ('Входящие'),  ('Учеба'),  ('Работа'),  ('Домашние дела'),  ('Авто');

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	project_id INT(10),
	user_id INT(100),
	name VARCHAR (200),
	dowloads VARCHAR(100),
	date_start DATE,
	completed BOOL,
	date_term DATE
);

INSERT INTO task (project_id, user_id, name, dowloads, date_start, completed , date_term )
VALUES ('3', '1', 'Собеседование в IT-компании', 'Home.psd', '2019-01-01', '0', '2019-12-01'),
	   ('3', '2', 'Выполнить тестовое задание', 'Home.psd', '2019-01-01', '0', '2018-12-25'),
       ('2', '3', 'Сделать задание первого раздела','Home.psd', '2019-01-01', '1', '2019-12-21'),
       ('1', '4', 'Встреча с другом', 'Home.psd', '2019-01-01', '0', '2018-12-22'),
       ('4', '5', 'Купить корм для кота', 'Home.psd', '2019-01-01', '0', null),
       ('4', '6', 'Заказать пиццу', 'Home.psd', '2019-01-01', '0', null);

CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(100),
	data_regist DATE,
	email VARCHAR(100),
	password VARCHAR(100)
);

INSERT INTO users (username, data_regist, email, password)
VALUES 	('Иван', '2019-01-01', 'ivan@mail.ru', '123456'),
		('Алексей', '2019-01-02', 'alex@mail.ru', '123456'),
		('Степан', '2019-01-03', 'step@mail.ru', '123456'),
		('Сергей', '2019-01-04', 'serg@mail.ru', '123456'),
		('Григорий', '2019-01-05', 'grig@mail.ru', '123456');

