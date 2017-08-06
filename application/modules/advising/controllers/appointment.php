<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends MY_Controller {
	
	//Calendar
	public function calendar(){		
		

		// Get cURL resource
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => str_replace(' ', '%20', 'http://localhost:3000/api/tasks?start=7/25/2017 11:00 PM&end=7/25/2017 11:15 PM')
		));
		/**************************************************************************************/
		
		//Add Cookies
		$cookiesStringToPass = '';
		foreach ($_COOKIE as $name=>$value) {
			if ($cookiesStringToPass) {
				
				if($name == 'sess'){
					$cookiesStringToPass  .= ';';
				}
			}
			
			if($name == 'sess'){
				$cookiesStringToPass .= $name . '=' . addslashes($value);
			}
		}
		
		print_r($cookiesStringToPass);
		exit;
		
		session_write_close();
		
		curl_setopt ($curl, CURLOPT_COOKIE, $cookiesStringToPass );
		
		/*****************************************************************************************/

		$resp = curl_exec($curl);
		
		

		curl_close($curl);

		
		echo $resp;
		
		exit;
		
		
		
		
		
		
		if( $this->has_access('advising.appointment.calendar') ){	
			$this->publisher->publish('advising.appointment.calendar');	
		}
	}
	
}











