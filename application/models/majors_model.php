<?php

class Majors_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
	function get_data($per_page, $offset) { 
		$this->db->from('major'); 
		$this->db->limit($per_page, $offset); 
		$query = $this->db->get(); 
		$data = $query->result_array(); 
	}

	function list_all_major(){
        $query = $this->db->query('select * from major');
        return $query->result();	
	}

	function list_all_year(){
        $query = $this->db->query('select * from year');
        return $query->result();	
	}

	function list_all_department(){
        $query = $this->db->query('select * from department');
        return $query->result();	
	}

    function list_major($limit_start , $limit_end , $search_string  , $search_term  , $group_field  ) {

		$flag_major = $this->session->userdata('flag_major');

		if (  $flag_major == 1) {

			$this->session->set_userdata('flag_major',0);
			$this->db->select('m.id');
			$this->db->select('m.maj_id');
			$this->db->select('m.maj_thai');
			$this->db->select('m.maj_eng');
			$this->db->select('m.maj_unit');
			$this->db->select('m.maj_year');
			$this->db->select('m.maj_term');
			$this->db->select('m.dep_id');
			$this->db->select('y.yea_title');
			$this->db->select('d.dep_thai');

			$this->db->from(' major as m');

			$this->db->join('year as y ','y.id = m.maj_year');
			$this->db->join('department as d ','d.id = m.dep_id');


			if ($search_string != "" ){
			 $this->db->or_like('m.maj_id', $search_string );
			}

			if ($search_term <> "" ){
			 $this->db->or_like('m.maj_term', $search_term );
			}

			if ($group_field <> 0 ) { 
				$this->db->where('m.maj_year = ', $group_field );
			} 

			$this->db->group_by('m.id');

			$query = $this->db->get();

			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			$this->session->set_userdata('last_query_major', $str );
			return $query->result_array(); 	

		}else{
		
			$this->session->set_userdata('flag_major',0);
			$this->db->select('m.id');
			$this->db->select('m.maj_id');
			$this->db->select('m.maj_thai');
			$this->db->select('m.maj_eng');
			$this->db->select('m.maj_unit');
			$this->db->select('m.maj_year');
			$this->db->select('m.maj_term');
			$this->db->select('m.dep_id');
			$this->db->select('y.yea_title');
			$this->db->select('d.dep_thai');
			$this->db->from(' major as m');
			
			$this->db->join('year as y ','y.id = m.maj_year', 'left');
			$this->db->join('department as d ','d.id = m.dep_id');

			if ($search_string !="") {
				$this->db->or_like('m.maj_id', $search_string );
			}

			if ($search_term <> "" ){
			 $this->db->or_like('m.maj_term', $search_term );
			}

			if ($group_field <> 0 ) { 
				$this->db->where('m.maj_year = ', $group_field );
			} 


			if($limit_start && $limit_end){
			  $this->db->limit($limit_start, $limit_end);	
			}

			if($limit_start != null){
			  $this->db->limit($limit_start, $limit_end);    
			}

			$this->db->group_by('m.id');

			$query = $this->db->get();

			$this->session->set_userdata('count_all_list_major',count($query->result_array()) );

			$str = $this->db->last_query();	

			$this->session->set_userdata('last_query_major', $str );

			return $query->result_array(); 	

		}
	}

	function count_all_major( $search_string  ) {
		
			$this->db->select('m.id');
			$this->db->select('m.maj_id');
			$this->db->select('m.maj_thai');
			$this->db->select('m.maj_eng');
			$this->db->select('m.maj_unit');
			$this->db->select('m.maj_year');
			$this->db->select('m.maj_term');
			$this->db->select('m.dep_id');
			$this->db->from(' major as m');

		if ($search_string != "" ){
			$this->db->or_like('m.maj_id', $search_string );
		}

		$this->db->group_by('m.maj_id');

		$query = $this->db->get();

		$this->session->set_userdata('count_all_major',count($query->result_array()) );
		
		return count($query->result_array());
	}

	function check_maj_id( $search_string  ) {	
	
		$this->db->select('m.maj_id');
		$this->db->from(' major as m');
		$this->db->where('m.maj_id', $search_string );
		$query = $this->db->get();	
	
		return count($query->result_array());
	}

    function edit_major($id){

		     $query = $this->db->query("SELECT
										m.id , 
										m.maj_id , 
										m.maj_thai , 
										m.maj_eng ,
										m.maj_des ,
										m.maj_unit ,
										m.maj_year ,
										m.maj_term ,
										m.dep_id
										FROM major as m 
										WHERE m.id =".$id);
	        return $query->result();
    }

	function delete_major($id){
        $query = $this->db->query("DELETE FROM  major WHERE id='".$id."'");
        //return $query->result();	
	}

    function save_major($data)
    {
		$this->db->insert('major', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    function update_major($id, $data){
		$this->db->where('id', $id);
		$this->db->update('major', $data);
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