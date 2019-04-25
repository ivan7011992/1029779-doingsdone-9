

Use things;
 Drop table if exists  project;
 Drop table if exists  task;
 drop table if exists users;
 
Create table project (
id int auto_increment primary key,
Name_Project varchar (200)
);
Insert Into project (Name_Project)
Values ('Входящие'),  ('Учеба'),  ('Работа'),  ('Домашние дела'),  ('Авто');

Create table task(
id int auto_increment primary key,
Project_id int(10), 
User_id int(100),
Name_Task varchar (200),
Dowloads varchar(100),
Data_start date,  
Status_task int(10),
Date_term date
);

Insert Into task (Project_id, User_id, Name_Task, Dowloads, Data_start, Status_task, Date_term )
values ('3', '1', 'Собеседование в IT-компании', 'Home.psd', '2019-01-01', '0', '2019-12-01'),
	   ('3', '2', 'Выполнить тестовое задание', 'Home.psd', '2019-01-01', '0', '2018-12-25'),
       ('2', '3', 'Сделать задание первого раздела','Home.psd', '2019-01-01', '1', '2019-12-21'),
       ('1', '4', 'Встреча с другом', 'Home.psd', '2019-01-01', '0', '2018-12-22'),
       ('4', '5', 'Купить корм для кота', 'Home.psd', '2019-01-01', '0', null),
       ('4', '6', 'Заказать пиццу', 'Home.psd', '2019-01-01', '0', null);

Create table users(
id int auto_increment primary key,
user_name varchar(100),
Data_regist date,
email varchar(100),
password_user varchar (100)
);


Insert Into users (user_name, Data_regist, email, password_user)
values 	('Иван', '2019-01-01', 'ivan@mail.ru', '123456'),
		('Алексей', '2019-01-02', 'alex@mail.ru', '123456'),
		('Степан', '2019-01-03', 'step@mail.ru', '123456'),
		('Сергей', '2019-01-04', 'serg@mail.ru', '123456'),
		('Григорий', '2019-01-05', 'grig@mail.ru', '123456');

