<?php
class Year extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->authen->check_login($this->session->userdata('usr_id'));

		$this->load->model('Years_model');
		
		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

		$this->Years_model->count_all_year(0);
    }

	public function index(){

		$this->load->library('pagination');

		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$count_all_year = $this->input->post('count_all_year'); 

        //pagination settings
        $config['base_url'] = base_url().'year/index/';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_year == "" ) { $count_all_year = $this->session->userdata('count_all_year'); } 

		$config['total_rows'] = $count_all_year;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;
		
		$data['query'] = $this->Years_model->list_year(  $config['per_page'] , $this->uri->segment(3) , $keyword , $group_field  );
		
		$data['main_content']="admin/year/index";
		$this->load->view('admin_template',$data); 
	}

	public function clear_all_year() {
		$this->session->unset_userdata('count_all_list_year');
		$this->session->set_userdata('flag_year',0);
		exit;
	}

	public function count_all_year() {
		$keyword = trim($this->input->post('search_string')); 
		$this->session->set_userdata('flag_year',1 );
		echo $this->Years_model->count_all_year( $keyword );
		exit;
	}

	public function check_year_title() {
		$keyword = trim($this->input->post('search_string')); 
		$output = $this->Years_model->check_dep_id( $keyword );
		echo $output;
		exit;
	}

	public function add_year() {

		$data['year'] = $this->Years_model->list_all_year();	
		$data['main_content']="admin/year/addnew";
		$this->load->view('admin_template',$data); 
	}

	public function save_year() {

		//Add New Data year
		$data = array(
			   'yea_title' => $_POST['yea_title']  ,

		);

		$this->Years_model->save_year($data);	

		$this->session->set_flashdata('message','บันทึกข้อมูลเรียบร้อยแล้ว!');
		redirect('/year/', 'refresh');

	}

	public function edit_year(){

		$data['yea_id']  = $this->uri->segment(3);

		$data['query'] = $this->Years_model->edit_year($data['yea_id']);
		
		$data['main_content']="admin/year/edit";
		$this->load->view('admin_template',$data);
	}

	public function update_year(){

		
		$data = array(
		   'yea_title' =>$_POST['yea_title'] ,
		);

		$this->Years_model->update_year($_POST['yea_id'],$data);		

		$this->session->set_flashdata('message','อัปเดทข้อมูลเรียบร้อยแล้ว!');
		redirect('/year/', 'refresh');
		
	}

	public function view_year(){

		$year_id = $this->uri->segment(3);
		$data['main_content']="year/view";
		$data['query'] = $this->Years_model->view_year($year_id);
		$data['info_year'] = $this->Years_model->info_year($year_id);
		$data['year_id'] = $year_id;
		$this->load->view('template',$data);

	}

	public function delete_year(){
		echo $this->Years_model->delete_year($_POST['data_id']);
		exit;
	}	
}

?>