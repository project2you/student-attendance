<?php
class Department extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->authen->check_login($this->session->userdata('usr_id'));

		$this->load->library('excel');
		$this->load->library('upload');

		$this->load->model('Departments_model');
		
		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

		$this->Departments_model->count_all_department(0);
    }

	public function index(){

		$this->load->library('pagination');

		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$count_all_department = $this->input->post('count_all_department'); 

        //pagination settings
        $config['base_url'] = base_url().'department/list_department';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_department == "" ) { $count_all_department = $this->session->userdata('count_all_department'); } 

		$config['total_rows'] = $count_all_department;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;
		
		$data['query'] = $this->Departments_model->list_department(  $config['per_page'] , $this->uri->segment(3) , $keyword , $group_field  );
		
		$data['main_content']="admin/department/index";
		$this->load->view('admin_template',$data); 
	}

	public function clear_all_department() {
		$this->session->unset_userdata('count_all_list_department');
		$this->session->set_userdata('flag_department',0);
		exit;
	}

	public function count_all_department() {
		$keyword = trim($this->input->post('search_string')); 
		$this->session->set_userdata('flag_department',1 );
		echo $this->Departments_model->count_all_department( $keyword );
		exit;
	}

	public function check_dep_id() {
		$keyword = trim($this->input->post('search_string')); 
		$output = $this->Departments_model->check_dep_id( $keyword );
		echo $output;
		exit;
	}

	public function add_department() {

		$data['department'] = $this->Departments_model->list_all_department();	
		$data['main_content']="admin/department/addnew";
		$this->load->view('admin_template',$data); 
	}

	public function save_department() {

		//Add New Data department
		$data = array(
			   'dep_id' => $_POST['dep_id']  ,
			   'dep_eng' =>$_POST['dep_eng'] ,
			   'dep_thai' =>$_POST['dep_thai'] ,
			   'dep_status' => $_POST['dep_status'] , 
			   'usr_id' => $this->session->userdata('usr_id')  ,
			   'dep_status' =>  $_POST['dep_status']  ,

		);

		$this->Departments_model->save_department($data);	
		redirect('department/index/', 'refresh');
	}

	public function edit_department(){

		$department_id = $this->uri->segment(3);
		$data['query'] = $this->Departments_model->edit_department($department_id);
		
		$data['main_content']="admin/department/edit";
		$this->load->view('admin_template',$data);
	}

	public function update_department(){

		$config['upload_path'] = 'assets/uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '1024';
		$config['max_height'] = '800';

		$this->load->library('upload', $config);
		$this->upload->initialize($config); 

		if (  $this->upload->do_upload()) {
				
				$data = array('upload_data' => $this->upload->data());
				//$this->load->view('upload_success', $data);
				$data_upload= $this->upload->data();

				// Resize Images
				$config['image_library'] = 'gd2';
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']	 = 128;
				$config['height']	= 128;
				$config['source_image']	= $data_upload['full_path'];
				$this->load->library('image_lib', $config); 
				$this->image_lib->resize();

				$data_picture = array(
					'usr_picture' => $data_upload['raw_name']."_thumb".$data_upload['file_ext'], 
				);

			} else{
				 $error = array('error' => $this->upload->display_errors());
				 //print_r($error['error']);			
				 //exit;
			}

		$data = array(
		   'dep_id' => $_POST['dep_id']  ,
		   'dep_eng' =>$_POST['dep_eng'] ,
		   'dep_thai' =>$_POST['dep_thai'] ,
		   'dep_status' => $_POST['dep_status'] ,
		);

		$this->Departments_model->update_department($_POST['id'],$data);		

		$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');
		
		redirect('department/index/', 'refresh');

	}

	public function view_department(){

		$department_id = $this->uri->segment(3);
		$data['main_content']="department/view";
		$data['query'] = $this->Departments_model->view_department($department_id);
		$data['info_department'] = $this->Departments_model->info_department($department_id);
		$data['department_id'] = $department_id;
		$this->load->view('template',$data);

	}

	public function delete_department(){
		echo $this->Departments_model->delete_department($_POST['data_id']);
		exit;
	}	
}

?>