<?php
class Student extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->authen->check_login($this->session->userdata('usr_id'));

		$this->load->helper('url');
		$this->load->library('excel');
		$this->load->library('upload');

		$this->load->model('Students_model');
		$this->load->model('Years_model');

		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

		//echo $this->session->userdata('count_all');

		$this->Students_model->count_all_student(0,0);
    }

	public function index(){

		$this->load->library('pagination');

		$keyword = trim($this->input->post('search_string')); 
		$search_cardid = trim($this->input->post('search_cardid')); 
		
        $group_field = $this->input->post('group_field'); 
		$count_all_student = $this->input->post('count_all_student'); 


        //pagination settings
        $config['base_url'] = base_url().'student/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_student == "" ) { $count_all_student = $this->session->userdata('count_all_student'); } 
		
		$config['total_rows'] = $count_all_student;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['search_cardid'] = $search_cardid;

		$data['group_field'] = $group_field;
	
		$data['query'] = $this->Students_model->list_student( $config['per_page'] , $this->uri->segment(3) , $keyword  , $search_cardid , $group_field  );

		$data['segment']= $this->uri->segment(3) ;
		
		$data['year'] = $this->Years_model->list_all_year();

		$data['department'] = $this->Students_model->list_department();	
		
		$data['main_content']="admin/student/index";
		$this->load->view('admin_template',$data); 

	}

	public function clear_all_student() {

		$this->session->unset_userdata('count_all_student');
		$this->session->unset_userdata('count_all_list_student');
		$this->session->set_userdata('flag_student',0);

		exit;
	}

	public function count_all_student() {
		$keyword = trim($this->input->post('search_string')); 

		$search_cardid = trim($this->input->post('search_cardid')); 

		echo $search_cardid;
		
		$this->session->set_userdata('flag_student',1 );

		echo $this->Students_model->count_all_student( $keyword , $search_cardid );
		exit;
	}

	public function check_id_student() {
		$keyword = trim($this->input->post('search_string')); 
		$output = $this->Students_model->check_id_student( $keyword );
		echo $output;
		exit;
	}

	public function add_student() {

		$data['year'] = $this->Students_model->list_year();
		$data['department'] = $this->Students_model->list_department();	
		$data['main_content']="admin/student/addnew";
		$this->load->view('admin_template',$data); 
	}

	public function save_student() {

		//$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('std_cardid', 'std_cardid', 'required');

		$config['upload_path'] = 'assets/uploads/photo';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '1024';
		$config['max_height'] = '800';

		$this->load->library('upload', $config);
		$this->upload->initialize($config); 

		if ($this->form_validation->run() == FALSE) {
			$data['year'] = $this->Students_model->list_year();
			$data['department'] = $this->Students_model->list_department();	
			$data['main_content']="admin/student/addnew";
			$this->load->view('admin_template',$data);
		}
		else
		{
			if ( ! $this->upload->do_upload()) {
				 //$error = array('error' => $this->upload->display_errors());
				 //print_r($error);
				//$this->load->view('upload_form', $error);
				
				$data_picture = array(
					'std_picture' => '', 
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
					'std_picture' => $data_upload['raw_name']."_thumb".$data_upload['file_ext'], 
				);
			}
			
			//Add New Data Student
			$data = array(
			   'std_cardid' => $_POST['std_cardid']  ,
			   'std_fname' => $_POST['std_fname'] ,
			   'std_lname' => $_POST['std_lname'] ,
			   'std_gender' => $_POST['std_gender'] , 
			   'std_birthday' => $_POST['std_birthday']  ,
			   'std_email' => $_POST['std_email'] ,
			   'std_password' =>$_POST['std_password'] ,
			   'dep_id' => $_POST['dep_id'] ,
			   'yea_id' => $_POST['yea_id'] ,
			   'std_status' => $_POST['std_status'] ,
			);

			$this->Students_model->save_student($data);	
			$this->Students_model->update_student_picture( $_POST['std_cardid'] , $data_picture);	

			$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

			redirect('student/index/', 'refresh');
		}
	}

	public function edit_student(){


		$user_id = $this->uri->segment(3);
		$data['query'] = $this->Students_model->edit_student($user_id);

		$data['department'] = $this->Students_model->list_department();		
		$data['year'] = $this->Students_model->list_year();

		$data['main_content']="admin/student/edit";
		$this->load->view('admin_template',$data);

	}

	public function update_student(){

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
					'std_picture' => $data_upload['raw_name']."_thumb".$data_upload['file_ext'], 
				);

				$this->Students_model->update_student_picture( $_POST['std_cardid'] , $data_picture);	

			} else{
				 $error = array('error' => $this->upload->display_errors());
				 //print_r($error['error']);			
				 //exit;
			}

		$data = array(
		   'std_fname' => $_POST['std_fname']  ,
		   'std_lname' =>$_POST['std_lname'] ,
			'std_gender' => $_POST['std_gender'] , 
		   'std_birthday' =>$_POST['std_birthday'] ,
		   'std_email' => $_POST['std_email'] , 
		   'std_password' => $_POST['std_password'] ,
		   'dep_id' =>$_POST['dep_id'] ,
		   'yea_id' =>$_POST['yea_id'] ,
		);

		$this->Students_model->update_student($_POST['std_cardid'],$data);		

		$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

		$std_id = $_POST['std_id'];
		$data['main_content']="admin/student/edit";
		$data['query'] = $this->Students_model->edit_student($_POST['std_id']);
		$data['department'] = $this->Students_model->list_department();		
		$data['year'] = $this->Students_model->list_year();
		$this->load->view('admin_template',$data);
	//	redirect('/student/edit_student/'.$_POST['usr_id'], 'refresh');
	}

	public function view_student(){

		$user_id = $this->uri->segment(3);
		$data['main_content']="student/view";
		$data['query'] = $this->Students_model->view_student($user_id);
		$data['info_student'] = $this->Students_model->info_student($user_id);
		$data['user_id'] = $user_id;
		$this->load->view('template',$data);

	}

	public function delete_student(){
		
		parse_str($_POST['data_id'], $searcharray);
		//print_r($searcharray); // Only for print array
		
		foreach ($searcharray['del_std_id'] as $key => $item) {
			$this->Students_model->delete_student($item);
		}

		$this->session->set_flashdata('message','ลบข้อมูลเรียบร้อยแล้ว!');
		echo 1; 
		exit;
	}
	
	public function import(){
		$data['main_content']="student/import";
		$this->load->view('template',$data);		
	}

	public function view_import(){

	  $config['upload_path'] = 'assets/uploads/xls';
      $config['allowed_types'] = 'xls';
      $config['max_size']  = 1024 * 8;

      $this->load->library('upload', $config);
	  $this->upload->initialize($config); 

	  
	  if (!$this->upload->do_upload()) {
         echo $this->upload->display_errors();
		 exit;
      }else{
		$file = $this->upload->data();

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("assets/uploads/xls/". $file['file_name']);
		$this->session->set_userdata('file_import',$file['file_name']);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
		$data['sheetData'] = $sheetData;

		$data['base_url'] = base_url().'student/';
		$data['main_content']="admin/student/view_import";
		$this->load->view('admin_template',$data); 

	  }//END IF

	}

	public function save_import(){

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("assets/uploads/xls/". $this->session->userdata('file_import') );
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		//$year = $this->Students_model->list_year_check($sheetData[1]['F']) ;
			
	
		foreach ($sheetData as $item) {
			
			// Check ID For department And Year
			$dep_id = $this->Students_model->import_department_check($item['E']);
			$yea_id = $this->Students_model->import_year_check($item['F']);
			
			$data = array(
			   'std_cardid' => $item['B'] ,
			   'std_fname' => $item['C'] ,
			   'std_lname' => $item['D'] ,
			   'dep_id' => $dep_id[0]->id ,
			   'yea_id' => $yea_id[0]->id ,
			   'std_email' => $item['B'] ,
			   'std_password' => $item['B'] ,
			   'std_status' => 1 ,
			);
	
			$this->Students_model->save_student($data);		
			

		}// END For Each

			$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

			redirect('/student/index/', 'refresh');
	}// END Function


	public function export(){
		$date = date("m-d-Y-g-i-s");
		// Query the database.
		$query = $this->db->query("SELECT NAME,OPHONE,CardNo FROM USERINFO") or die(mysql_error());
 
		 //activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Student');
		
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');

		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='student_'.$date .'_.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

 
	}
}

?>