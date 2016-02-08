<?php
class Major extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->authen->check_login($this->session->userdata('usr_id'));

		$this->load->library('excel');
		$this->load->library('upload');

		$this->load->model('Majors_model');
		
		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

		$this->Majors_model->count_all_major(0);

    }

	public function index(){

		$this->load->library('pagination');

		$keyword = trim($this->input->post('search_string')); 
		$search_term = trim($this->input->post('search_term')); 

        $group_field = $this->input->post('group_field'); 
		$count_all_major = $this->input->post('count_all_major'); 

        //pagination settings
        $config['base_url'] = base_url().'major/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_major == "" ) { $count_all_major = $this->session->userdata('count_all_major'); } 

		$config['total_rows'] = $count_all_major;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;
		
		$data['search_term'] = $search_term;

		$data['query'] = $this->Majors_model->list_major(  $config['per_page'] , $this->uri->segment(3) , $keyword , $search_term  ,  $group_field  );

		$data['year'] = $this->Majors_model->list_all_year();	

		$data['main_content']="admin/major/index";
		$this->load->view('admin_template',$data); 
	}

	public function clear_all_major() {
		$this->session->unset_userdata('count_all_list_major');
		$this->session->set_userdata('flag_major',0);
		exit;
	}

	public function count_all_major() {
		$keyword = trim($this->input->post('search_string')); 
		$this->session->set_userdata('flag_major',1 );
		echo $this->Majors_model->count_all_major( $keyword );
		exit;
	}

	public function check_maj_id() {
		$keyword = trim($this->input->post('search_string')); 
		$output = $this->Majors_model->check_maj_id( $keyword );
		echo $output;
		exit;
	}

	public function add_major() {

		$data['year'] = $this->Majors_model->list_all_year();	
		$data['department'] = $this->Majors_model->list_all_department();
		
		$data['main_content']="admin/major/addnew";
		$this->load->view('admin_template',$data); 
	}

	public function save_major() {

		//Add New Data major
		$data = array(
			   'maj_id' => $_POST['maj_id']  ,
			   'maj_thai' =>$_POST['maj_thai'] ,
			   'maj_eng' =>$_POST['maj_eng'] ,
			   'maj_des' => $_POST['maj_des'] , 
			   'maj_unit' => $_POST['maj_unit'] , 
			   'maj_year' => $_POST['maj_year'] , 
			   'maj_term' => $_POST['maj_term'] , 
			   'dep_id' => $_POST['dep_id'] , 
			   'usr_id' => $this->session->userdata('usr_id')  ,
			   'maj_status' =>  $_POST['maj_status']  ,

		);

		$this->Majors_model->save_major($data);	

		$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

		redirect('major/index/', 'refresh');
	}

	public function edit_major(){

		$major_id = $this->uri->segment(3);
		$data['query'] = $this->Majors_model->edit_major($major_id);

		$data['year'] = $this->Majors_model->list_all_year();	
		$data['department'] = $this->Majors_model->list_all_department();
				
		$data['main_content']="admin/major/edit";
		$this->load->view('admin_template',$data);
	}

	public function update_major(){

		$data = array(
			   'maj_id' => $_POST['maj_id']  ,
			   'maj_thai' =>$_POST['maj_thai'] ,
			   'maj_eng' =>$_POST['maj_eng'] ,
			   'maj_des' => $_POST['maj_des'] , 
			   'maj_unit' => $_POST['maj_unit'] , 
			   'maj_year' => $_POST['maj_year'] , 
			   'maj_term' => $_POST['maj_term'] , 
			   'dep_id' => $_POST['dep_id'] , 
			   'usr_id' => $this->session->userdata('usr_id')  ,
			   'maj_status' =>  $_POST['maj_status']  ,

		);

		$this->Majors_model->update_major($_POST['id'],$data);		

		$std_id = $_POST['id'];
		$data['main_content']="admin/major/edit";
		$data['query'] = $this->Majors_model->edit_major($_POST['id']);

		$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');
		$this->load->view('admin_template',$data);
	}

	public function view_major(){

		$major_id = $this->uri->segment(3);
		$data['main_content']="major/view";
		$data['query'] = $this->Major_model->view_major($major_id);
		$data['info_major'] = $this->Major_model->info_major($major_id);
		$data['major_id'] = $major_id;
		$this->load->view('template',$data);

	}

	public function delete_major(){

		parse_str($_POST['data_id'], $searcharray);
		//print_r($searcharray); // Only for print array
		
		foreach ($searcharray['del_std_id'] as $key => $item) {
			$this->Majors_model->delete_major($item);
		}

		$this->session->set_flashdata('message','ลบข้อมูลเรียบร้อยแล้ว!');
		echo 1;
		exit;
	}	

	//Option

	public function import(){
		$data['main_content']="major/import";
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

		$data['base_url'] = base_url().'major/';
		$data['main_content']="admin/major/view_import";
		$this->load->view('admin_template',$data); 
	
	  }//END IF

	}

	public function save_import(){
		
		//echo $this->session->userdata('file_import');
		//exit;

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("assets/uploads/xls/". $this->session->userdata('file_import') );
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		foreach ($sheetData as $item) {

			$data = array(
			   'maj_id'  => $item['B'] ,
			   'maj_thai'  => $item['C'] ,
			   'maj_eng'  => $item['D'] ,
			   'maj_des'  => $item['E'] ,
			   'maj_unit'  => $item['F'] ,
			   'maj_year'  => $item['G'] ,
			   'maj_term'  => $item['H'] ,
			   'usr_id' => $this->session->userdata('usr_id')  ,
			   'maj_status' =>  1  ,
			);
			
				$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

				$this->Majors_model->save_major($data);	


		}// END For Each

					redirect('major/index/', 'refresh');
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