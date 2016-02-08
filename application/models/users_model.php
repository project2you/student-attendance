<?php

class Users_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function list_department(){
        $query = $this->db->query('select *  from department');
        return $query->result();	
	}

	function list_major(){
        $query = $this->db->query('select *  from major');
        return $query->result();	
	}

	function list_year(){
        $query = $this->db->query('select *  from year');
        return $query->result();	
	}
	
	function get_data($per_page, $offset) { 
		$this->db->from('data_table'); 
		$this->db->limit($per_page, $offset); 
		$query = $this->db->get(); 
		$data = $query->result_array(); 
	}

    function list_user($limit_start , $limit_end , $search_string , $group_field  ) {

		$flag_user = $this->session->userdata('flag_user');

		if (  $flag_user == 1) {

			$this->session->set_userdata('flag',0);
			$this->db->select('u.usr_id');
			$this->db->select('u.usr_email');
			$this->db->select('u.usr_password');
			$this->db->select('u.usr_fname');
			$this->db->select('u.usr_lname');
			$this->db->select('u.usr_picture');
			$this->db->select('u.usr_date');
			$this->db->select('u.usr_department');
			$this->db->select('u.usr_level');
			$this->db->select('u.usr_status');
			$this->db->select('department.dep_thai');
			$this->db->select('department.dep_eng');
			
			$this->db->from(' user as u');
			
			$this->db->join('department','u.usr_department = department.id', 'left');
			
			if ($search_string != "" ){
			 $this->db->or_like('u.usr_email', $search_string );
			 //$this->db->or_like('s.std_fname', $search_string );	
			}

			if ($group_field <> 0 ) { 
				$this->db->where('u.usr_department = ', $group_field );
			} 

			$this->db->group_by('u.usr_id'); 
			
			$query = $this->db->get();

			$str = $this->db->last_query();	

			$this->session->set_userdata('last_query', $str );
			return $query->result_array(); 	

		}else{
		
			$this->session->set_userdata('flag_user',0);
			$this->db->select('u.usr_id');
			$this->db->select('u.usr_email');
			$this->db->select('u.usr_password');
			$this->db->select('u.usr_fname');
			$this->db->select('u.usr_lname');
			$this->db->select('u.usr_picture');

			$this->db->select('u.usr_date');
			$this->db->select('u.usr_department');
			$this->db->select('u.usr_level');
			$this->db->select('u.usr_status');
			$this->db->select('department.dep_thai');
			$this->db->select('department.dep_eng');
			
			$this->db->from(' user as u');
			
			$this->db->join('department','u.usr_department = department.id', 'left');
			
			if ($search_string !="") {
				$this->db->or_like('u.usr_fname', $search_string );
				$this->db->or_like('u.usr_email', $search_string );	
			}

			if ($group_field !="" ) { $this->db->where_in('u.usr_department', $group_field );	 }
		
			$this->db->group_by('u.usr_id');

			if($limit_start && $limit_end){
			  $this->db->limit($limit_start, $limit_end);	
			}

			if($limit_start != null){
			  $this->db->limit($limit_start, $limit_end);    
			}

			$query = $this->db->get();

			$this->session->set_userdata('count_all_list_user',count($query->result_array()) );

			$str = $this->db->last_query();	
			$this->session->set_userdata('last_query', $str );

			return $query->result_array(); 	

		}
	}

	function count_all_user( $search_string  ) {
		
			$this->db->select('u.usr_id');
			$this->db->select('u.usr_password');
			$this->db->select('u.usr_fname');
			$this->db->select('u.usr_lname');
			$this->db->select('u.usr_picture');
			$this->db->select('u.usr_email');
			$this->db->select('u.usr_date');
			$this->db->select('u.usr_level');
			$this->db->select('u.usr_department');
			$this->db->select('u.usr_status');
			$this->db->select('department.dep_thai');
			$this->db->select('department.dep_eng');
			
			$this->db->from(' user as u');
			
			$this->db->join('department','u.usr_department = department.id', 'left');

			$this->db->or_like('u.usr_id', $search_string );
			$this->db->or_like('u.usr_fname', $search_string );	

		if ($search_string != "" ){
			$this->db->or_like('u.usr_email', $search_string );
		}

		$this->db->group_by('u.usr_id');

		$query = $this->db->get();

		$this->session->set_userdata('count_all_user',count($query->result_array()) );
		
		return count($query->result_array());
	}

	function check_usr_email( $search_string  ) {	
	
		$this->db->select('u.usr_email');
		$this->db->from(' user as u');
		$this->db->where('u.usr_email', $search_string );
		$query = $this->db->get();	
	
		return count($query->result_array());
	}

    function update_user_picture($id, $data){
		$this->db->where('usr_email', $id);
		$this->db->update('user', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}


    function edit_user($id){

			$this->db->select('u.usr_id');
			$this->db->select('u.usr_email');
			$this->db->select('u.usr_password');
			$this->db->select('u.usr_fname');
			$this->db->select('u.usr_lname');
			$this->db->select('u.usr_picture');
			$this->db->select('u.usr_department');
			$this->db->select('u.usr_date');
			$this->db->select('u.usr_level');
			$this->db->select('u.usr_status');

			$this->db->from('user as u');
			$this->db->from('department as d');

			$this->db->where('u.usr_id = ', $id );

			$this->db->join('department','d.id = u.usr_department', 'left');

			$this->db->group_by('u.usr_id');

			$query = $this->db->get();

			return $query->result();
    }

	function delete_user($id){
        $query = $this->db->query("DELETE FROM  user WHERE usr_id='".$id."'");
        return $query->result();	
	}

    function save_user($data)
    {
		$this->db->insert('user', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    function update_user($id, $data){
		$this->db->where('usr_id', $id);
		$this->db->update('user', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
}

?>