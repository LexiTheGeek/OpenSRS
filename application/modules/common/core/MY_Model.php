<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'modules/common/models/community_auth_Model.php';

class MY_Model extends Community_Auth_Model
{
	/**
	 * ACL for a logged in user
	 * @var mixed
	 */
	public $acl = NULL;

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// -----------------------------------------------------------------------

	/**
	 * Get all of the ACL records for a specific user
	 */
	public function acl_query( $user_id, $called_during_auth = FALSE )
	{
		// ACL table query
		// Custom query
		$query = $this->db->distinct()->select('d.action_id, d.action_code, e.category_code')
			->from( config_item('acl_table') . ' a' )
			->join( config_item('acl_roles_table') . ' b', 'b.role_id = a.role_id' )
			->join( config_item('acl_permissions_table') . ' c', 'c.role_id = b.role_id' )
			->join( config_item('acl_actions_table') . ' d', 'd.action_id = c.action_id' )
			->join( config_item('acl_categories_table') . ' e', 'e.category_id = d.category_id' )		
			->where( 'a.user_id', $user_id )
			->get();
			
		/**
		 * ACL becomes an array, even if there were no results.
		 * It is this change that indicates that the query was 
		 * actually performed.
		 */
		$acl = [];

		if( $query->num_rows() > 0 )
		{
			// Add each permission to the ACL array
			foreach( $query->result() as $row )
			{
				// Permission identified by category + "." + action code
				$acl[$row->action_id] = $row->category_code . '.' . $row->action_code;
			}
		}

		if( $called_during_auth OR $user_id == config_item('auth_user_id') )
			$this->acl = $acl;

		return $acl;
	}
	
}
/* End of file MY_Model.php */
/* Location: /auth/core/MY_Model.php */