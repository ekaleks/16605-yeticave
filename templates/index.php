<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">

        <?php foreach ($categories as $category) : ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category['title']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">

        <?php foreach ($ads as $ad) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="img/<?php if (isset($ad['user_file'])) : ?><?= htmlspecialchars($ad['user_file']); ?><?php endif; ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?php if (isset($ad['category'])) : ?><?= htmlspecialchars($ad['category']); ?><?php endif; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?php if (isset($ad['id'])) : ?><?= htmlspecialchars($ad['id']); ?><?php endif; ?>"><?php if (isset($ad['title'])) : ?><?= htmlspecialchars($ad['title']); ?><?php endif; ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?php if (isset($ad['price'])) : ?><?= htmlspecialchars(is_formatting_price($ad['price'])); ?><?php endif; ?></span>
                        </div>
                        <div class="lot__timer timer">
                            <?php if (isset($ad['date_completion'])) : ?><?= htmlspecialchars(timer($ad['date_completion'])); ?><?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
