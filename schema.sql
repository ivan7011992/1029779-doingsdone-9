

USE things;
	DROP TABLE if EXISTS  project;
	DROP TABLE if EXISTS  task;
	DROP TABLE if EXISTS users;
 
CREATE TABLE project (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name_Project VARCHAR (200)
);
INSERT INTO project (name_project)
VALUES ('Входящие'),  ('Учеба'),  ('Работа'),  ('Домашние дела'),  ('Авто');

CREATE TABLE task(
	id int auto_increment primary key,
	project_id int(10),
	user_id int(100),
	name_task varchar (200),
	dowloads varchar(100),
	date_start date,
	status_task int(10),
	date_term date
);

INSERT INTO task (project_id, user_id, name_task, dowloads, date_start, status_task, date_term )
VALUES ('3', '1', 'Собеседование в IT-компании', 'Home.psd', '2019-01-01', '0', '2019-12-01'),
	   ('3', '2', 'Выполнить тестовое задание', 'Home.psd', '2019-01-01', '0', '2018-12-25'),
       ('2', '3', 'Сделать задание первого раздела','Home.psd', '2019-01-01', '1', '2019-12-21'),
       ('1', '4', 'Встреча с другом', 'Home.psd', '2019-01-01', '0', '2018-12-22'),
       ('4', '5', 'Купить корм для кота', 'Home.psd', '2019-01-01', '0', null),
       ('4', '6', 'Заказать пиццу ', 'Home.psd', '2019-01-01', '0', null);

CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR(100),
	data_regist DATE,
	email VARCHAR(100),
	password_user VARCHAR(100)
);

INSERT INTO users (user_name, data_regist, email, password_user)
VALUES 	('Иван', '2019-01-01', 'ivan@mail.ru', '123456'),
		('Алексей', '2019-01-02', 'alex@mail.ru', '123456'),
		('Степан', '2019-01-03', 'step@mail.ru', '123456'),
		('Сергей', '2019-01-04', 'serg@mail.ru', '123456'),
		('Григорий', '2019-01-05', 'grig@mail.ru', '123456');

