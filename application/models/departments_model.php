<?php

class Departments_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
	function get_data($per_page, $offset) { 
		$this->db->from('department'); 
		$this->db->limit($per_page, $offset); 
		$query = $this->db->get(); 
		$data = $query->result_array(); 
	}

	function list_all_department(){
        $query = $this->db->query('select *  from department');
        return $query->result();	
	}

    function list_department($limit_start , $limit_end , $search_string , $group_field  ) {

		$flag_department = $this->session->userdata('flag_department');

		if (  $flag_department == 1) {

			$this->session->set_userdata('flag_department',0);
			$this->db->select('d.id');
			$this->db->select('d.dep_id');
			$this->db->select('d.dep_eng');
			$this->db->select('d.dep_thai');
			$this->db->select('d.usr_id');
			$this->db->select('d.dep_status');
			
			$this->db->from(' department as d');
			
			if ($search_string != "" ){
			 $this->db->or_like('d.dep_id', $search_string );
			}

			$query = $this->db->get();

			$str = $this->db->last_query();	

			$this->session->set_userdata('last_query_department', $str );
			return $query->result_array(); 	

		}else{
		
			$this->session->set_userdata('flag_department',0);
			$this->db->select('d.id');
			$this->db->select('d.dep_id');
			$this->db->select('d.dep_eng');
			$this->db->select('d.dep_thai');
			$this->db->select('d.usr_id');
			$this->db->select('d.dep_status');
			$this->db->from(' department as d');
			
			if ($search_string !="") {
				$this->db->or_like('d.dep_id', $search_string );
			}

			if($limit_start && $limit_end){
			  $this->db->limit($limit_start, $limit_end);	
			}

			if($limit_start != null){
			  $this->db->limit($limit_start, $limit_end);    
			}

			$query = $this->db->get();

			$this->session->set_userdata('count_all_list_department',count($query->result_array()) );

			$str = $this->db->last_query();	
			$this->session->set_userdata('last_query_department', $str );

			return $query->result_array(); 	

		}
	}

	function count_all_department( $search_string  ) {
		
			$this->db->select('d.id');
			$this->db->select('d.dep_id');
			$this->db->select('d.dep_eng');
			$this->db->select('d.dep_thai');
			$this->db->select('d.usr_id');
			$this->db->select('d.dep_status');
			$this->db->from('department as d');

		if ($search_string != "" ){
			$this->db->or_like('d.dep_id', $search_string );
		}

		$this->db->group_by('d.dep_id');

		$query = $this->db->get();

		$this->session->set_userdata('count_all_department',count($query->result_array()) );
		
		return count($query->result_array());
	}

	function check_dep_id( $search_string  ) {	
	
		$this->db->select('d.dep_id');
		$this->db->from(' department as d');
		$this->db->where('d.dep_id', $search_string );
		$query = $this->db->get();	
	
		return count($query->result_array());
	}

    function edit_department($id){

		     $query = $this->db->query("SELECT
											d.id,
											d.dep_id,
											d.dep_eng,
											d.dep_thai,
											d.usr_id,
											d.dep_status
										FROM department as d 
										WHERE d.id =".$id);
	        return $query->result();
    }

	function delete_department($id){
        $query = $this->db->query("DELETE FROM  department WHERE id='".$id."'");
        return $query->result();	
	}

    function save_department($data)
    {
		$this->db->insert('department', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    function update_department($id, $data){
		$this->db->where('id', $id);
		$this->db->update('department', $data);
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