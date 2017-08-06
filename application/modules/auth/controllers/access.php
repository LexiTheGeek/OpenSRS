<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//Access Control
class Access extends MY_Controller {
    
	//Main Page
	public function index(){		
		if( $this->has_access('auth.access.index') ){	
			$this->publisher->publish('auth.access.index');	
			
			//Development Code (Keep ACL File Updated)
			$this->json_manager->split(array('config', 'views', 'acl'), 'C:\xampp\htdocs\c2c\application\modules\common\config\pages\master.json');
		}
	}
	
	/********************************************************************************************************************************/
	public function login() {		
			
		// Method should not be directly accessible
		if( $this->uri->uri_string() == 'auth/access/login')
            show_404();
		
		//Verify Login
		$this->require_min_level(1);
		
		//Setup Login Vars
		$this->setup_login_form(); //CommunityAuth
		
		//Display Login Form
		if(! isset( $on_hold_message ) ){	
			
			//Load Page Config
			$login_page = $this->publisher->page('auth.access.login');
			
			//No Error Message, Remove From Page
			if( is_null($this->load->get_var('login_error_mesg')) ){
				$login_page->remove_view('login_error');
			} 
			
			//No Logout Flag, Remove From Page
			if(! $this->input->get('logout')){
				$login_page->remove_view('logout_success');
			}
			
			//Publish Login Form
			$this->publisher->publish( $login_page ) ;
		//EXCESSIVE LOGIN ATTEMPTS
		}else{
			$this->publisher->publish( 'auth.access.lockout' );
		}

    }
	
	/********************************************************************************************************************************/
    public function logout(){
        //Clear Authen Vars
		$this->authentication->logout();

		//Reset Nav Vars (Clears Cookies)
		$this->navigation->clear();
		
        // Set redirect protocol
        $redirect_protocol = USE_SSL ? 'https' : NULL;

		//Redirect to Login
        redirect( site_url( LOGIN_PAGE . '?logout=1', $redirect_protocol ) );
    }
	
}


