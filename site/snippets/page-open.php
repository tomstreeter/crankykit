<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= css('assets/css/main.css'); ?>
	<link rel="icon" href="<?= url('assets/images/favicon.ico') ?>" sizes="any">
	<link rel="icon" href="<?= url('assets/images/favicon.svg') ?>" type="image/svg+xml">
	<link rel="apple-touch-icon" href="<?= url('/assets/images/apple-touch-icon.png') ?>">
	<link rel="manifest" href="<?= url('/assets/images/manifest.webmanifest') ?>">
	<title>
		<?= $page->title() . ' | ' . $site->title(); ?>
	</title>
</head>

<body>
	<div class="stack">