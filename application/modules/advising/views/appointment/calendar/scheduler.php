<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Popup-->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Appointment Scheduler</h4>
			</div>
			
			
			<div class="modal-body">
				<form class="form-horizontal">	
					<div class="container">
						
						<!--Start Date-->
						<div class="row">
							<div class="form-group">
								<div class="col-md-2 col-md-offset-1">
									<label for="start" class="control-label">Start:</label>
								</div> 
								<div class="col-md-8">
									<div class='input-group date' id='startDatePicker'>
										<input type='text' class="form-control" name="start" id="eventStart" placeholder="MM/DD/YYYY HH:MM AM"/>
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>		
								</div>
							</div>
						</div>
						
						<!--End Date-->
						<div class="row">
							<div class="form-group">
								<div class="col-md-2 col-md-offset-1">
									<label for="end" class="control-label">End:</label>
								</div> 
								<div class="col-md-8">
									<div class='input-group date' id='startDatePicker'>
										<input type='text' class="form-control" name="end" id="eventEnd" placeholder="MM/DD/YYYY HH:MM AM"/>
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>				
								</div>
							</div>
						</div>
						
						<!--Location-->
						<div class="row">
							<div class="form-group">
								<div class="col-md-2 col-md-offset-1">
									<label for="campus" class="control-label">Location:</label>
								</div> 
								<div class="col-md-8">
									<div class="container">
										<div class="row">
											<div class="col-md-6 ">
												<select id="campus" class="form-control" name="campus" placeholder="List" style="padding-left:0px">
													<option value=""  disabled selected hidden>Select Campus</option>
													<option value="PV">Providence</option>
													<option value="KN">Warwick</option>
												</select>
											</div>
											<div class="col-md-6">
												<input id="room" type='text' class="form-control" name="room" placeholder="Room"/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!--Attendees-->
						<div class="row">
							<div class="form-group">
								<div class="col-md-2 col-md-offset-1">
									<label class="control-label">Attendees:</label>
								</div> 
								<div class="col-md-8">
									<div style="padding-top:8px">
										<ul id="attendees" class="list-unstyled">
																			
										</ul>
									</div>
									<div class="btn-group btn-group-sm" role="group">										
										<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" href="#attendeeModal"><i class="glyphicon glyphicon-plus"></i>
											Add Attendee
										</button>
									</div>
								</div>
							</div>
						</div>
						
					</div>

				</form>
			</div>
			
			<div class="modal-footer">
				<button id="saveEvent" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>