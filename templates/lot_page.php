<nav class="nav">
	<ul class="nav__list container">
		<li class="nav__item">
			<a href="all-lots.html">Доски и лыжи</a>
		</li>
		<li class="nav__item">
			<a href="all-lots.html">Крепления</a>
		</li>
		<li class="nav__item">
			<a href="all-lots.html">Ботинки</a>
		</li>
		<li class="nav__item">
			<a href="all-lots.html">Одежда</a>
		</li>
		<li class="nav__item">
			<a href="all-lots.html">Инструменты</a>
		</li>
		<li class="nav__item">
			<a href="all-lots.html">Разное</a>
		</li>
	</ul>
</nav>
<section class="lot-item container">
	<h2><?= htmlspecialchars($lotData['name']); ?></h2>
	<div class="lot-item__content">
		<div class="lot-item__left">
			<div class="lot-item__image">
				<img src="<?= $lotData['img_url']; ?>" width="730" height="548" alt="Сноуборд">
			</div>
			<p class="lot-item__category">Категория: <span><?= $lotData['category_name']; ?></span></p>
			<p class="lot-item__description"><?= htmlspecialchars($lotData['description']); ?></p>
		</div>
		<div class="lot-item__right">
			<div class="lot-item__state">
				<div class="lot-item__timer timer">
					<?= getFormattedTimeDifference($lotData['date_closed']); ?>
				</div>
				<div class="lot-item__cost-state">
					<div class="lot-item__rate">
						<span class="lot-item__amount">Текущая цена</span>
						<span class="lot-item__cost"><?= getFormattedPrice(strip_tags($currentPrice)); ?></span>
					</div>
					<div class="lot-item__min-cost">
						Мин. ставка <span><?= getFormattedPrice(strip_tags($minBet)); ?></span>
					</div>
				</div>
				<?php if ($isBetAddShown): ?>
					<form class="lot-item__form" action="lot.php?id=<?= $lotData['lot_id']; ?>" method="post">
						<p class="lot-item__form-item">
							<label for="cost">Ваша ставка</label>
							<input id="cost" type="number" name="cost" placeholder="12 000">
						</p>
						<button type="submit" class="button">Сделать ставку</button>
					</form>
				<?php endif; ?>
			</div>
			<?php if ($isAuth): ?>
				<div class="history">
					<h3>История ставок (<span><?= $betAmount; ?></span>)</h3>
					<table class="history__list">
						<?php foreach ($betList as $betItem): ?>
							<tr class="history__item">
								<td class="history__name"><?= $betItem['user_id']; ?></td>
								<td class="history__price"><?= getFormattedPrice(strip_tags($betItem['price'])); ?></td>
								<td class="history__time"><?= $betItem['date_created']; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>