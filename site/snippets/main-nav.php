<?php $items = $site->children()->listed(); ?>

<?php if ($items->isNotEmpty()) : ?>

	<nav class="main-nav" aria-label="Main">
		<ul>
			<?php foreach ($items as $item) : ?>
				<?php if ($item->isOpen()) : ?>
					<li class="active"> <?= $item->title()->html() ?> </li>
				<?php else : ?>
					<li>
						<a href="<?= $item->url() ?>">
							<?= $item->title()->html() ?>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</nav>
<?php endif ?>