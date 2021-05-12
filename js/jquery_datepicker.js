$(function() {
    $( "#datepicker" ).datepicker({
		dateFormat:'d MM yy',
		showOn: "both",
		buttonImageOnly: true,
		buttonImage: "../_templates/default/img/icon_date_picker_24.gif",
		buttonText: "Calendar",
		changeMonth: true,
        gotoCurrent:true
	});
});