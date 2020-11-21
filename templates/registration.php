    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= htmlspecialchars($category['title']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?php if (count($errors)) : ?> form--invalid<?php endif; ?>" action="registration.php" method="post" enctype="multipart/form-data">
        <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?php if (isset($errors['email']) || isset($errors['email_validate']) || isset($errors['email_unique'])) : ?> form__item--invalid<?php endif; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= (isset($form['e_mail'])) ? htmlspecialchars($form['e_mail']) : ''; ?>">
            <span class="form__error">
                <?php if (isset($errors['email'])) : ?>Введите e-mail<?php endif; ?>
                <?php if (isset($errors['email_validate'])) : ?>Неправильный формат e-mail<?php endif; ?>
                <?php if (isset($errors['email_unique'])) : ?>Этот e-mail уже есть<?php endif; ?>
            </span>
        </div>
        <div class="form__item <?php if (isset($errors['password'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль" value="">
            <span class="form__error">Введите пароль</span>
        </div>
        <div class="form__item <?php if (isset($errors['name'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= (isset($form['name'])) ? htmlspecialchars($form['name']) : ''; ?>">
            <span class="form__error">Введите имя</span>
        </div>
        <div class="form__item <?php if (isset($errors['message'])) : ?> form__item--invalid<?php endif; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= (isset($form['contacts'])) ? htmlspecialchars($form['contacts']) : ''; ?></textarea>
            <span class="form__error">Напишите как с вами связаться</span>
        </div>
        <div class="form__item form__item--file form__item--last<?php if (isset($errors['file']) && !isset($form['user_file'])) : ?> form__item--invalid<?php else : ?> form__item--uploaded<?php endif; ?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="<?php if (!isset($errors['file']) && isset($form['user_file'])) : ?>img/<?= $form['user_file'] ?><?php endif; ?>" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="avatar" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"> Загрузите картинку в формате JPEG, JPG или PNG </span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="http://16605-yeticave/auth.php">Уже есть аккаунт</a>
    </form>
