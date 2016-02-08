<?php
class User extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$this->authen->check_login($this->session->userdata('usr_id'));

		$this->load->library('excel');
		$this->load->library('upload');
		$this->load->model('Users_model');
		
		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

		//echo $this->session->userdata('count_all');

		$this->Users_model->count_all_user(0);
    }

	public function index(){

		$this->load->library('pagination');

		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$count_all_user = $this->input->post('count_all_user'); 

        //pagination settings
        $config['base_url'] = base_url().'user/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_user == "" ) { $count_all_user = $this->session->userdata('count_all'); } 

		$config['total_rows'] = $count_all_user;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;
		
		$data['query'] = $this->Users_model->list_user(  $config['per_page'] , $this->uri->segment(3) , $keyword , $group_field  );

		$data['department'] = $this->Users_model->list_department();	
		
		$data['main_content']="admin/user/index";
		$this->load->view('admin_template',$data); 
	}

	public function clear_all_user() {

		$this->session->unset_userdata('count_all');
		$this->session->unset_userdata('count_all_list_user');
		$this->session->set_userdata('flag_user',0);
		exit;
	}

	public function count_all_user() {
		$keyword = trim($this->input->post('search_string')); 
		$this->session->set_userdata('flag_user',1 );
		echo $this->Users_model->count_all_user( $keyword );
		exit;
	}

	public function check_usr_email() {
		$keyword = trim($this->input->post('search_string')); 
		$output = $this->Users_model->check_usr_email( $keyword );
		echo $output;
		exit;
	}

	public function add_user() {

		$data['year'] = $this->Users_model->list_year();
		$data['department'] = $this->Users_model->list_department();	
		$data['main_content']="admin/user/addnew";
		$this->load->view('admin_template',$data); 
	}

	public function save_user() {

		//$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
		//$this->form_validation->set_rules('std_cardid', 'std_cardid', 'required');

		$config['upload_path'] = 'assets/uploads/photo';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '1024';
		$config['max_height'] = '800';

		$this->load->library('upload', $config);
		$this->upload->initialize($config); 


		if ( ! $this->upload->do_upload()) {
				 //$error = array('error' => $this->upload->display_errors());
				 //print_r($error);
				//$this->load->view('upload_form', $error);
				
				$data_picture = array(
					'usr_picture' => '', 
				);

				//exit;
		} else {
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
		}
			
		//Add New Data user
		$data = array(
			   'usr_email' => $_POST['email']  ,
			   'usr_password' =>$_POST['usr_password'] ,
			   'usr_fname' =>$_POST['usr_fname'] ,
			   'usr_lname' => $_POST['usr_lname'] , 
			   'usr_department' => $_POST['dep_id']  ,
			   'usr_date' => '' ,
			   'usr_level' =>$_POST['usr_level'] ,
		);
		
		$this->Users_model->save_user($data);	

		$this->Users_model->update_user_picture( $_POST['usr_email'] , $data_picture);	
		
		//echo  $_POST['usr_email'];
		//print_r($data_picture);
		//exit;

		$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');
		redirect('user/index/', 'refresh');
	}

	public function edit_user(){

		$user_id = $this->uri->segment(3);
		
		$data['query'] = $this->Users_model->edit_user($user_id);
		
		$data['department'] = $this->Users_model->list_department();		
		$data['year'] = $this->Users_model->list_year();

		$data['main_content']="admin/user/edit";
		$this->load->view('admin_template',$data);

	}

	public function update_user(){

		$config['upload_path'] = 'assets/uploads/photo';
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

				$this->Users_model->update_user_picture( $_POST['usr_email'] , $data_picture);	

			} else{
				 $error = array('error' => $this->upload->display_errors());
				 //print_r($error['error']);			
				 //exit;
			}
			
			$data = array(
			   'usr_email' => $_POST['usr_email']  ,
			   'usr_password' =>$_POST['usr_password'] ,
			   'usr_fname' =>$_POST['usr_fname'] ,
			   'usr_lname' => $_POST['usr_lname'] , 
			   'usr_department' => $_POST['usr_department'] ,
			   'usr_level' =>$_POST['usr_level'] ,
			);
			
			$this->Users_model->update_user($_POST['usr_id'],$data);		
			$this->session->set_flashdata('message','อัปเดทข้อมูลเรียบร้อยแล้ว!');
			redirect('/user/index/', 'refresh');

	}

	public function view_user(){

		$user_id = $this->uri->segment(3);
		$data['main_content']="user/view";
		$data['query'] = $this->Users_model->view_user($user_id);
		$data['info_user'] = $this->Users_model->info_user($user_id);
		$data['user_id'] = $user_id;
		$this->load->view('template',$data);

	}

	public function delete_user(){

		$this->session->set_flashdata('message','ลบข้อมูลเรียบร้อยแล้ว!');
		echo $this->Users_model->delete_user($_POST['data_id']);
		exit;
	}


}

?>