module.exports = (function(){
	
	//Interal Config
	var l_config = {
		tables		: require('../config/tables.js')
	}
	
	//External Config
	var r_config = {
		calendar 	: require('../config/calendar.js'),
		dialogs 	: require('../config/dialogs.js')( {"studentLookup" : l_config.tables.studentLookup} )
	}

	//Expose
	return r_config;
})();