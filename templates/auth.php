<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category) : ?>
            <li class="nav__item">
                <a href="all-lots.html"><?= htmlspecialchars($category['title']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form container <?php if (count($errors)) : ?> form--invalid<?php endif; ?>" action="auth.php" method="post">
    <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item<?php if (isset($errors['email'])|| isset($errors['email_error'])) : ?> form__item--invalid<?php endif; ?>">
        <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= (isset($form['email'])) ? htmlspecialchars($form['email']) : ''; ?>">
        <span class="form__error">
            <?php if (isset($errors['email'])) : ?>Введите e-mail<?php endif; ?>
            <?php if (isset($errors['email_error'])) : ?>Пользователь не найден<?php endif; ?>
        </span>
    </div>
    <div class="form__item form__item--last <?php if (isset($errors['password']) || isset($errors['password_error'])) : ?> form__item--invalid<?php endif; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль">
        <span class="form__error">
            <?php if (isset($errors['password'])) : ?>Введите пароль<?php endif; ?>
            <?php if (isset($errors['password_error'])) : ?>Неверный пароль<?php endif; ?>
        </span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Войти</button>
</form>
