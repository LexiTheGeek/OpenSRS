<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends MY_Controller {
	
	//Calendar
	public function calendar(){		
		if( $this->has_access('advising.appointment.calendar') ){	
			$this->publisher->publish('advising.appointment.calendar');	
		}
	}
	
}











