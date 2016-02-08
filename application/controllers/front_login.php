<?php
class Front_login extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$this->load->library('excel');
		$this->load->library('upload');

		$this->load->model('Fronts_model');
		$this->load->model('Verifys_model');		
		$this->load->model('Students_model');
		$this->load->model('Settings_model');		
		
		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";
    }

	public function index(){
		
		$this->load->view('front/login/index');
	}

	public function login_user(){

		$result = $this->Fronts_model->check_student_login($_POST['std_cardid'] , $_POST['std_password']);
	
		if (count($result) > 0) {
			$this->session->set_userdata('std_cardid',$result[0]->std_cardid);
			$this->session->set_userdata('std_fname' , $result[0]->std_fname);
			$this->session->set_userdata('std_lname' , $result[0]->std_lname);
			$this->session->set_userdata('std_email', $result[0]->std_email);
			$this->session->set_userdata('std_dep_id', $result[0]->dep_id);

			$year = $this->Fronts_model->last_year();
			$this->session->set_userdata('last_year', $year[0]->id);

			//ปีล่าสุดที่เปิดภาคเรียน
			$last_year = $this->Verifys_model->last_year();	
			$data['last_year'] =$last_year[0]->id;
			
			//กำหนด ภาคการศึกษา
			$data['term_setting'] = $this->Settings_model->term_setting();
			$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];
			
			$this->session->userdata('last_year', $data['ter_id']);

			$this->session->set_flashdata('message','เข้าสู่ระบบเรียบร้อยแล้ว!!');

			redirect('/front_profiles/dashboard/', 'refresh');
			
		}else{

			$this->session->set_flashdata('message',' *** กรุณาตรวจสอบข้อมูล *** ');
	        redirect(base_url().'front_login/', 'refresh');

			//$this->load->view('front/login/index');

		}	
	}
	
	

}

?>