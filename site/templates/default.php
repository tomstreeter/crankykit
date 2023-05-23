<html>
<?php snippet('layout/head') ?>

<body>
	<header>
		<h1>
			<?= $site->title(); ?>
		</h1>
		<h2>
			<?= $site->subtitle(); ?>
		</h2>
	</header>
	<main>
		<h3>
			<?= $page->title(); ?>
		</h3>
		<p>Supposed to be rendered by the
			<?= $page->intendedTemplate(); ?> template.
		</p>
		<p>Actually rendered by the
			<?= $page->template(); ?> template.
		</p>
	</main>
</body>

</html>