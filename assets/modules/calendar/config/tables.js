module.exports = {
	"studentLookup" : {
		"search" 			: true,
		"searchAlign" 		: 'right',
		"maintainSelected" 	: true,
		"striped"			: true,
		"columns" : [
			{	"title" 	: "Banner ID",
				"field"		: "userID",
				"sortable" 	: true
			},
			{	"title" 	: "First Name",
				"field"		: "fname",
				"sortable" 	: true
			},
			{	"title" 	: "Last Name",
				"field"		: "lname",
				"sortable" 	: true
			}
		],
		"data" : [
			{"userID" : 94131853, "fname" : "Alexia", "lname" : "Hurley"},
			{"userID" : 94131854, "fname" : "Ashlee", "lname" : "O'Connor"}
		]
	}
}