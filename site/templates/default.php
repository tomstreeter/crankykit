<?php

/** @var Kirby\Cms\Page $page */
/** @var Kirby\Cms\Site $site */
snippet('header');
snippet('main-open');
?>
<h3>
	<?= $page->title() ?>
</h3>



<?php

snippet('main-close');
snippet("footer");
?>