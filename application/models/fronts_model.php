<?php

class Fronts_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function last_year(){
       $this->db->select('id');
	   $this->db->from('year');
	   $this->db->order_by('id' , 'DESC');
	   $this->db->limit(1, 0); 

	   $query = $this->db->get();

        return $query->result();	
	}

	function check_student_login($std_cardid,$password){

			$this->db->select('std_cardid');				
			$this->db->select('std_fname');		
			$this->db->select('std_lname');		
			$this->db->select('dep_id');		
			$this->db->select('std_email');		

			$this->db->from('students_info');
			
			$this->db->where('std_cardid', $std_cardid );
			$this->db->where('std_password', $password );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function check_verify($std_id , $ter_id ,$yea_id ){

			$this->db->select('verify_checked.ver_id');				
			$this->db->select('verify_checked.std_id');		

			$this->db->select('major.id as mid');		
			$this->db->select('major.maj_id');		
			$this->db->select('major.maj_thai');		
			$this->db->select('major.maj_unit');	
			
			$this->db->select('verify.id');	
			$this->db->select('verify.min_late');	
			$this->db->select('verify.min_leave');	
			$this->db->select('verify.min_missing');	
			$this->db->select('verify.msg_alert');	

			$this->db->from('verify_checked');
			
			$this->db->join('verify','verify_checked.ver_id = verify.id', 'INNER');
			$this->db->join('major','verify.maj_detail = major.maj_id', 'INNER');
			
			$this->db->where('std_id ', $std_id);

			$this->db->where('verify.ter_id ', $ter_id);

			$this->db->where('verify.yea_id ', $yea_id);

			$this->db->group_by('verify_checked.ver_id'); 

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function sum_check_normal($std_id){

			$this->db->select('count(v.ver_sta_id) as normal');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.yea_title = ', $this->session->userdata('last_year') );
			$this->db->where('v.ter_id = ', $this->session->userdata('ter_id') );

			$this->db->where('v.ver_sta_id = ', 1 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function sum_check_late($std_id){

			$this->db->select('count(v.ver_sta_id) as late');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.yea_title = ', $this->session->userdata('last_year') );
			$this->db->where('v.ter_id = ', $this->session->userdata('ter_id') );

			$this->db->where('v.ver_sta_id = ', 2 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}


	function sum_check_leaves($std_id){

			$this->db->select('count(v.ver_sta_id) as leaves');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.yea_title = ', $this->session->userdata('last_year') );
			$this->db->where('v.ter_id = ', $this->session->userdata('ter_id') );

			$this->db->where('v.ver_sta_id = ', 3 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}


	function sum_check_missing($std_id){

			$this->db->select('count(v.ver_sta_id) as missing');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.yea_title = ', $this->session->userdata('last_year') );
			$this->db->where('v.ter_id = ', $this->session->userdata('ter_id') );

			$this->db->where('v.ver_sta_id = ', 4 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}
	
	function check_normal($std_id, $ver_id){
	
			$this->db->select('count(v.ver_sta_id) as normal');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.ver_id = ', $ver_id );
			$this->db->where('v.ver_sta_id = ', 1 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function check_late($std_id, $ver_id){
	
			$this->db->select('count(v.ver_sta_id) as late');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.ver_id = ', $ver_id );
			$this->db->where('v.ver_sta_id = ', 2 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function check_leaves($std_id, $ver_id){
	
			$this->db->select('count(v.ver_sta_id) as leaves');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.ver_id = ', $ver_id );
			$this->db->where('v.ver_sta_id = ', 3 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}


	function check_missing($std_id, $ver_id){
	
			$this->db->select('count(v.ver_sta_id) as missing');				

			$this->db->from('verify_checked as v ');
			
			$this->db->where('v.std_id = ', $std_id );
			$this->db->where('v.ver_id = ', $ver_id );
			$this->db->where('v.ver_sta_id = ', 4 );

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function top_list($std_id){

			$this->db->select('verify.id');				
				
			$this->db->select('major.maj_id');	
			$this->db->select('major.maj_thai');	
			
			$this->db->select('verify_checked.std_id');	
			$this->db->select('verify_checked.log_time');	
			$this->db->select('year.yea_title');	
			
			$this->db->from('major');
			
			$this->db->where('std_id = ', $std_id );
			
			$this->db->where('verify_checked.yea_title = ', $this->session->userdata('last_year') );
			$this->db->where('verify_checked.ter_id = ', $this->session->userdata('ter_id') );
			
			$this->db->join('verify','verify.maj_detail = major.maj_id', 'INNER');
			$this->db->join('verify_checked','verify.id = verify_checked.ver_id', 'INNER');
			$this->db->join('year','verify_checked.yea_title = year.id', 'INNER');

		   //$this->db->order_by('std_id' , 'DESC');
		   $this->db->limit(5); 

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function check_privilege($level){

			$this->db->select('*');
			$this->db->from('setting');
			$this->db->where('id', $level );
			$query = $this->db->get();
			
			//ChromePhp::log($str);

			$str = $this->db->last_query();	

			return $query->result();	
	}

	function list_student($id){

			$this->db->select('s.std_id');
			$this->db->select('s.std_cardid');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');
			$this->db->select('s.std_gender');
			$this->db->select('s.std_email');
			$this->db->select('s.std_birthday');
			$this->db->select('s.std_picture');


			$this->db->select('s.std_address');
			$this->db->select('s.std_tel');

			$this->db->select('s.dep_id');
			$this->db->select('s.yea_id');
			$this->db->select('department.dep_thai');
			$this->db->select('department.dep_eng');
			$this->db->select('year.yea_title');
			
			$this->db->from(' students_info as s');
			$this->db->from('year as yea');

			$this->db->where('std_cardid', $id );

			$this->db->join('department','s.dep_id = department.id', 'left');
			$this->db->join('year','s.yea_id = yea.id', 'left');

			//ChromePhp::log($str);

			$query = $this->db->get();

			$str = $this->db->last_query();	

			return $query->result();	

	}

	public function student_check_password( $uid , $old_pass ){

			$this->db->select('count(s.std_password) as check_password ');
			
			$this->db->from(' students_info as s');

			$this->db->where('s.std_cardid', $uid );
			$this->db->where('s.std_password', $old_pass );
			
			$query = $this->db->get();

			$str = $this->db->last_query();	

			//ChromePhp::log($str);

			return $query->result();	

	}

	public function student_update_password( $uid  , $new_pass , $data){

		$this->db->where('s.std_cardid', $uid );
			
		$this->db->update('students_info as s ', $data);
		
		$str = $this->db->last_query();	

		//ChromePhp::log($str);

		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

	function update_profiles($id, $data){
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


	function static_summary($std_id, $ter_id , $yea_id ){

			$this->db->select('verify_checked.ver_id');				
			$this->db->select('verify_checked.std_id');		
			$this->db->select('major.maj_id');		
			$this->db->select('major.maj_thai');		
			$this->db->select('major.maj_unit');	
			
			$this->db->select('verify.min_late');	
			$this->db->select('verify.min_leave');	
			$this->db->select('verify.min_missing');	
			$this->db->select('verify.msg_alert');	
			$this->db->select('verify.dep_id');	
			$this->db->select('verify.ter_id');	
			$this->db->select('verify.yea_id');	
			$this->db->select('verify.std_reg_id');	

			$this->db->from('verify_checked');
			
			$this->db->join('verify','verify_checked.ver_id = verify.id', 'INNER');
			$this->db->join('major','verify.maj_detail = major.maj_id', 'INNER');
			
			$this->db->where('std_id ', $std_id);

			$this->db->where('verify.ter_id ', $ter_id);

			$this->db->where('verify.yea_id ', $yea_id);


			$this->db->group_by('verify_checked.ver_id'); 

			$query = $this->db->get();
			
			$str = $this->db->last_query();	
		
			//ChromePhp::log($str);

			return $query->result();	
	}

	function static_count_normal($std_id , $dep_id, $ter_id , $yea_id ){

		$this->db->select('count(v.ver_sta_id) as nor');
		$this->db->from('verify_checked as v ');
		
		$this->db->where('v.ver_sta_id', 1 );	
		$this->db->where('v.dep_id', $dep_id );	
		$this->db->where('v.ter_id', $ter_id );	
		$this->db->where('v.yea_title', $yea_id );	
		$this->db->where('v.usr_id',  $std_id  );	

		$query = $this->db->get();

		$str = $this->db->last_query();
		
		//ChromePhp::log($str);

		return $query->result();
	}

	function history($ver_id ,$maj_id ){

		$this->db->select('verify_checked.id');
		$this->db->select('verify_checked.ver_sta_id');
		$this->db->select('verify_status.std_title,');
		$this->db->select('major.maj_id');
		$this->db->select('verify_checked.ter_id');
		$this->db->select('year.id as yid');
		$this->db->select('year.yea_title');
		$this->db->select('verify_checked.log_time,');
		$this->db->select('major.maj_thai');
		$this->db->select('verify_checked.ver_id');
		//$this->db->select('department.dep_id');
		//$this->db->select('department.dep_thai');

		$this->db->from('verify_status');
		
		$this->db->join('verify_checked','verify_checked.ver_sta_id = verify_status.sta_id', 'INNER');
		$this->db->join('major','verify_checked.maj_id = major.id', 'INNER');
		$this->db->join('year','verify_checked.yea_title = year.id', 'INNER');
		//$this->db->join('department','verify_checked.dep_id = department.id', 'INNER');		

		$this->db->where('verify_checked.ver_id', $ver_id );	
		$this->db->where('verify_checked.maj_id', $maj_id );	
		//$this->db->where('verify_checked.dep_id', $dep_id );	
		$this->db->where('verify_checked.ter_id',  $this->session->userdata('ter_id') );	
		$this->db->where('verify_checked.yea_title',  $this->session->userdata('last_year')  );	
		$this->db->where('verify_checked.std_id',  $this->session->userdata('std_cardid')  );	

		$query = $this->db->get();

		$str = $this->db->last_query();
		
		//ChromePhp::log($str);

		return $query->result();
	}


}

?>