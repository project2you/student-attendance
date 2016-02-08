<?php

class Settings_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
	function list_setting() { 

		$this->db->from('setting'); 
		$query = $this->db->get(); 

		//$str = $this->db->last_query();	

		//ChromePhp::log($query->result_array());

		return $query->result_array(); 
	}

	function term_setting() { 

		$this->db->from('setting_term'); 
		$query = $this->db->get(); 

		//$str = $this->db->last_query();	

		//ChromePhp::log($query->result_array());

		return $query->result_array(); 
	}


    function save_setting($data,$id)
    {

		$this->db->where('id', $id);
		$this->db->update('setting', $data);
		
		$str = $this->db->last_query();

		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}

	}

 function term_setting_update($data,$id)
    {

		$this->db->where('id', $id);
		$this->db->update('setting_term', $data);
		
		$str = $this->db->last_query();

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