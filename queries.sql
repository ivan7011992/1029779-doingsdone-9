Use things;

Insert Into project (Name_Project)
Values ('Входящие'),  ('Учеба'),  ('Работа'),  ('Домашние дела'),  ('Авто');

Insert Into task (Project_id, User_id, Name_Task, Dowloads, Data_start, Status_task, Date_term )
Values ('3', '1', 'Собеседование в IT-компании', 'Home.psd', '2019-01-01', '0', '2019-12-01'),
	   ('3', '1', 'Выполнить тестовое задание', 'Home.psd', '2019-01-01', '0', '2018-12-25'),
       ('2', '2', 'Сделать задание первого раздела','Home.psd', '2019-01-01', '1', '2019-12-21'),
       ('1', '4', 'Встреча с другом', 'Home.psd', '2019-01-01', '0', '2018-12-22'),
       ('4', '2', 'Купить корм для кота', 'Home.psd', '2019-01-01', '0', null),
       ('4', '6', 'Заказать пиццу', 'Home.psd', '2019-01-01', '0', null);
       
Insert Into users (user_name, Data_regist, email, password_user)
Values 	('Иван', '2019-01-01', 'ivan@mail.ru', '123456'),
		('Алексей', '2019-01-02', 'alex@mail.ru', '123456'),
		('Степан', '2019-01-03', 'step@mail.ru', '123456'),
		('Сергей', '2019-01-04', 'serg@mail.ru', '123456'),
		('Григорий', '2019-01-05', 'grig@mail.ru', '123456');
 /*
 Из всех проектов для одного пользователя. Объедините проекты с
 задачами, чтобы посчитать количество задач в каждом проекте и в
 дальнейшем выводить эту цифру рядом с именем проекта.
 */ 
Select count(t.name_task) as count, p.name_project,u.user_name
from project p
join task t on t.project_id = p.id
join users u on t.user_id = u.id
where u.user_name = 'Иван'
group by  p.name_project,u.user_name

/*
получить список из всех задач для одного проекта.
*/
Select p.Name_Project, Name_Task from task t
join project p
on p.id= t.Project_id 
where  Name_Project = 'Работа'

/*
Пометить задачу как выполненную.
*/
UPDATE task SET Status_task = '1' where id = '1'
select * from task

 /*
Пометить задачу как выполненную.
*/ 
UPDATE task SET Name_Task  = 'Поехать на Алтай' where id = '1'
