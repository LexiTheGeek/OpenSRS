module.exports = {
  	theme: true,
	header		: {
		left	: 'prev,next today',
		center	: 'title',
		right	: 'month,agendaWeek,agendaDay'
	},
	navLinks	: true, 
	editable	: true,
	selectable	: true,
	selectHelper: true,
	defaultView	: 'agendaWeek',
	allDaySlot	: false,
	slotDuration: '00:30:00',
	businessHours: {
		dow: [ 1, 2, 3, 4, 5 ],
		start: '6:00', 
		end: '18:00'
	}
}

