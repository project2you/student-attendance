<?php

class Statics_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
   	function list_all_major(){
        $query = $this->db->query('select * from major');
        return $query->result();	
	}

	function list_all_department(){
        $query = $this->db->query('select * from department');
        return $query->result();	
	}

	function list_all_year(){
        $query = $this->db->query('select * from year');
        return $query->result();	
	}

	function last_year(){
       $this->db->select('id');
	   $this->db->from('year');
	   $this->db->order_by('id' , 'DESC');
	   $this->db->limit(1, 0); 

	   $query = $this->db->get();

        return $query->result();	
	}

	function static_summary($ter_id , $yea_id ){

				$this->db->select('verify.id');
				$this->db->select('verify.ter_id');
				$this->db->select('verify.yea_id');
				$this->db->select('verify.std_reg_id');
				$this->db->select('verify.dep_id');
				
				$this->db->select('major.id as maj_join_id ');
				$this->db->select('major.maj_id');
				$this->db->select('major.maj_thai');
				$this->db->select('verify.usr_id');
			
				$this->db->from('verify');

				$this->db->join('major','verify.maj_detail =major.maj_id');
				$this->db->join('year','verify.yea_id = year.id');
				$this->db->join('verify_checked','verify_checked.usr_id = verify.usr_id');
	
				$this->db->where('verify.ter_id', $ter_id  );	 
				$this->db->where('verify_checked.yea_title', $yea_id  );	 

				$this->db->where('verify.usr_id',  $this->session->userdata('usr_id')  );	

				$this->db->group_by('verify.id');

				$query = $this->db->get();
				
				$str = $this->db->last_query();
				
				return $query->result();
	}


	function static_count_normal($dep_id, $ter_id , $yea_id ){

		$this->db->select('count(v.ver_sta_id) as nor');
		$this->db->from('verify_checked as v ');
		
		$this->db->where('v.ver_sta_id', 1 );	
		$this->db->where('v.ver_id', $dep_id );	
		$this->db->where('v.ter_id', $ter_id );	
		$this->db->where('v.yea_title', $yea_id );	
		$this->db->where('v.usr_id',  $this->session->userdata('usr_id')  );	

		$query = $this->db->get();

		$str = $this->db->last_query();

		return $query->result();
	}

	function static_count_late($dep_id, $ter_id , $yea_id ){

		$this->db->select('count(v.ver_sta_id) as lat');
		$this->db->from('verify_checked as v ');
		
		$this->db->where('v.ver_sta_id', 2 );	
		$this->db->where('v.ver_id', $dep_id );	
		$this->db->where('v.ter_id', $ter_id );	
		$this->db->where('v.yea_title', $yea_id );	
		$this->db->where('v.usr_id', $this->session->userdata('usr_id')  );	

		$query = $this->db->get();

		$str = $this->db->last_query();
		
		return $query->result();
	}

	function static_count_leave($dep_id, $ter_id , $yea_id ){

		$this->db->select('count(v.ver_sta_id) as lea');
		$this->db->from('verify_checked as v ');
		
		$this->db->where('v.ver_sta_id', 3 );	
		$this->db->where('v.ver_id', $dep_id );	
		$this->db->where('v.ter_id', $ter_id );	
		$this->db->where('v.yea_title', $yea_id );	
		$this->db->where('v.usr_id', $this->session->userdata('usr_id')  );	

		$query = $this->db->get();

		 $str = $this->db->last_query();
		
		return $query->result();
	}


	function static_count_missing($dep_id, $ter_id , $yea_id ){

		$this->db->select('count(v.ver_sta_id) as mis');
		$this->db->from('verify_checked as v ');
		
		$this->db->where('v.ver_sta_id', 4 );	
		$this->db->where('v.ver_id', $dep_id );	
		$this->db->where('v.ter_id', $ter_id );	
		$this->db->where('v.yea_title', $yea_id );	
		$this->db->where('v.usr_id', $this->session->userdata('usr_id') );	

		$query = $this->db->get();

		 $str = $this->db->last_query();
		
		return $query->result();
	}

}

?>