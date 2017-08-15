module.exports = function(p_config){
	//Imports
	global.jQuery = global.$ = require('jquery')
	require('bootstrap');
	require('bootstrap-table');
	
	//Appointment Scheduler Dialog
	var scheduler = {
		"title" 	: "Schedule Appointment",
		"message"	: "Main Content",
		"buttons": [
			{	"id" 		: "saveAppointment",
				"label"		: "Save Appointment",
				"autospin"	: true,
				"action"	: function(p_dialog){
					p_dialog.close()
				}
			},
			{	"label"		: "Close",
				"action"	: function(p_dialog){
					p_dialog.close();
				}
			}
		]
	};
	
	//Student Lookup Dialog
	var studentLookup = {
		"title"  	: "Student Lookup",
		"message"	: document.createElement("table"),
		"size"		: "size-large",
		"buttons": [
			{	"id" 		: "saveAttendees",
				"label"		: "Save Changes",
				"autospin"	: true,
				"action"	: function(p_dialog){
					p_dialog.close()
				}
			},
			{	"label"		: "Close",
				"action"	: function(p_dialog){
					p_dialog.close();
				}
			}
		],
		"onShow" : function($p_dialog){
			
			//Is First Show?
			if(typeof $p_dialog.init === 'undefined'){
				//Init Lookup Table
				$($p_dialog.getMessage()).bootstrapTable(p_config.studentLookup)
				
				//Flag Init
				$p_dialog.init = true;
			}
			
		}
	}
	
	//Return Config
	return {	
		"scheduler" 	: scheduler,
		"studentLookup" : studentLookup
	}

}

