<article>

	<h2><?php echo $strings['title']; ?></h2>
	
<?php
if (!empty($publications)) {
	
	foreach ($publications as $pub) {
		echo "<p><strong>{$pub['pub_title']}</strong> / <i>{$pub['pub_type_title']}</i> / {$pub['country_name']}";
		echo " (<a href=\"{$url['www']}Pub/Edit/PubModify/pub/{$pub['pub_id']}\">edit</a>)";
		echo "</p>";	
	}
	
} else {
	
	echo "<p class=\"ko\">{$strings['no_data']}</p>";
}
?>

</article>