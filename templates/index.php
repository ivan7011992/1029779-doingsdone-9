<?php
/** @var array $tasks */
?>
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post" autocomplete="off">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/index.php?filter-by-date=1" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/index.php?filter-by-date=2" class="tasks-switch__item">Повестка дня</a>
        <a href="/index.php?filter-by-date=3" class="tasks-switch__item">Завтра</a>
        <a href="/index.php?filter-by-date=4" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">

        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed"
               type="checkbox" <?php if ($show_complete_tasks === 1): ?> checked <?php endif ?> >
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php foreach ($tasks as $task): ?>
        <?php if ($task['completed'] === '0'): ?>
            <?php if (check_date($task['date_start'])): ?>
                <tr class="tasks__item task" >
            <?php else: ?>
                <tr class="tasks__item task  task--important">
            <?php endif ?>
            <td class="task__select">
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox"
                           value="<?= $task['id'] ?>">
                    <span class="checkbox__text"><?= esc($task['name']) ?></span>
                </label>
            </td>
            <td class="task__file">
                <a class="download-link" href="/uploads/<?= $task['dowloads'] ?>"><?= $task['dowloads'] ?></a>
            </td>
            <td class="task__date"><?= $task['date_start'] ?></td>
            </tr>
        <?php elseif ($task['completed'] === '1' && $show_complete_tasks === 1): ?>
            <tr class="tasks__item task task--completed">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox" checked>
                        <span class="checkbox__text"><?= $task['name'] ?></span>
                    </label>
                </td>
                <td class="task__date"><?= $task['date_start'] ?></td>
                <td class="task__controls"></td>
            </tr>
        <?php endif ?>
    <?php endforeach ?>
    <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
</table>
