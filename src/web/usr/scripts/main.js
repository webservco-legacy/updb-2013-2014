$(document).ready(function() {
	
$('.datepicker').datepicker({
	    changeMonth: true,
	    changeYear: true,
	    showButtonPanel: true,
	    dateFormat: 'dd-mm-yy',
	    showOn: "both",
	    //buttonImage: url_skin + "img/transparent_button.png",
	    minDate: "0d",
	    beforeShow: function(input, inst) {
	        $('#ui-datepicker-div').removeClass('ui-datepicker-noday');
	    },
	    regional: 'it'
	});
	
	$('.datepicker_ym').datepicker({
	    changeMonth: true,
	    changeYear: true,
	    showButtonPanel: true,
	    dateFormat: 'mm-yy', //dd-mm-yy
	    showOn: "both",
	    //buttonImage: url_skin + "img/transparent_button.png",
	    onClose: function(dateText, inst) { 
	        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
	        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
	        $(this).datepicker('setDate', new Date(year, month, 1));
	    },
	    maxDate: "0d",
	    yearRange: "1950:" + new Date().getFullYear(),
	    beforeShow: function(input, inst) {
	        $('#ui-datepicker-div').addClass('ui-datepicker-noday');
	    },
	    regional: 'it'
	});

	
});
