DROP DATABASE IF EXISTS things;

CREATE DATABASE things;

USE things;

CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(100),
	data_regist DATETIME,
	email VARCHAR(100),
	password VARCHAR(100)
);

INSERT INTO users (id,username, data_regist, email, password)
VALUES 	(1, 'Иван', '2019-01-01', 'ivan@mail.ru', '123456'),
		(2, 'Алексей', '2019-01-02', 'alex@mail.ru', '123456'),
		(3, 'Степан', '2019-01-03', 'step@mail.ru', '123456'),
		(4, 'Сергей', '2019-01-04', 'serg@mail.ru', '123456'),
		(5, 'Григорий', '2019-01-05', 'grig@mail.ru', '123456');


CREATE TABLE projects (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR (200)
);
alter table projects
	add user_id int not null;

INSERT INTO projects (user_id,name)
VALUES (4, 'Входящие'),
       (4, 'Учеба'),
       (1, 'Работа'),
       (1, 'Домашние дела'),
       (2, 'Авто');


CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	project_id INT(10),
	user_id INT(100),
	name VARCHAR (200),
	dowloads VARCHAR(100),
	date_start DATETIME,
	completed BOOL,
	date_term DATE
);

INSERT INTO tasks (project_id, user_id, name, dowloads, date_start, completed , date_term )
VALUES ('3', '1', 'Собеседование в IT-компании', 'Home.psd', '2019-01-01', '0', '2019-12-01'),
	   ('3', '2', 'Выполнить тестовое задание', 'Home.psd', '2019-01-01', '0', '2018-12-25'),
       ('2', '3', 'Сделать задание первого раздела','Home.psd', '2019-01-01', '1', '2019-12-21'),
       ('1', '4', 'Встреча с другом', 'Home.psd', '2019-01-01', '0', '2018-12-22'),
       ('4', '5', 'Купить корм для кота', 'Home.psd', '2019-01-01', '0', null);



CREATE FULLTEXT INDEX text_search ON tasks(name);


