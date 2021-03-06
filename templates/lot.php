<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category) : ?>
            <li class="nav__item">
                <a href="all-lots.html"><?= htmlspecialchars($category['title']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <?php foreach ($ads as $ad) : ?>
        <h2><?= htmlspecialchars($ad['title']); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="img/<?= htmlspecialchars($ad['user_file']); ?>" width="730" height="548" alt="<?= htmlspecialchars($ad['title']); ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= htmlspecialchars($ad['category']); ?></span></p>
                <p class="lot-item__description"><?= htmlspecialchars($ad['description_lot']); ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= htmlspecialchars($my_time); ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= htmlspecialchars($price); ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= htmlspecialchars($price + $ad['bid_step']); ?></span>
                        </div>
                    </div>
                    <?= $add_cost; ?>
                </div>
                <?= $history_cost; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>
