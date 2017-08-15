//Imports
global.jQuery = global.$ = require('jquery')
require('bootstrap');
require('moment');
require('eonasdan-bootstrap-datetimepicker');
var BootstrapDialog = require("bootstrap-dialog");

//Create Bootstrap Dialog
var _bootstrapDialog = function(p_config){
	//Local Variables
	var l_events = ["onShow", "onShown", "onHide", "onHidden"];
	var $r_dialog = new BootstrapDialog(p_config);
	
	//Loop Over Possible Events
	l_events.forEach(function(i_event){
		//If Event Exists
		if(	typeof p_config[i_event] !== 'undefined' ){
			//Create Listener
			$r_dialog[i_event](p_config[i_event]);
		}
	})
	
	return $r_dialog;
}

//Expose
module.exports = function(p_config){
	return _bootstrapDialog(p_config)
}
	