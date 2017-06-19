$(document).ready(function() {
	
	//Detect Change to Student Lookup
	$(document).on('change', '#lookupTable input[name="attendeeSelect"]', function(){
		//Local Variables
		$this = $(this);
		
		//Checked
		if($this.is(':checked')){
			$($this.parents('tr')).trigger('student:select');
			
		//Unchecked	
		}else{
			$($this.parents('tr')).trigger('student:deselect');
		}
	});
	
	//Select (Student Lookup)
	$(document).on('student:select', '#lookupTable tr', function(){
		//Local Variables
		$this = $(this);
		$tr = $("<tr>");
		
		//Build Row
		$tr.append('<td style="text-align: center;"><i class="glyphicon glyphicon-remove" style="cursor:pointer"></i></td>');
		$tr.append($this.find("td").eq(1).clone());
		$tr.append($this.find("td").eq(2).clone());
		$tr.append($this.find("td").eq(3).clone());
		$tr.append($this.find("td").eq(4).clone());	
		
		//Add to DOM
		$("#selectedStudents").append($tr);
	});
	
	//Deselect (Student Lookup)
	$(document).on('student:deselect', '#lookupTable tr', function(){
		//Local Variables
		$this = $(this);
		id = $this.find("td").eq(1).text();
		
		//Add to DOM
		$("#selectedStudents").find("tr").each(function(){
			//Local Variables
			$this = $(this);
		
			//Matched Record
			if(id == $this.find("td").eq(1).text()){
				$this.remove()
			}
		});
	});
	
	//Remove Selected Student
	$(document).on('click', '#selectedStudents i.glyphicon-remove', function(){
		//Local Variables
		$this = $(this);
		id = $this.parents('tr').find('td').eq(1).text();
		
		deselectStudent(id);
	});
	
	function deselectStudent(p_id){
		id = p_id;
		
		$("#lookupTable").find("tr").each(function(){
			//Local Variables
			$this = $(this);

			//Matched Record
			if(id == $this.find("td").eq(1).text()){
				$this.eq(0).find('input').prop('checked', false)
				
				$this.trigger("student:deselect")
			}
		});
	}
	
	$(document).on('click', '#attendees li i.glyphicon-remove', function(){
		$attendee = $(this).parent();
		id = $attendee.data("id");
		
		deselectStudent(id);
		$attendee.remove()
	})
	
	//Create Lookup Table
	$('#lookupTable').DataTable({
		data 	: [
			[	"<input type='checkbox' value='94131853' name='attendeeSelect'>",
				"94131853",
				"Alexia",
				"Hurley",
				"08/02/1992"
			],
			[	"<input type='checkbox' value='12345678' name='attendeeSelect'>",
				"23456789",
				"Hope",
				"Schachter",
				"??/??/???"
			],
			[	"<input type='checkbox' value='23456789' name='attendeeSelect'>",
				"34567890",
				"Michele",
				"Bourgeois",
				"??/??/???"
			],
			[	"<input type='checkbox' value='34567890' name='attendeeSelect'>",
				"87654321",
				"Corey",
				"Fernadez",
				"??/??/???"
			],
			[	"<input type='checkbox' value='87654321' name='attendeeSelect'>",
				"98765432",
				"Rekha",
				"Rosha",
				"??/??/???"
			]
		]
	});

	//Date Pickers
	$('#startDatePicker').datetimepicker();
	$('#endDatePicker').datetimepicker();
	
	//Calendar
    $('#calendar').fullCalendar({
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
		},
		events: [
			{	title  : 'event2',
				start  : '2017-05-28T12:00:00',
				end    : '2017-05-28T13:00:00'	}
		],
		select : function( p_start, p_end, jsEvent, view){
			$("#eventStart").val( p_start.format('MM/DD/YYYY h:mm A') );
			$("#eventEnd").val( p_end.format('MM/DD/YYYY h:mm A') );
			$('#myModal').modal('show');	
		}
    })
	
	//Save Event
	$("#saveEvent").click(function(){
		
		event = {
			start 		: $("#eventStart").val(),
			end 		: $("#eventEnd").val(),
			campus		: $("#campus").val(),
			room		: $("#room").val(),
			attendees	: [] 
		};		

		$("#attendees").find('li').each(function(){
			event.attendees.push(
				$(this).find("span").text()
			)
		})
		
		$('#calendar').fullCalendar('renderEvent', {
			title	: event.attendees.join(", ") + " @ " + event.campus + " (Room: " + event.room + ")",
			start 	: event.start,
			end 	: event.end
		})
		
	});
	
	//Save Attendees
	$("#saveAttendees").click(function(){
		data = [];
		
		$("#selectedStudents tbody tr").each(function(){
			//Local Variables
			$tds = $(this).find('td');
			
			data[data.length] = {
				id : $tds.eq(1).text(),
				name: $tds.eq(2).text() + ' ' + $tds.eq(3).text()
			};
		});
		
		$ul = $("#attendees");
		$ul.empty();
		
		for(var i = 0; i < data.length; i++){
		
			$li = $('<li></li>').append('<i class="glyphicon glyphicon-remove"></i> ').append('<span>' + data[i].name + '</span>');
			$li.data("id", data[i].id);
			
		
			$ul.append($li)
			
		}
		
		$ul.show();
	})

});