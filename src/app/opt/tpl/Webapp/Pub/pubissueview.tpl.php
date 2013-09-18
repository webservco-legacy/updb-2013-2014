<article>

<?php
if (!empty($pub_issue)) {
	
	//echo "<div class=\"pub_subtitle\"><i>{$pub['pub_type_title']}</i> ({$pub['country_name']})</div>";
	
	echo "<h2>{$pub_issue['pub_issue_title']}</h2>";
	
	echo "<div class=\"pub_content pub_box\">{$pub_issue['pub_issue_description']}</div>";
	
	echo '<div class="pub_content pub_box">';
	echo "<p><strong>" . __('Format') . "</strong>: {$pub_issue['pub_format_title']}</p>";
	echo "<p><strong>" . __('Year') . "</strong>: {$pub_issue['pub_issue_year']}</p>";
	echo "<p><strong>" . __('Pages') . "</strong>: {$pub_issue['pub_issue_pages']}</p>";
	echo '</div>';
	
	echo '<div class="pub_content pub_box">';
	
	if (!empty($pub_issue['content_data'])) {
		
		foreach ($pub_issue['content_data'] as $title => $data) {
			
			if (!empty($data)) {
				echo "<p><strong>{$title}</strong>: ";
				echo implode(', ', $data);
				echo "</p>";
			}
		}
	}
	
	if (!empty($pub_issue['content_values'])) {
		
		echo '<p>';
		
		echo '<strong>' . implode('</strong>, <strong>', $pub_issue['content_values']) . '</strong>';
		
		echo '</p>';
	}
	
	echo '</div>';
	
	if (!empty($pub_issue_images)) {
		
		echo '<div class="pub_gallery pub_content pub_box">';
		
		foreach ($pub_issue_images as $image_id => $image_data) {
			echo "<a class=\"gallery_item\" href=\"{$url['www']}usr/media/pub_issue/{$image_data['image_file']}\">";
			echo "<img src=\"{$url['www']}usr/media/pub_issue_t/{$image_data['image_thumb']}\" />";
			echo "</a>";
		}
		
		echo '</div>';
	}
	
	echo '<div class="content_nav">';
	
	if (!empty($user['isEditor'])) {
		
		echo "<p><a href=\"{$url['www']}Pub/Edit/PubIssueModify/issue/{$pub_issue['pub_issue_id']}\">" . __('Modify issue') . "</a></p>";
		
		echo "<p><a href=\"{$url['www']}Pub/Edit/PubIssueAdd/pub/{$pub_id}\">" . __('Add issue') . "</a></p>";
		
		echo "<p><a href=\"{$url['www']}Pub/Edit/PubIssueImagesEdit/id/{$pub_issue['pub_issue_id']}\">" . __('Manage issue images') . "</a></p>";
	
	}
	
	echo "<p><a href=\"{$url['www']}Pub/App/PubView/pub/{$pub_id}\">" . __('View all issues') . "</a></p>";
	
	echo "<p><a href=\"{$url['www']}Pub/App/PubList\">" . __('View all publications') . "</a></p>";
	
	echo '</div>';

} else {
	
	echo "<p class=\"ko\">{$strings['no_data']}</p>";
}
?>

</article>