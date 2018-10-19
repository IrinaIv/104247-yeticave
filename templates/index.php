<section class="promo">
	<h2 class="promo__title">Нужен стафф для катки?</h2>
	<p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
		горнолыжное снаряжение.</p>
	<ul class="promo__list">
		<?php foreach ($categoryList as $categoryItem): ?>
			<li class="promo__item promo__item--boards">
				<a class="promo__link" href="pages/all-lots.html"><?= $categoryItem['title']; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
<section class="lots">
	<div class="lots__header">
		<h2>Открытые лоты</h2>
	</div>
	<ul class="lots__list">
		<?php foreach ($lotList as $lotItem): ?>
			<li class="lots__item lot">
				<div class="lot__image">
					<img src="<?= $lotItem['img_url']; ?>" width="350" height="260" alt="">
				</div>
				<div class="lot__info">
					<span class="lot__category"><?= $lotItem['category_name']; ?></span>
					<h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lotItem['lot_id']; ?>"><?= htmlspecialchars($lotItem['name']); ?></a></h3>
					<div class="lot__state">
						<div class="lot__rate">
							<span class="lot__amount">Стартовая цена</span>
							<span class="lot__cost">
								<?= getFormattedPrice(strip_tags($lotItem['started_price'])); ?>&nbsp;&#8381;
							</span>
						</div>
						<div class="lot__timer timer">
							<?= getFormattedTimeDifference($lotItem['date_closed']); ?>
						</div>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>