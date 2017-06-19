<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Popup-->
<div id="attendeeModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Student Lookup</h4>
			</div>
			
			
			<div class="modal-body">
				<div style="overflow:hidden; margin-top:10px">
					<form class="form-horizontal">		
						<!--Table-->
						<table id="lookupTable" class="table table-striped table-bordered" style="width:99%" cellspacing="0">
							<thead>
								<tr>
									<th>Select</th>
									<th>ID</th>
									<th>First</th>
									<th>Last</th>
									<th>DOB</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</form>					
				</div>	
				
				<div style="overflow:hidden; margin-top:10px">
					<h4>Selected Students</h4>
					<table id="selectedStudents" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Remove</th>
								<th>ID</th>
								<th>First</th>
								<th>Last</th>
								<th>DOB</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
					
			</div>
			
			<div class="modal-footer">
				<button id="saveAttendees" type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" href="#myModal">Save changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" href="#myModal">Close</button>
			</div>
		</div>
	</div>
</div>
