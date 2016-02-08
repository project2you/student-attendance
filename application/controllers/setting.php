<?php
class Setting extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->authen->check_login($this->session->userdata('usr_id'));

		$this->load->library('excel');
		$this->load->library('upload');

		$this->load->model('Settings_model');
		
		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

    }

	public function index(){
	
		$data['setting'] = $this->Settings_model->list_setting();

		//ChromePhp::log($data['setting']);
	
		$data['main_content']="admin/setting/index";
		$this->load->view('admin_template',$data); 
	}
	
	public function term_setting(){
	
		$data['term_setting'] = $this->Settings_model->term_setting();
		
		//print_r($data['term_setting']);
		//exit;

		$data['main_content']="admin/setting/term_setting";
		$this->load->view('admin_template',$data); 
		
	}

	public function term_setting_update(){

			//Add New Data Student
			$data = array(
			   'set_ter_open' => $_POST['set_ter_open']  ,
			   'set_ter_close' => $_POST['set_ter_close'] ,
			   'set_ter_part' => $_POST['set_ter_part'] ,
			);

			$this->Settings_model->term_setting_update($data , 1 );	
			
			$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

			$data['term_setting'] = $this->Settings_model->term_setting();
		
			$data['main_content']="admin/setting/term_setting";
			$this->load->view('admin_template',$data); 	
	}


	public function save_setting(){

			if ( ! isset($_POST['admin'][1])) {
			   $_POST['admin'][1] = 0;
			}
			if ( ! isset($_POST['admin'][2])) {
			   $_POST['admin'][2] = 0;
			}
			if ( ! isset($_POST['admin'][3])) {
			   $_POST['admin'][3] = 0;
			}
			if ( ! isset($_POST['admin'][4])) {
			   $_POST['admin'][4] = 0;
			}

			if ( ! isset($_POST['admin'][5])) {
			   $_POST['admin'][5] = 0;
			}

			if ( ! isset($_POST['admin'][6])) {
			   $_POST['admin'][6] = 0;
			}

			if ( ! isset($_POST['admin'][7])) {
			   $_POST['admin'][7] = 0;
			}

			if ( ! isset($_POST['admin'][8])) {
			   $_POST['admin'][8] = 0;
			}

			if ( ! isset($_POST['admin'][9])) {
			   $_POST['admin'][9] = 0;
			}

			$data = array(
			   'set_mnu1' => $_POST['admin'][1] ,
			   'set_mnu2' => $_POST['admin'][2] ,
			   'set_mnu3' => $_POST['admin'][3] ,
			   'set_mnu4' => $_POST['admin'][4] , 
			   'set_mnu5' => $_POST['admin'][5] , 
			   'set_mnu6' => $_POST['admin'][6] , 
			   'set_mnu7' => $_POST['admin'][7] , 
			   'set_mnu8' => $_POST['admin'][8] , 
			   'set_mnu9' => $_POST['admin'][9] , 
			);
			
			$this->Settings_model->save_setting($data,1);


			if ( ! isset($_POST['tech'][1])) {
			   $_POST['tech'][1] = 0;
			}
			if ( ! isset($_POST['tech'][2])) {
			   $_POST['tech'][2] = 0;
			}
			if ( ! isset($_POST['tech'][3])) {
			   $_POST['tech'][3] = 0;
			}
			if ( ! isset($_POST['tech'][4])) {
			   $_POST['tech'][4] = 0;
			}

			if ( ! isset($_POST['tech'][5])) {
			   $_POST['tech'][5] = 0;
			}

			if ( ! isset($_POST['tech'][6])) {
			   $_POST['tech'][6] = 0;
			}

			if ( ! isset($_POST['tech'][7])) {
			   $_POST['tech'][7] = 0;
			}

			if ( ! isset($_POST['tech'][8])) {
			   $_POST['tech'][8] = 0;
			}

			if ( ! isset($_POST['tech'][9])) {
			   $_POST['tech'][9] = 0;
			}

			$data = array(
			   'set_mnu1' => $_POST['tech'][1] ,
			   'set_mnu2' => $_POST['tech'][2] ,
			   'set_mnu3' => $_POST['tech'][3] ,
			   'set_mnu4' => $_POST['tech'][4] , 
			   'set_mnu5' => $_POST['tech'][5] , 
			   'set_mnu6' => $_POST['tech'][6] , 
			   'set_mnu7' => $_POST['tech'][7] , 
			   'set_mnu8' => $_POST['tech'][8] , 
			   'set_mnu9' => $_POST['tech'][9] , 
			);
			
			$this->Settings_model->save_setting($data,2);
		


			if ( ! isset($_POST['user'][1])) {
			   $_POST['user'][1] = 0;
			}
			if ( ! isset($_POST['user'][2])) {
			   $_POST['user'][2] = 0;
			}
			if ( ! isset($_POST['user'][3])) {
			   $_POST['user'][3] = 0;
			}
			if ( ! isset($_POST['user'][4])) {
			   $_POST['user'][4] = 0;
			}

			if ( ! isset($_POST['user'][5])) {
			   $_POST['user'][5] = 0;
			}

			if ( ! isset($_POST['user'][6])) {
			   $_POST['user'][6] = 0;
			}

			if ( ! isset($_POST['user'][7])) {
			   $_POST['user'][7] = 0;
			}

			if ( ! isset($_POST['user'][8])) {
			   $_POST['user'][8] = 0;
			}

			if ( ! isset($_POST['user'][9])) {
			   $_POST['user'][9] = 0;
			}

			$data = array(
			   'set_mnu1' => $_POST['user'][1] ,
			   'set_mnu2' => $_POST['user'][2] ,
			   'set_mnu3' => $_POST['user'][3] ,
			   'set_mnu4' => $_POST['user'][4] , 
			   'set_mnu5' => $_POST['user'][5] , 
			   'set_mnu6' => $_POST['user'][6] , 
			   'set_mnu7' => $_POST['user'][7] , 
			   'set_mnu8' => $_POST['user'][8] , 
			   'set_mnu9' => $_POST['user'][9] , 
			);
			
			$this->Settings_model->save_setting($data,3);

			$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

			redirect('setting/', 'refresh');
	}
}

?>