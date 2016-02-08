<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->load->model('Logins_model');
    }

	public function index()
	{
		$this->load->view('admin/login/login');
	}

	public function login_user(){

		$query = $this->db->query("select * from user where usr_email='".$_POST['username']."' AND usr_password='".$_POST['password']."' ");
		$result=$query->result();	
		$row = $query->row(); 

		if (count($row) > 0) {
			$this->session->set_userdata('usr_id',$row->usr_id);
			$this->session->set_userdata('usr_fname',$row->usr_fname);
			$this->session->set_userdata('usr_email',$row->usr_email);
			$this->session->set_userdata('usr_level',$row->usr_level);

			$privilege = $this->Logins_model->check_privilege($row->usr_level);

			$this->session->set_userdata('set_mnu1',$privilege[0]->set_mnu1);
			$this->session->set_userdata('set_mnu2',$privilege[0]->set_mnu2);
			$this->session->set_userdata('set_mnu3',$privilege[0]->set_mnu3);
			$this->session->set_userdata('set_mnu4',$privilege[0]->set_mnu4);
			$this->session->set_userdata('set_mnu5',$privilege[0]->set_mnu5);
			$this->session->set_userdata('set_mnu6',$privilege[0]->set_mnu6);
			$this->session->set_userdata('set_mnu7',$privilege[0]->set_mnu7);
			$this->session->set_userdata('set_mnu8',$privilege[0]->set_mnu8);
			$this->session->set_userdata('set_mnu9',$privilege[0]->set_mnu9);

			$this->session->set_flashdata('message','เข้าสู่ระบบเรียบร้อยแล้ว!!');

			redirect('/statics/index', 'refresh');
			
		}else{
			$this->session->set_flashdata('message',' *** กรุณาตรวจสอบข้อมูล Username / Password!! *** ');
	       redirect(base_url(), 'refresh');
		}	
	}

	public function logout(){
        $this->session->sess_destroy();
       redirect(base_url(), 'refresh');
	}

	public function forgot_password()
	{
		$this->load->view('admin/login/forgot');
	}

	public function reset_password(){ 
	
		$result = $this->Logins_model->check_user_login($_POST['username']);	 

		if (count($result) != 0){

				$strTo = $result[0]->usr_email;
				$strSubject = "Recovery Password";
				$strHeader = "From: webmaster@thaicreate.com";
				$strMessage = "Password is ".$result[0]->usr_password;
				$flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //

				$data['msg_reset']=' *** ระบบได้ทำการส่งรหัสผ่านไปทางอีเมล์ของท่านแล้ว';
		}else{
				$data['msg_reset']= ' *** เกิดข้อผิดพลาด กรุณาตรวจสอบชื่อผู้ใช้อีกครั้ง   ***';
		}

		$this->load->view('admin/login/forgot',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */