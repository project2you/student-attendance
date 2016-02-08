<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statics extends CI_Controller {

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
		
		$this->authen->check_login($this->session->userdata('usr_id'));

		$this->load->model('Statics_model');
		$this->load->model('Settings_model');

		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

    }

	public function index()
	{
		$data['year'] = $this->Statics_model->list_all_year();	

		$last_year = $this->Statics_model->last_year();	
		
		$data['last_year'] =$last_year[0]->id;
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];

		$data['static_summary'] = $this->Statics_model->static_summary(  $data['ter_id'] ,  $last_year[0]->id );

		//ChromePhp::log($data['static_summary']);

		$data['main_content']="admin/statics/index";
		$this->load->view('admin_template',$data); 

	}

	public function search_static()
	{
		$data['year'] = $this->Statics_model->list_all_year();	
		
		$data['ter_id']  = $_POST['ter_id'];

		$data['last_year']  = $_POST['group_field'];

		$data['static_summary'] = $this->Statics_model->static_summary(  $data['ter_id'] ,  $data['last_year']  );	

		//print_r( $data['static_summary'] );

		$data['main_content']="admin/statics/index";
		$this->load->view('admin_template',$data); 		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */