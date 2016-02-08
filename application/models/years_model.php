<?php

class Years_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
	function get_data($per_page, $offset) { 
		$this->db->from('year'); 
		$this->db->limit($per_page, $offset); 
		$query = $this->db->get(); 
		$data = $query->result_array(); 
	}

	function list_all_year(){
        $query = $this->db->query('select *  from year');
        return $query->result();	
	}

	function check_year($id){
		$this->db->select('y.yea_title');
		$this->db->from(' year as y');
		$this->db->where('y.id', $id );
		$query = $this->db->get();	
		
		$result = $query->result();
		
		 return $result[0]->yea_title;
	}

    function list_year($limit_start , $limit_end , $search_string , $group_field  ) {

		$flag_year = $this->session->userdata('flag_year');

		if (  $flag_year == 1) {

			$this->session->set_userdata('flag_year',0);
			$this->db->select('y.id');
			$this->db->select('y.yea_title');
			$this->db->from(' year as y');
			
			if ($search_string != "" ){
			 $this->db->or_like('y.id', $search_string );
			}

			$query = $this->db->get();

			$str = $this->db->last_query();	

			$this->session->set_userdata('last_query_year', $str );
			return $query->result_array(); 	

		}else{
		
			$this->session->set_userdata('flag_year',0);
			$this->db->select('y.id');
			$this->db->select('y.yea_title');
			$this->db->from(' year as y');
			
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

			$this->session->set_userdata('count_all_list_year',count($query->result_array()) );

			$str = $this->db->last_query();	
			$this->session->set_userdata('last_query_year', $str );

			return $query->result_array(); 	

		}
	}

	function count_all_year( $search_string  ) {
		
			$this->db->select('y.id');
			$this->db->select('y.yea_title');
			$this->db->from('year as y');

			if ($search_string != "" ){
				$this->db->or_like('y.id', $search_string );
			}

			$this->db->group_by('y.id');

			$query = $this->db->get();

			$this->session->set_userdata('count_all_year',count($query->result_array()) );
		
			return count($query->result_array());
	}

	function check_dep_id( $search_string  ) {	
	
		$this->db->select('y.yea_title');
		$this->db->from(' year as y');
		$this->db->where('y.yea_title', $search_string );
		$query = $this->db->get();	
	
		return count($query->result_array());
	}

    function edit_year($id){

		     $query = $this->db->query("SELECT
											y.id,
											y.yea_title
										FROM year as y 
										WHERE y.id =".$id);
	        return $query->result();
    }

	function delete_year($id){
        $query = $this->db->query("DELETE FROM  year WHERE id='".$id."'");
        return $query->result();	
	}

    function save_year($data)
    {
		$this->db->insert('year', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    function update_year($id, $data){
		$this->db->where('id', $id);
		$this->db->update('year', $data);
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