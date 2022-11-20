<?php snippet('head'); ?>

<h1>
	This site has the name <code><?= $page->title() ?></code>
</h1>
<p>The page <code><?= $page->title() ?></code> is being rendered by the <code>default.php</code> template. It's unlikely
	this is the desired behavior. Then again, I'm not the boss of you.</p>

<?php snippet("foot"); ?>