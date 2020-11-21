<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category) : ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category['title']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form form--add-lot container <?php if (count($errors)) : ?> form--invalid<?php endif; ?>" action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item<?php if (isset($errors['lot-name'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= (isset($lot['title'])) ? htmlspecialchars($lot['title']) : ''; ?>">
            <span class="form__error">Введите наименование лота</span>
        </div>
        <div class="form__item <?php if (isset($errors['category'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="category">Категория</label>
            <select id="category" name="category">
                <option></option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= htmlspecialchars($category['id']); ?>"><?= htmlspecialchars($category['title']); ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide<?php if (isset($errors['lot-name'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?= (isset($lot['description_lot'])) ? htmlspecialchars($lot['description_lot']) : ''; ?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <div class="form__item form__item--file <?php if (isset($errors['file']) || isset($errors['file-format']) && !isset($lot['user_file'])) : ?> form__item--invalid <?php else : ?> form__item--uploaded <?php endif; ?>">
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?php if (!isset($errors['file']) || !isset($errors['file-format']) && isset($lot['user_file'])) : ?>img/<?= $lot['user_file'] ?><?php endif; ?>" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" name="avatar" type="file" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error">
            <?php if (isset($errors['file'])) : ?> Вы не загрузили файл<?php endif; ?>
                <?php if (isset($errors['file-format'])) : ?> Загрузите картинку в формате JPEG, JPG или PNG<?php endif; ?>
        </span>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small<?php if (isset($errors['lot-rate']) || isset($errors['lot-rate-size']) || isset($errors['lot-rate-round'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= (isset($lot['starting_price'])) ? htmlspecialchars($lot['starting_price']) : ''; ?>">
            <span class="form__error">
                <?php if (isset($errors['lot-rate'])) : ?> Введите начальную цену<?php endif; ?>
                <?php if (isset($errors['lot-rate-size'])) : ?> Введите число большее нуля<?php endif; ?>
                <?php if (isset($errors['lot-rate-round'])) : ?> Введите целое число<?php endif; ?>
            </span>
        </div>
        <div class="form__item form__item--small<?php if (isset($errors['lot-step']) || isset($errors['lot-step-size']) || isset($errors['lot-step-round'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= (isset($lot['bid_step'])) ? htmlspecialchars($lot['bid_step']) : ''; ?>">
            <span class="form__error">
                <?php if (isset($errors['lot-step-size'])) : ?> Введите число большее нуля <?php endif; ?>
                <?php if (isset($errors['lot-step'])) : ?> Введите шаг ставки <?php endif; ?>
                <?php if (isset($errors['lot-step-round'])) : ?> Введите целое число <?php endif; ?>
            </span>
        </div>
        <div class="form__item<?php if (isset($errors['lot-date']) || isset($errors['lot-date-format'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="text" name="lot-date" value="<?= (isset($lot['date_completion'])) ? htmlspecialchars($lot['date_completion']) : ''; ?>">
            <span class="form__error">
                <?php if (isset($errors['lot-date'])) : ?> Введите дату завершения торгов<?php endif; ?>
                    <?php if (isset($errors['lot-date-format']) && !isset($errors['lot-date'])) : ?> Дата завершения торгов торгов должна быть в формате ДД.ММ.ГГГГ и больше текущей даты хотя бы на один день.<?php endif; ?>
            </span>
        </div>
    </div>

    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>

    <button type="submit" class="button">Добавить лот</button>
</form>
