//Local Includes
var config 	 = require('./lib/config.js');
var dialog 	 = require('./lib/dialog.js');
var calendar = require('./lib/calendar.js');

$(document).ready(function(){
	//Create Calendar
	var $l_calendar 	 = calendar(config.calendar, "#calendar");
	var $l_studentLookup = dialog(config.dialogs.studentLookup);
	var $l_scheduler 	 = dialog(config.dialogs.scheduler);
	
	//Open Dialog
	$l_studentLookup.open();
	
});

		
			





