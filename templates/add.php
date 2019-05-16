<?php
/** @var array $projects */
/** @var array $errors */

?>

<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="add.php" enctype="multipart/form-data" method="post" autocomplete="off">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?php if (array_key_exists('name', $errors)): ?> form__input--error <?php endif ?>"
               type="text" name="name" id="name"
               value="<?php if (!empty($form_data['name'])) echo $form_data['name'] ?>"
               placeholder="Введите название">
        <?php if (array_key_exists('name', $errors)) : ?>
            <p class="form__message">
                <?= $errors['name'] ?>
            </p>
        <?php endif ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select name='project' class="form__input form__input--select
                        <?php if (array_key_exists('project', $errors)): ?> form__input--error <?php endif ?>"
                name="project" id="project">
            <?php foreach ($projects as $project): ?>
                <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
            <?php endforeach ?>
        </select>

        <?php if (array_key_exists('project', $errors)) : ?>
            <p class="form__message">
                <?= $errors['project'] ?>
            </p>
        <?php endif ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?php if (array_key_exists('date', $errors)): ?> form__input--error <?php endif ?>"
               type="text" name="date" id="date" value=""
               placeholder="Введите дату в формате ГГГГ-ММ-ДД">

        <?php if (array_key_exists('date', $errors)) : ?>
            <p class="form__message">
                <?= $errors['date'] ?>
            </p>
        <?php endif ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
            <input  type="file" name="file" id="file" value="">

<!--            <label class="button button--transparent" for="file">-->
<!--                <span>Выберите файл</span>-->
<!--            </label>-->
        </div>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
