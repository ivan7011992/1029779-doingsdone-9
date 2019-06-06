Use things;

 /*
 Из всех проектов для одного пользователя. Объедините проекты с
 задачами, чтобы посчитать количество задач в каждом проекте и в
 дальнейшем выводить эту цифру рядом с именем проекта.
 */ 
SELECT count(t.name) AS count, p.name,u.username
FROM projects p
JOIN tasks t ON t.project_id = p.id
JOIN users u ON t.user_id = u.id
WHERE u.username = 'Иван'
GROUP BY  p.name,u.username

/*
получить список из всех задач для одного проекта.
*/
SELECT p.Name, t.Name FROM tasks t
JOIN projects p
ON p.id= t.Project_id 
WHERE  p.Name = 'Работа'

/*
Пометить задачу как выполненную.
*/
UPDATE tasks SET completed = '1' WHERE id = '1'
SELECT * FROM tasks

 /*
Изменить название задачи.
*/ 
UPDATE tasks SET Name  = 'Поехать на Алтай' WHERE id = '1'
