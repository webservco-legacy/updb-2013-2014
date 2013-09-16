<article>

<?php
if (!empty($pub)) {
	
	echo "<h2>{$pub['pub_title']}</h2>";
	
	echo "<p><i>{$pub['pub_type_title']}</i> / {$pub['country_name']}</p>";
	
	echo "<p>{$pub['pub_description']}</p>";
	
	
	
	echo '<h3>' . __('Issues') . '</h3>';
	
	if (!empty($pub_issues)) {
		
		foreach ($pub_issues as $issue) {
			
			echo "<p><strong><a href=\"{$url['www']}Pub/App/PubIssueView/issue/{$issue['pub_issue_id']}\">{$pub['pub_title']}</a></strong> #{$issue['pub_issue_number']} / {$issue['pub_format_title']}";
			echo " / {$issue['pub_issue_year']} / {$issue['pub_issue_pages']} " . __('pages');
			echo " (<a href=\"{$url['www']}Pub/Edit/PubIssueModify/issue/{$issue['pub_issue_id']}\">edit</a>)";
			echo "</p>";
		}
	} else {
		
		echo "<p>{$strings['no_data']}</p>";
	}
	
	echo "<p><a href=\"{$url['www']}Pub/Edit/PubIssueAdd/pub/{$pub['pub_id']}\">" . __('Add issue') . "<a></p>";
	
	echo "<p><a href=\"{$url['www']}Pub/Edit/PubModify/pub/{$pub['pub_id']}\">" . __('Modify publication') . "</a></p>";
	
	echo "<p><a href=\"{$url['www']}Pub/App/PubList\">" . __('Publications list') . "<a></p>";
	
} else {
	
	echo "<p class=\"ko\">{$strings['no_data']}</p>";
}
?>

</article>