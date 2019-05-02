
USE things;
INSERT INTO project (name_project)
VALUES ('Входящие'), ('Учеба'),  ('Работа'), ('Домашние дела'), ('Авто');

INSERT INTO task (project_id, user_id, name_task, dowloads, date_start, status_task, date_term )
VALUES ('3', '1', 'Собеседование в IT-компании', 'Home.psd', '2019-01-01', '0', '2019-12-01'),
	   ('3', '1', 'Выполнить тестовое задание', 'Home.psd', '2019-01-01', '0', '2018-12-25'),
       ('2', '2', 'Сделать задание первого раздела','Home.psd', '2019-01-01', '1', '2019-12-21'),
       ('1', '4', 'Встреча с другом', 'Home.psd', '2019-01-01', '0', '2018-12-22'),
       ('4', '2', 'Купить корм для кота', 'Home.psd', '2019-01-01', '0', null),
       ('4', '6', 'Заказать пиццу', 'Home.psd', '2019-01-01', '0', null);
       
INSERT INTO users (user_name, date_regist, email, password_user)
VALUES 	('Иван', '2019-01-01', 'ivan@mail.ru', '123456'),
		('Алексей', '2019-01-02', 'alex@mail.ru', '123456'),
		('Степан', '2019-01-03', 'step@mail.ru', '123456'),
		('Сергей', '2019-01-04', 'serg@mail.ru', '123456'),
		('Григорий', '2019-01-05', 'grig@mail.ru', '123456');
 /*
 Из всех проектов для одного пользователя. Объедините проекты с
 задачами, чтобы посчитать количество задач в каждом проекте и в
 дальнейшем выводить эту цифру рядом с именем проекта.
 */ 
SELECT count(t.name_task) AS COUNT, p.name_project,u.user_name
FROM project p
JOIN task t ON t.project_id = p.id
JOIN users u ON t.user_id = u.id
WHERE u.user_name = 'Иван'
GROUP BY p.name_project,u.user_name

/*
получить список из всех задач для одного проекта.
*/
SELECT p.name_project, name_task FROM task t
JOIN project p
ON p.id= t.project_id
WHERE name_project = 'Работа'

/*
Пометить задачу как выполненную.
*/
UPDATE task SET status_task = '1' WHERE id = '1'
SELECT * FROM task

 /*
Пометить задачу как выполненную.
*/ 
UPDATE task SET name_task  = 'Поехать на Алтай' WHERE id = '1'
