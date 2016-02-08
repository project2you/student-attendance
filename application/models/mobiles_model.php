<?php

class Mobiles_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

   	function login($username , $password ){

		$this->db->select('usr_id');
		$this->db->select('usr_email');
		$this->db->select('usr_password');
		$this->db->select('usr_fname');
		$this->db->select('usr_email');
		$this->db->select('usr_level');

		$this->db->from('user');
		
		$this->db->where('usr_email', $username  );	 
		$this->db->where('usr_password', $password  );	 

		$query = $this->db->get();
				
		$str = $this->db->last_query();	
		
		//ChromePhp::log($str);
		
		return $query->result();
	}

   	function update_password($id,$data){

		$this->db->where('usr_id', $id);
		$this->db->update('user', $data);
		$report = array();
	}

	function list_all_department(){
        $query = $this->db->query('select * from department');
        return $query->result();	
	}

	function list_major($ter_id , $yea_id ){

		$this->db->select('m.id');
		$this->db->select('m.maj_id');
		$this->db->select('m.maj_thai');
		$this->db->select('m.maj_des');
				
		$this->db->from('major as m');
		
		$this->db->where('m.maj_term', $ter_id  );	 
		$this->db->where('m.maj_year', $yea_id  );	 

		//$this->db->where('m.usr_id',  $this->session->userdata('usr_id')  );	
		
		$this->db->group_by('m.id');

		$query = $this->db->get();
				
		$str = $this->db->last_query();
				
		return $query->result();
	}

	function list_verify($ter_id , $yea_id  ){

		$this->db->select('verify.id');
		$this->db->select('verify.ter_id');
		$this->db->select('verify.yea_id');
		$this->db->select('verify.std_reg_id');
		$this->db->select('verify.dep_id');
		$this->db->select('verify.maj_id as v_maj_id');

		$this->db->select('major.id as maj_join_id ');
		$this->db->select('major.maj_id');
		$this->db->select('major.maj_thai');

		$this->db->select('verify.usr_id');
		$this->db->select('year.yea_title');

		$this->db->from('verify');
		
		$this->db->join('major','verify.maj_detail =major.maj_id');
		$this->db->join('year','verify.yea_id = year.id');
		//$this->db->join('verify_checked','verify_checked.usr_id = verify.usr_id');
	
		$this->db->where('verify.ter_id', $ter_id  );	 
		$this->db->where('verify.yea_id', $yea_id  );	 

		$this->db->where('verify.usr_id',  $this->session->userdata('usr_id')  );	

		$this->db->group_by('verify.id');

		$query = $this->db->get();
				
		$str = $this->db->last_query();
			
		return $query->result();
	}

	public function list_static()
	{
		$data['year'] = $this->Statics_model->list_all_year();	

		$last_year = $this->Statics_model->last_year();	
		
		$data['last_year'] =$last_year[0]->id;
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];

		$data['static_summary'] = $this->Statics_model->static_summary(  $data['ter_id'] ,  $last_year[0]->id );

	}
	
}

?>