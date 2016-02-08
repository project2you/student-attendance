<?php

class Logins_model extends CI_Model {

   
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function check_user_login($id){

			$this->db->select('usr_email');			
			$this->db->select('usr_password');		
			$this->db->from('user');
			$this->db->where('usr_email', $id );
			$query = $this->db->get();
			
			$str = $this->db->last_query();	

			return $query->result();	
	}

	function check_privilege($level){

			$this->db->select('*');
			$this->db->from('setting');
			$this->db->where('id', $level );
			$query = $this->db->get();
			
			$str = $this->db->last_query();	

			return $query->result();	
	}
}

?>