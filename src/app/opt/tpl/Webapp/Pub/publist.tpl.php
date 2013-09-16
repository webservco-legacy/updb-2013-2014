<article>

	<h2><?php echo $strings['title']; ?></h2>
	
<?php
if (!empty($publications)) {
	
	foreach ($publications as $pub) {
		echo "<p><strong><a href=\"{$url['www']}Pub/App/PubView/pub/{$pub['pub_id']}\">{$pub['pub_title']}</a></strong> / <i>{$pub['pub_type_title']}</i> / {$pub['country_name']}";
		echo "</p>";	
	}
	
} else {
	
	echo "<p class=\"ko\">{$strings['no_data']}</p>";
}

	echo "<p><a href=\"{$url['www']}Pub/Edit/PubAdd\">" . __('Add publication') . "<a></p>";
?>

</article>