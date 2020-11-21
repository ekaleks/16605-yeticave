            <form class="lot-item__form" action="lot.php" method="post">
                <p class="lot-item__form-item form__item<?php if (isset($errors['cost']) || isset($errors['cost-size']) || isset($errors['cost-round'])) : ?> form__item--invalid<?php endif; ?>">
                    <label for="cost">Ваша ставка</label>
                    <input id="cost" type="text" name="cost" placeholder="12 000" value="<?= (isset($form['cost'])) ? htmlspecialchars($form['cost']) : ''; ?>">
                    <?php if (isset($errors['cost'])) : ?><span class="form__error">Введите ставку</span><?php endif; ?>
                    <?php if (isset($errors['cost-size'])) : ?><span class="form__error">Значение должно быть больше минимальной ставки</span><?php endif; ?>
                    <?php if (isset($errors['cost-round'])) : ?><span class="form__error">Значение должно быть целым числом </span><?php endif; ?>
                </p>

                <button type="submit" class="button">Сделать ставку</button>
            </form>
