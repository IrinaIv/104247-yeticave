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
	<h2><?= $lotData['name']; ?></h2>
	<div class="lot-item__content">
		<div class="lot-item__left">
			<div class="lot-item__image">
				<img src="<?= $lotData['img_url']; ?>" width="730" height="548" alt="Сноуборд">
			</div>
			<p class="lot-item__category">Категория: <span><?= $lotData['category_name']; ?></span></p>
			<p class="lot-item__description"><?= $lotData['description']; ?></p>
		</div>
		<div class="lot-item__right">
			<div class="lot-item__state">
				<div class="lot-item__timer timer">
					10:54:12
				</div>
				<div class="lot-item__cost-state">
					<div class="lot-item__rate">
						<span class="lot-item__amount">Текущая цена</span>
						<span class="lot-item__cost"><?= getFormattedPrice($currentPrice); ?></span>
					</div>
					<div class="lot-item__min-cost">
						Мин. ставка <span><?= getFormattedPrice(strip_tags($lotData['bet_step'])); ?></span>
					</div>
				</div>
				<?php if (false): ?>
					<form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
						<p class="lot-item__form-item">
							<label for="cost">Ваша ставка</label>
							<input id="cost" type="number" name="cost" placeholder="12 000">
						</p>
						<button type="submit" class="button">Сделать ставку</button>
					</form>
				<?php endif; ?>
			</div>
			<?php if (false): ?>
				<div class="history">
					<h3>История ставок (<span><?= $betAmount; ?></span>)</h3>
					<table class="history__list">
						<?php foreach ($betList as $betItem): ?>
							<tr class="history__item">
								<td class="history__name"><?= $betItem['author']; ?></td>
								<td class="history__price"><?= $betItem['price']; ?></td>
								<td class="history__time"><?= $betItem['date']; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>