<?php

class Verifys_model extends CI_Model {

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

	function list_major_by_order ($ter_id , $yea_id ){
        $query = $this->db->query('select *  from major where maj_term ='.$ter_id.' AND maj_year ='.$yea_id);

		$str = $this->db->last_query();	

        return $query->result();	
	}

	function list_major_json ($ter_id , $yea_id ){
        $query = $this->db->query('select *  from major where maj_term ='.$ter_id.' AND maj_year ='.$yea_id);

		$str = $this->db->last_query();	

        return $query->result();	
	}

	function list_year(){
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

	function get_data($per_page, $offset) { 
		$this->db->from('data_table'); 
		$this->db->limit($per_page, $offset); 
		$query = $this->db->get(); 
		$data = $query->result_array(); 

	}

    function check_verify($limit_start , $limit_end , $search_string , $group_field  , $dep_id , $yea_id ) {
		$flag = $this->session->userdata('flag_check_verify');

		if (  $flag == 1) {

			$this->session->set_userdata('flag_check_verify',0);
			$this->db->select('s.std_id');
			$this->db->select('s.std_cardid');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');
			$this->db->select('s.std_gender');
			$this->db->select('s.std_birthday');
			$this->db->select('d.id');
			$this->db->select('d.dep_id');
			$this->db->select('s.yea_id');
			$this->db->select('d.dep_thai');
			$this->db->select('d.dep_eng');
			$this->db->select('y.yea_title');
			
			$this->db->from(' students_info as s');

			$this->db->join('department as d','s.dep_id = d.id', 'INNER');
			$this->db->join('year as y','s.yea_id = y.id', 'INNER');
			
			if ($search_string <> "" ){
			 $this->db->or_like('s.std_cardid', $search_string );
			}

			if ($dep_id <> 0 ) { 
				$this->db->where('s.dep_id = ', $dep_id );
			} 

			if ($yea_id <> 0 ) { 
				$this->db->where('s.yea_id = ', $yea_id );
			} 
			
			$this->db->order_by("s.std_id"); 
			$this->db->group_by('s.std_id'); 
			
			$query = $this->db->get();

			$str = $this->db->last_query();	

			$this->session->set_userdata('last_query', $str );
			return $query->result_array(); 	

		}else{
		
			$this->db->select('s.std_id');
			$this->db->select('s.std_cardid');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');
			$this->db->select('s.std_gender');
			$this->db->select('s.std_birthday');
			$this->db->select('s.dep_id');
			$this->db->select('s.yea_id');
			$this->db->select('d.dep_eng');
			$this->db->select('d.dep_thai');
			$this->db->select('y.yea_title');
			$this->db->select('d.dep_eng');
			$this->db->from('students_info  as s');

			$this->db->join('department as d', 's.dep_id = d.id ');
			$this->db->join('year as y ', 's.yea_id = y.id');

			$this->db->where('s.dep_id = ', $dep_id );
			$this->db->where('s.yea_id = ', $yea_id );
			 
			
			if ($group_field !="" ) { $this->db->where_in('d.id', $group_field );	 }
			
			$this->db->order_by("s.std_id"); 
			$this->db->group_by('s.std_cardid');

			if($limit_start && $limit_end){
			  //$this->db->limit($limit_start, $limit_end);	
			}

			if($limit_start != null){
			  //$this->db->limit($limit_start, $limit_end);    
			}

			$query = $this->db->get();

			//echo count($query->result_array());
			
			$str = $this->db->last_query();	

			//ChromePhp::log($str);
			
			//$myfile = fopen("sql.txt", "w") or die("Unable to open file!");
			//fwrite($myfile, $str);
			//fclose($myfile);

			$this->session->set_userdata('count_all_check_verify',count($query->result_array()) );
			
			$this->session->set_userdata('last_query_student', $str );

			return $query->result_array(); 	

		}
	}

    function analysis_verify($maj_id , $dep_id , $ter_id , $std_reg_id  ) {

			$this->db->select('v.id');
			$this->db->select('v.maj_id');
			$this->db->select('v.maj_detail');
			$this->db->select('v.dep_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.yea_id');
			$this->db->select('v.std_reg_id');
			$this->db->select('v.usr_id');
			$this->db->select('v.total_study');
			$this->db->select('v.min_late');
			$this->db->select('v.min_leave');
			$this->db->select('v.min_missing');
			$this->db->select('v.msg_alert');
			$this->db->select('v.ver_date');
			
			$this->db->from('verify as v');

			$this->db->where('v.maj_id = ', $maj_id );
			$this->db->where('v.dep_id = ', $dep_id );
			$this->db->where('v.ter_id = ', $ter_id );
			$this->db->where('v.std_reg_id = ', $std_reg_id );

			$query = $this->db->get();

			$str = $this->db->last_query();	
			
			return $query->result_array(); 	
	}

    function list_verify($limit_start , $limit_end , $search_string , $group_field ,$search_year ) {

		$flag = $this->session->userdata('flag_verify');
		
		if (  $flag == 1) {

			$this->session->set_userdata('flag_verify',0);

				$this->db->select('verify.id as ver_id');
				$this->db->select('verify.maj_id as maj_id');
				$this->db->select('verify.maj_detail');
				$this->db->select('verify.dep_id');
				$this->db->select('verify.ter_id');
				$this->db->select('verify.yea_id');
				$this->db->select('verify.std_reg_id');
				$this->db->select('major.maj_thai');
				$this->db->select('department.id');
				$this->db->select('department.dep_thai');
				$this->db->select('year.yea_title');
				$this->db->select('major.maj_id as m_maj_id');
				$this->db->select('verify.usr_id');
				$this->db->select('verify.total_study');
				$this->db->select('verify.min_late');
				$this->db->select('verify.min_leave');
				$this->db->select('verify.min_missing');

				$this->db->from('department');

				$this->db->join('verify','verify.dep_id = department.id');
				$this->db->join('major','verify.maj_detail =major.maj_id');
				$this->db->join('year','verify.yea_id = year.id');

					
				if ($search_string != "" ){
					$this->db->or_like('major.maj_id ', $search_string );
				}
				
				if ($group_field >= 1  ) { 
					$this->db->where_in('verify.dep_id', $group_field );	 
				}

				if ($search_year >= 1  ) { 
					$this->db->where_in('verify.yea_id', $search_year );	 
				}


				$this->db->where('verify.usr_id',  $this->session->userdata('usr_id')  );	

				$this->db->order_by("verify.id", "desc"); 

				$query = $this->db->get();

				$str = $this->db->last_query();	
				

				$this->session->set_userdata('last_query', $str );
				return $query->result_array(); 	
				echo 2;


		}else{

				$this->db->select('verify.id as ver_id');
				$this->db->select('verify.maj_id');
				$this->db->select('verify.maj_detail');
				$this->db->select('verify.dep_id');
				$this->db->select('verify.ter_id');
				$this->db->select('verify.yea_id');
				$this->db->select('verify.std_reg_id');
				$this->db->select('major.maj_thai');
				$this->db->select('department.id');
				$this->db->select('department.dep_thai');
				$this->db->select('year.yea_title');
				$this->db->select('major.maj_id as m_maj_id');
				$this->db->select('verify.usr_id');
				$this->db->select('verify.total_study');
				$this->db->select('verify.min_late');
				$this->db->select('verify.min_leave');
				$this->db->select('verify.min_missing');

				$this->db->from('department');

				$this->db->join('verify','verify.dep_id = department.id');
				$this->db->join('major','verify.maj_detail =major.maj_id');
				$this->db->join('year','verify.yea_id = year.id');

					
				if ($search_string != "" ){
					$this->db->or_like('major.maj_id ', $search_string );
				}
				
				if ($group_field >= 1  ) { 
					$this->db->where_in('verify.dep_id', $group_field );	 
				}


				$this->db->where('verify.usr_id',  $this->session->userdata('usr_id')  );	


				$this->db->order_by("verify.id", "desc"); 

				$this->db->group_by('verify.id');

				if($limit_start && $limit_end){
				  $this->db->limit($limit_start, $limit_end);	
				}

				if($limit_start != null){
				  $this->db->limit($limit_start, $limit_end);    
				}

				$query = $this->db->get();

				//echo count($query->result_array());

				$this->session->set_userdata('count_all_list_verify',count($query->result_array()) );

				$str = $this->db->last_query();	
			
				$this->session->set_userdata('last_query_verify', $str );
				
				//ChromePhp::log($str);
				//echo 1;

				return $query->result_array(); 	

		}

	}


	function count_all_verify_checked ($dep_id , $yea_id )  {

			$this->db->select('s.std_cardid');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');
			$this->db->select('s.dep_id');
			$this->db->select('s.yea_id');

			$this->db->select('d.dep_eng');
			$this->db->select('d.dep_thai');
			$this->db->select('d.dep_eng');

			$this->db->select('y.yea_title');

			$this->db->from('students_info  as s');

			$this->db->join('department as d', 's.dep_id = d.id');
			$this->db->join('year as y', 's.yea_id = y.id');

			$this->db->where('s.dep_id = ', $dep_id );
			$this->db->where('s.yea_id = ', $yea_id );
			 
			$this->db->group_by('s.std_cardid');

			$query = $this->db->get();

			$this->session->set_userdata('count_all_verify_checked',count($query->result_array()) );
			
			$str = $this->db->last_query();	

			//echo count($query->result_array());
			
			//echo count($query->result_array());

		return count($query->result_array());
	}

	function count_all_verify( $search_string  ) {
		
			$this->db->select('v.id');
			$this->db->select('v.maj_id');
			$this->db->select('v.maj_detail');
			$this->db->select('v.dep_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.yea_id');
			$this->db->select('v.std_reg_id');
			$this->db->select('v.usr_id');
			$this->db->select('v.total_study');
			$this->db->select('v.min_late');
			$this->db->select('v.min_leave');
			$this->db->select('v.min_missing');
			$this->db->select('v.msg_alert');
			$this->db->select('v.ver_date');

			$this->db->select('m.maj_id');	
			$this->db->select('m.maj_thai');	

			$this->db->select('d.dep_thai');
			$this->db->select('y.yea_title');
			
			$this->db->from('verify as v');

			//$this->db->from('year as y');
			//$this->db->from('department as d');
			//$this->db->from('major as m');

			$this->db->join('department as d','d.id = v.dep_id', 'left');
			$this->db->join('year as y ','y.id = v.yea_id', 'left');
			$this->db->join('major as m ','m.id = v.maj_id', 'left');
			
					
		if ($search_string != "" ){
			$this->db->or_like('v.maj_id', $search_string );
		}

		$this->db->group_by('v.id');

		$query = $this->db->get();

		//echo count($query->result_array());

		$this->session->set_userdata('count_all_verify',count($query->result_array()) );
		
		return count($query->result_array());
	}


	function check_id_verify( $search_string  ) {
		
		$this->db->select('s.std_cardid');
		$this->db->from(' students_info  as s');
		$this->db->where('s.std_cardid', $search_string );
		$query = $this->db->get();		
		return count($query->result_array());
	}



    function edit_verify($id)    {

			$this->db->select('v.id as ver_id');
			$this->db->select('v.maj_id');
			$this->db->select('v.maj_detail');
			$this->db->select('v.dep_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.yea_id');
			$this->db->select('v.std_reg_id');
			$this->db->select('v.usr_id');
			$this->db->select('v.total_study');
			$this->db->select('v.min_late');
			$this->db->select('v.min_leave');
			$this->db->select('v.min_missing');
			$this->db->select('v.msg_alert');
			$this->db->select('v.ver_date');
			$this->db->select('v.ver_status');
			$this->db->select('y.yea_title');

			$this->db->from('verify as v');
			$this->db->from('department as d');
			$this->db->from('year as y');
			$this->db->from('major as m');

			$this->db->where('v.id = ', $id );

			$this->db->where('v.usr_id',  $this->session->userdata('usr_id')  );	

			$this->db->join('department','d.id = v.dep_id', 'left');
			$this->db->join('year','year.id = v.yea_id', 'left');
			$this->db->join('major','m.id = v.maj_id', 'left');
			
			$this->db->group_by('v.id'); 

			$query = $this->db->get();

			$str = $this->db->last_query();	

			return $query->result();
    }


	function count_all_normal ($sitekey ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 1 AND sitekey = "'.$sitekey.'" ) AS normal');
		$query = $this->db->get();	
		return $query->result_array();
	}

	function count_all_late ($sitekey ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 2 AND sitekey = "'.$sitekey.'" ) AS late');
		$query = $this->db->get();		
		return $query->result_array();
	}

	function count_all_leaves ($sitekey ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 3 AND sitekey = "'.$sitekey.'" ) AS leaves');
		$query = $this->db->get();		
		return $query->result_array();
	}

	function count_all_missing ($sitekey ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 4 AND sitekey = "'.$sitekey.'" ) AS missing');
		$query = $this->db->get();		
		return $query->result_array();
	}

	/////// Export Total
	//Normal
	function count_all_normal_total ($std_id,$maj_id,$ter_id,$yea_id ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 1 AND std_id = "'.$std_id.'" AND maj_id = "'.$maj_id.'" AND ter_id = "'.$ter_id.'" AND yea_title = "'.$yea_id.'"  ) AS normal');
		$query = $this->db->get();	
		
		return $query->result_array();
	}

	//Normal
	function count_all_late_total ($std_id,$maj_id,$ter_id,$yea_id ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 2 AND std_id = "'.$std_id.'" AND maj_id = "'.$maj_id.'" AND ter_id = "'.$ter_id.'" AND yea_title = "'.$yea_id.'"  ) AS late');
		$query = $this->db->get();	
		
		$str = $this->db->last_query();	
		
		ChromePhp::log($str);

		//print_r($str);
		//exit;

		return $query->result_array();
	}
	
	//Normal
	function count_all_leaves_total ($std_id,$maj_id,$ter_id,$yea_id ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 3 AND std_id = "'.$std_id.'" AND maj_id = "'.$maj_id.'" AND ter_id = "'.$ter_id.'" AND yea_title = "'.$yea_id.'"  ) AS leaves');
		$query = $this->db->get();	
		
		//$str = $this->db->last_query();	
		
		//print_r($str);
		//exit;

		return $query->result_array();
	}

	//Normal
	function count_all_missing_total ($std_id,$maj_id,$ter_id,$yea_id ){
		$this->db->select('(SELECT COUNT(*) FROM verify_checked  WHERE ver_sta_id = 4 AND std_id = "'.$std_id.'" AND maj_id = "'.$maj_id.'" AND ter_id = "'.$ter_id.'" AND yea_title = "'.$yea_id.'"  ) AS missing');
		$query = $this->db->get();	
		
		//$str = $this->db->last_query();	
		
		//print_r($str);
		//exit;

		return $query->result_array();
	}

	/// END


	function edit_verify_checked( $dep_id , $maj_id , $ter_id , $yea_title){

			$this->db->select('v.id');	
			$this->db->select('v.std_id');
			$this->db->select('v.maj_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.yea_title');
			$this->db->select('v.log_time');
			$this->db->select('v.sitekey');

			$this->db->from('verify_checked as v');
			
			$this->db->where('v.dep_id = ', $dep_id );
			$this->db->where('v.maj_id = ', $maj_id );
			$this->db->where('v.ter_id = ', $ter_id );
			$this->db->where('v.yea_title = ', $yea_title );

			$this->db->where('v.usr_id = ', $this->session->userdata('usr_id')  );

			$this->db->group_by('v.sitekey'); 

			$query = $this->db->get();

			$str = $this->db->last_query();	
			
			//$myfile = fopen("sql.txt", "w") or die("Unable to open file!");
			//fwrite($myfile, $str);
			//fclose($myfile);

			//ChromePhp::log($str);

			return $query->result();
			
	}

	function verify_check_export($maj_id , $ter_id , $yea_title){

			$this->db->select('v.std_id');
			$this->db->select('v.maj_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.yea_title');
			$this->db->select('v.log_time');
			$this->db->select('v.sitekey');
			$this->db->select('v.usr_id');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');

			$this->db->from('verify_checked as v');

			$this->db->where('v.maj_id = ', $maj_id );
			$this->db->where('v.ter_id = ', $ter_id );
			$this->db->where('v.yea_title = ', $yea_title );

			$this->db->where('v.usr_id = ', $this->session->userdata('usr_id')  );
	
			$this->db->join('students_info as s','v.std_id = s.std_cardid');

			$this->db->group_by('v.sitekey'); 

			$query = $this->db->get();

			$str = $this->db->last_query();	
			
			//ChromePhp::log($str);

			return $query->result();
			
	}

	function detail_verify_checked ($sitekey){

			$this->db->select('v.id');
			$this->db->select('v.std_id');
			$this->db->select('v.maj_id');
			$this->db->select('v.ver_sta_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.yea_title');
			$this->db->select('v.log_time');
			$this->db->select('v.allday');
			$this->db->select('v.sitekey');
			$this->db->select('s.std_cardid');
			$this->db->select('s.std_fname');
			$this->db->select('s.std_lname');
			$this->db->select('d.dep_thai');
			$this->db->select('y.yea_title');

			$this->db->from('verify_checked as v');
			$this->db->join('students_info as s ','s.std_cardid = v.std_id');
			$this->db->join('department as d','s.dep_id = d.id');
			$this->db->join('year as y','s.yea_id = y.id');

			$this->db->where('v.sitekey = ', $sitekey );

			$this->db->group_by('v.id'); 

			$query = $this->db->get();
			
			$str = $this->db->last_query();	

			//ChromePhp::log($str);
		
			return $query->result();
			
	}


	function full_calendar($usr_id ,  $ter_id , $last_year  ){


			$this->db->select('v.id');
			$this->db->select('v.std_id');
			$this->db->select('v.ver_sta_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.log_time');
			$this->db->select('v.allday');
			$this->db->select('v.sitekey');
			$this->db->select('major.maj_id');
			$this->db->select('major.maj_thai');
			$this->db->select('year.yea_title');
			$this->db->select('department.dep_id');

			$this->db->from('verify_checked as v');

			$this->db->where('v.ter_id = ', $ter_id );
			$this->db->where('verify.yea_id = ', $last_year );			

			$this->db->join('verify ','v.ver_id = verify.id');
			$this->db->join('major','v.maj_id = major.id');
			$this->db->join('`year`',' v.yea_title = year.id');
			$this->db->join('department','verify.dep_id = department.id');


			$this->db->group_by('v.sitekey'); 

			$query = $this->db->get();
			
			$str = $this->db->last_query();	

			//ChromePhp::log($str);

			return $query->result();
			
	}

	function calendar_verify_checked ($dep_id ,$maj_id , $ter_id ,$yea_id ){

			$this->db->select('m.id');
			$this->db->select('m.maj_id AS des');
			$this->db->select('m.maj_thai');
			$this->db->select('v.maj_id');
			$this->db->select('v.dep_id');
			$this->db->select('v.ter_id');
			$this->db->select('v.yea_id');
			$this->db->select('vc.ver_sta_id');
			$this->db->select('vc.usr_id');
			$this->db->select('vc.log_time');
			$this->db->select('vc.sitekey');

			$this->db->from('verify as v');

			$this->db->join('major as m ', 'v.maj_detail = m.maj_id');
			$this->db->join('verify_checked as vc ', 'vc.ver_id = v.id');

			$this->db->where('v.dep_id =', $dep_id );
			$this->db->where('v.maj_id =', $maj_id );
			$this->db->where('v.ter_id =', $ter_id );
			$this->db->where('v.yea_id =', $yea_id );

			$this->db->where('v.usr_id = ', $this->session->userdata('usr_id')  );

			$this->db->group_by('vc.sitekey'); 

			$query = $this->db->get();

			$str = $this->db->last_query();	

			//$myfile = fopen("sql.txt", "w") or die("Unable to open file!");
			//fwrite($myfile, $str);
			//fclose($myfile);

			//ChromePhp::log($str);

			return $query->result();
			
	}

	function count_verify_checked($maj_id , $dep_id, $ter_id , $yea_title){
			
			$this->db->select('v.id');

			$this->db->select('v.log_time');

			$this->db->from('verify_checked as v');


			$this->db->where('v.maj_id = ', $maj_id );

			$this->db->where('v.dep_id = ', $dep_id );

			$this->db->where('v.ter_id = ', $ter_id );

			$this->db->where('v.yea_title = ', $yea_title );

			$this->db->where('v.usr_id',  $this->session->userdata('usr_id')  );	

			$this->db->order_by('v.id'); 

			$this->db->group_by('v.sitekey'); 

			$query = $this->db->get();

			$str = $this->db->last_query();	

			/*
				$myfile = fopen("sql.txt", "w") or die("Unable to open file!");
				fwrite($myfile, $str);
				fclose($myfile);
			*/

			return count($query->result());		
	}

	function list_subject_verify($id){

			$this->db->select('v.id');
			$this->db->select('m.maj_id');
			$this->db->select('m.maj_thai');
			$this->db->select('m.maj_unit');

			$this->db->from('major as m');

			$this->db->where('v.id = ', $id );
			$this->db->join('verify as v','v.maj_id = m.id');

			$this->db->group_by('v.id'); 

			$query = $this->db->get();

			$str = $this->db->last_query();	
			
			//ChromePhp::log($str);

		return $query->result();	
	}

	function change_status($std_id , $sitekey , $data){

		$this->db->where('std_id', $std_id);
		$this->db->where('sitekey', $sitekey);
		$this->db->update('verify_checked', $data);
		
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
	
	function statics_checked (){
		
	}

	function delete_verify($id){
        $query = $this->db->query("DELETE FROM  verify WHERE id='".$id."'");
        return $query->result();	
	}

	function delete_verify_checked($id){

		$item = explode("-", $id);

		$query = $this->db->query("DELETE FROM verify_checked WHERE maj_id='".$item[0]."' AND ter_id='".$item[1]."' AND yea_title='".$item[2]."' ");

		return $query->result();

	}

	function delete_verify_all_checked($id){
        $query = $this->db->query("DELETE FROM verify_checked  WHERE sitekey='".$id."'");
        return $query->result();	
	}



    function save_verify($data)
    {
		$this->db->insert('verify', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}

		$str = $this->db->last_query();	
		
		exit;
	}

    function save_verify_checked($data)
    {
		$this->db->insert('verify_checked', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    function update_verify($id, $data){
		$this->db->where('id', $id);
		$this->db->update('verify', $data);
		
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