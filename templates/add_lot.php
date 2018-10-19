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
<form class="form form--add-lot container <?= count($errors) ? 'form--invalid' : ''; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
	<h2>Добавление лота</h2>
	<div class="form__container-two">
		<?php $classname = isset($errors['lot_name']) ? 'form__item--invalid' : '';
		$value = isset($lot['lot_name']) ? htmlspecialchars($lot['lot_name']) : ''; ?>
		<div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
			<label for="lot-name">Наименование</label>
			<input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота" value="<?= $value; ?>" required>
			<span class="form__error"><?= $errors['lot_name']; ?></span>
		</div>
		<?php $classname = isset($errors['category']) ? 'form__item--invalid' : ''; ?>
		<div class="form__item <?= $classname; ?>">
			<label for="category">Категория</label>
			<select id="category" name="category" required>
				<option value="">Выберите категорию</option>
				<?php foreach ($categoryList as $categoryItem):
					$selected = isset($lot['category']) && $lot['category'] === $categoryItem['category_id'] ? 'selected' : ''?>
					<option value="<?= $categoryItem['category_id']; ?>" <?= $selected; ?>><?= $categoryItem['title']; ?></option>
				<?php endforeach; ?>
			</select>
			<span class="form__error"><?= $errors['category']; ?></span>
		</div>
	</div>
	<?php $classname = isset($errors['message']) ? 'form__item--invalid' : '';
	$value = isset($lot['message']) ? htmlspecialchars($lot['message']) : ''; ?>
	<div class="form__item form__item--wide <?= $classname; ?>">
		<label for="message">Описание</label>
		<textarea id="message" name="message" placeholder="Напишите описание лота" required><?= $value; ?></textarea>
		<span class="form__error"><?= $errors['message']; ?></span>
	</div>
	<?php $classname = isset($lot['img_path']) ? 'form__item--uploaded' : ''; ?>
	<div class="form__item form__item--file <?= $classname; ?>"> <!-- form__item--uploaded -->
		<label>Изображение</label>
		<div class="preview">
			<button class="preview__remove" type="button">x</button>
			<div class="preview__img">
				<img src="<?= $lot['img_path'] ?? 'img/avatar.jpg'; ?>" width="113" height="113" alt="Изображение лота">
			</div>
		</div>
		<div class="form__input-file">
			<?php if (isset($errors['file'])): ?>
				<span class="form__error"><?= $errors['file']; ?></span>
			<?php endif; ?>
			<input class="visually-hidden" name="lot_img" type="file" id="photo2" value="">
			<label for="photo2">
				<span>+ Добавить</span>
			</label>
		</div>
	</div>
	<div class="form__container-three">
		<?php $classname = isset($errors['lot_rate']) ? 'form__item--invalid' : '';
		$value = isset($lot['lot_rate']) ? intval($lot['lot_rate']) : ''; ?>
		<div class="form__item form__item--small <?= $classname; ?>">
			<label for="lot-rate">Начальная цена</label>
			<input id="lot-rate" type="number" name="lot_rate" placeholder="0" value="<?= $value; ?>" required>
			<span class="form__error"><?= $errors['lot_rate']; ?></span>
		</div>
		<?php $classname = isset($errors['lot_step']) ? 'form__item--invalid' : '';
		$value = isset($lot['lot_step']) ? intval($lot['lot_step']) : ''; ?>
		<div class="form__item form__item--small <?= $classname; ?>">
			<label for="lot-step">Шаг ставки</label>
			<input id="lot-step" type="number" name="lot_step" placeholder="0" value="<?= $value; ?>" required>
			<span class="form__error"><?= $errors['lot_step']; ?></span>
		</div>
		<?php $classname = isset($errors['lot_date']) ? 'form__item--invalid' : '';
		$value = isset($lot['lot_date']) ? strip_tags($lot['lot_date']) : ''; ?>
		<div class="form__item <?= $classname; ?>">
			<label for="lot-date">Дата окончания торгов</label>
			<input class="form__input-date" id="lot-date" type="date" name="lot_date" value="<?= $value; ?>" required>
			<span class="form__error"><?= $errors['lot_date']; ?></span>
		</div>
	</div>
	<span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
	<button type="submit" class="button">Добавить лот</button>
</form>