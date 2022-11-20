<?php

use Kirby\Cms\App as Kirby;

require __DIR__ . '/../kirby/bootstrap.php';

$kirby = new Kirby([
	'roots' => [
		'index'     => __DIR__,
		'base'      => $base = dirname(__DIR__),
		'content'   => $base . '/content',
		'site'      => $site = $base . '/site',
		'config'    => $site . '/config',
		'storage'   => $storage = $base . '/storage',
		'accounts'  => $storage . '/accounts',
		'cache'     => $storage . '/cache',
		'sessions'  => $storage . '/sessions'
	]
]);

echo $kirby->render();
