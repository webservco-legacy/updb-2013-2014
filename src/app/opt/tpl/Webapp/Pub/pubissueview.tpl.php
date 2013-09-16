<article>

<?php
if (!empty($pub)) {
	
	echo "<h2>{$pub['pub_title']} #{$issue['pub_issue_number']} ({$pub['country_name']})</h2>";
	
	echo "<p>{$issue['pub_issue_description']}</p>";
	
	echo "<p><strong>" . __('Type') . "</strong>: {$pub['pub_type_title']}</p>";
	echo "<p><strong>" . __('Format') . "</strong>: {$issue['pub_format_title']}</p>";
	echo "<p><strong>" . __('Year') . "</strong>: {$issue['pub_issue_year']}</p>";
	echo "<p><strong>" . __('Pages') . "</strong>: {$issue['pub_issue_pages']}</p>";
	
	if (!empty($issue['content_data'])) {
		
		foreach ($issue['content_data'] as $title => $data) {
			
			echo "<p><strong>{$title}</strong>: ";
			echo !empty($data) ? implode(', ', $data) : "---";
			echo "</p>";
		}
	}
	
	if (!empty($issue['content_values'])) {
		
		foreach ($issue['content_values'] as $title => $data) {
			
			echo "<p><strong>{$title}</strong>: ";
			echo !empty($data) ? "Y" : "---";
			echo "</p>";
		}
	}
	
	echo "<p><a href=\"{$url['www']}Pub/Edit/PubIssueModify/issue/{$issue['pub_issue_id']}\">" . __('Modify issue') . "</a></p>";
	
	echo "<p><a href=\"{$url['www']}Pub/App/PubView/pub/{$pub['pub_id']}\">" . __('Issues list') . "</a></p>";
	
	echo "<p><a href=\"{$url['www']}Pub/App/PubList\">" . __('Publications list') . "<a></p>";

} else {
	
	echo "<p class=\"ko\">{$strings['no_data']}</p>";
}
?>

</article>