//CSS Includes
require('../src/css/calendar.css');
require('../src/css/jquery-ui.css');

//3rd Party JS Includes
global.jQuery = global.$ = require('jquery')
require('moment');
require('moment-timezone');
require('fullcalendar');

module.exports = function(p_config, p_target){
	//Local Variables
	var $r_calendar = $(p_target);
	
	//Init Calendar
	$r_calendar.fullCalendar(p_config);
	
	//Expose Calendar
	return $r_calendar;
}