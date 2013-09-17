$(document).ready(function() {
	
	$('.sortable').sortable({
		update: function(event, ui) {
			
			$.post( url_www + "Pub/Ajax/Edit/", {

				action : 'images_order',
				images : $(this).sortable('toArray')

			}, function(response) {

				//console.log(response);
			});
		}
	}).disableSelection();
	
});
