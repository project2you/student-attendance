<?php

class Students_model extends CI_Model {

    var $year   = '';
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
        $query = $this->db->query('select * from year');
        return $query->result();	
	}

	
	function get_data($per_page, $offset) { 
		$this->db->from('data_table'); 
		$this->db->limit($per_page, $offset); 
		$query = $this->db->get(); 
		$data = $query->result_array(); 

	}

	function list_department_check ( $dep_id ){
        
       $this->db->select('dep_thai');
	   $this->db->from('department');
	   $this->db->where('id', $dep_id );
	   $this->db->order_by('id' , 'DESC');
	   $this->db->limit(1, 0); 

	   $query = $this->db->get();

	   $str = $this->db->last_query();	

       return $query->result();	
	}

	function import_department_check ( $dep_id ){
        
       $this->db->select('id');
	   $this->db->from('department');
	   $this->db->where('dep_id', $dep_id );
	   $this->db->order_by('id' , 'DESC');
	   $this->db->limit(1, 0); 

	   $query = $this->db->get();

	   $str = $this->db->last_query();	

       return $query->result();	
	}

	function import_year_check ( $yea_id ){
        
       $this->db->select('id');
	   $this->db->from('year');
	   $this->db->where('yea_title', $yea_id );
	   $this->db->order_by('id' , 'DESC');
	   $this->db->limit(1, 0); 

	   $query = $this->db->get();

	   $str = $this->db->last_query();	

       return $query->result();	
	}

	function list_year_check ( $yea_id ){
        
       $this->db->select('id');
	   $this->db->from('year');
	   $this->db->where('yea_title', $yea_id );
	   $this->db->order_by('id' , 'DESC');
	   $this->db->limit(1, 0); 

	   $query = $this->db->get();

	   $str = $this->db->last_query();	

       return $query->result();	
	}

    function list_student($limit_start , $limit_end , $search_string , $search_cardid , $group_field  ) {

	   $flag = $this->session->userdata('flag_student');
	
		if (  $flag == 1) {

			$this->session->set_userdata('flag_student',1);

			$this->db->select('s.std_id');
			$this->db->select('s.std_cardid');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');
			$this->db->select('s.std_gender');
			$this->db->select('s.std_birthday');
			$this->db->select('s.dep_id');
			$this->db->select('s.yea_id');

			$this->db->select('y.yea_title');
			$this->db->select('d.dep_eng');
			$this->db->select('d.dep_thai');
			
			$this->db->from(' students_info as s');

			$this->db->join('year AS y','s.yea_id = y.id');
			$this->db->join('department as d','s.dep_id = d.id');
			

			//INNER JOIN students_info ON `year`.id = students_info.yea_id

			if ($search_string <> "" ){
				$this->db->or_like('s.std_cardid', $search_string );
				 //$this->db->or_like('s.std_fname', $search_string );	
			}

			if ($search_cardid > 0  ){
			 $this->db->where('s.yea_id', $search_cardid );
			}

			if ($group_field <> 0 ) { 
				$this->db->where('s.dep_id = ', $group_field );
			} 

			$this->db->group_by('s.std_id'); 
			
			$query = $this->db->get();

			$str = $this->db->last_query();	

			$this->session->set_userdata('last_query', $str );
			return $query->result_array(); 	

		}else{

			$this->session->set_userdata('flag_student',0);
		
			$this->db->select('s.std_id');
			$this->db->select('s.std_cardid');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');
			$this->db->select('s.std_gender');
			$this->db->select('s.std_birthday');
			$this->db->select('s.dep_id');
			$this->db->select('s.yea_id');

			$this->db->select('y.yea_title');
			$this->db->select('d.dep_eng');
			$this->db->select('d.dep_thai');
			
			$this->db->from(' students_info as s');

			$this->db->join('year AS y','s.yea_id = y.id');
			$this->db->join('department as d','s.dep_id = d.id');

			if ($group_field !="" ) { $this->db->where_in('d.id', $group_field );	 }

			$this->db->group_by('s.std_id');

			$Per_Page = $limit_start;   
			$Page = $limit_end;
			$Num_Rows = $this->session->userdata('count_all');

			$Per_Page =  $limit_start * $limit_end ;

			if ( $Per_Page == 0 ) { $Per_Page = null;} 
			
			 $Page = $Page * $limit_start;

			if($limit_start && $limit_end){
			  $this->db->limit( $limit_start , $Page );	
			}
			
			if($Page == null){
			  $this->db->limit(10);
			}
			
			$query = $this->db->get();

			//count($query->result_array());

			$this->session->set_userdata('count_all_list_student',count($query->result_array()) );

			$str = $this->db->last_query();	

			$this->session->set_userdata('last_query_student', $str );

			return $query->result_array(); 	

		}
	}

	function count_all_student( $search_string , $search_cardid  ) {
		
		$this->db->select('s.std_id');
		$this->db->select('s.std_cardid');
		$this->db->select('s.std_fname');
		$this->db->select('s.std_lname');
		$this->db->select('s.std_gender');
		$this->db->select('s.std_birthday');
		$this->db->select('s.dep_id');
		$this->db->select('d.dep_eng');
		$this->db->select('d.dep_thai');

		$this->db->select('ye.yea_title');
		$this->db->select('d.dep_eng');
		$this->db->from(' students_info  as s');
		$this->db->from(' department  as d');
		$this->db->from(' year  as ye');

		$this->db->join('department', 's.dep_id = d.id ');
		$this->db->join('year', 's.yea_id = ye.id');

		if ($search_string != "" ){
			$this->db->or_like('s.std_cardid', $search_string );
			$this->db->or_like('s.std_fname', $search_string );	
		}
		
		$this->db->group_by('s.std_id');

		$query = $this->db->get();

		//echo count($query->result_array());

		//print_r($str = $this->db->last_query());

		$this->session->set_userdata('count_all_student',count($query->result_array()) );
		
		return count($query->result_array());
	}


	function check_id_student( $search_string  ) {
		
		$this->db->select('s.std_cardid');
		$this->db->from(' students_info  as s');
		$this->db->where('s.std_cardid', $search_string );
		$query = $this->db->get();		
		return count($query->result_array());
	}


    function update_student_picture($id, $data){
		$this->db->where('std_cardid', $id);
		$this->db->update('students_info', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}


    function edit_student($id)    {

		     $query = $this->db->query("SELECT  s.std_id,
												s.std_cardid,
												s.std_fname,
												s.std_lname,
												s.std_gender,
												s.std_birthday,
												s.yea_id,
												s.dep_id ,
												d.dep_eng,
												d.dep_thai,
												ye.id,
												ye.yea_title,
												s.std_email,
												s.std_password,
												s.std_picture,
												s.std_status

												FROM students_info  as s , department as d , year as ye
												WHERE s.dep_id = d.id 
												AND s.yea_id = ye.id
												AND	s.std_id =".$id);

					//print_r($str = $this->db->last_query());
					//exit;

	        return $query->result();
    }

	function delete_student($id){
        $query = $this->db->query("DELETE FROM  students_info WHERE std_id='".$id."'");
       // return $query->result();	
	}

    function save_student($data)
    {
		$this->db->insert('students_info', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    function update_student($id, $data){
		$this->db->where('std_cardid', $id);
		$this->db->update('students_info', $data);
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