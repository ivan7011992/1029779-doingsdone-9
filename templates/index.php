<?php
/** @var array $tasks */

?>
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="GET" autocomplete="off">
    <input class="search-form__input" type="text"
           name="search"
           value="<?= $search ?>"
           placeholder="Поиск по задачам">
    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <?php
        $filterTypes = [
            1 => 'Все задачи',
            2 => 'Повестка дня',
            3 => 'Завтра',
            4 => 'Просроченные'
        ]
        ?>
        <?php foreach ($filterTypes as $filterVal => $filterName): ?>
            <a href="/index.php?<?php if ($projectId !== null) echo 'project_id=' . $projectId . '&' ?>filter-by-date=<?= $filterVal ?>"
               class="tasks-switch__item <?php if ($filterByDate === $filterVal): ?>tasks-switch__item--active <?php endif ?>">
                <?= $filterName ?></a>
        <?php endforeach; ?>
    </nav>

    <label class="checkbox">

        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <a href="/index.php?<?php if ($projectId !== null) echo 'project_id=' . $projectId . '&' ?><?php if ($filterByDate !== null) echo 'filter-by-date=' . $filterByDate . '&' ?>show_completed=<?php if ($showComplete) echo '0'; else echo '1' ?>">
            <input class="checkbox__input visually-hidden"
                   type="checkbox" <?php if ($showComplete): ?> checked <?php endif ?> >
            <span class="checkbox__text">Показывать выполненные</span>
        </a>
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
        <?php elseif ($task['completed'] === '1'): ?>
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
