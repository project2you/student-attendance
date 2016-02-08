<?php
class Verify extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		date_default_timezone_set('Asia/Bangkok');

		$this->authen->check_login($this->session->userdata('usr_id') ,'front/' );

		$this->load->helper('url');
		$this->load->library('excel');
		$this->load->library('upload');
		$this->load->library('pagination');

		$this->load->helper('form');
		$this->load->helper('date');

		$this->load->model('Verifys_model');
		$this->load->model('Settings_model');
		$this->load->model('Years_model');

		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";

		//echo $this->session->userdata('count_all');

		$this->Verifys_model->count_all_verify(0);
    }

	public function index(){

		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$count_all_verify = $this->input->post('count_all_verify'); 

        //pagination settings
        $config['base_url'] = base_url().'verify/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_verify == "" ) { $count_all_verify = $this->session->userdata('count_all_verify'); } 

		$config['total_rows'] = $count_all_verify;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;
		
		$data['query'] = $this->Verifys_model->list_verify(  $config['per_page'] , $this->uri->segment(3) , $keyword , $group_field  );

		$data['department'] = $this->Verifys_model->list_department();	

		$data['year'] = $this->Years_model->list_all_year();
		
		//print_r( $data['year'] );
		//exit;

		
		$data['main_content']="admin/verify/index";
		$this->load->view('admin_template',$data); 
	}

	public function list_verify(){

		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$search_year = $this->input->post('search_year'); 

		$count_all_verify = $this->input->post('count_all_verify'); 

        //pagination settings
        $config['base_url'] = base_url().'verify/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_verify == "" ) { $count_all_verify = $this->session->userdata('count_all_verify'); } 

		$config['total_rows'] = $count_all_verify;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;

		$data['query'] = $this->Verifys_model->list_verify(  $config['per_page'] , $this->uri->segment(3) , $keyword ,  $group_field  , $search_year );
		
		$data['department'] = $this->Verifys_model->list_department();	
		$data['year'] = $this->Years_model->list_all_year();

		$data['main_content']="admin/verify/list_verify";

		$this->load->view('admin_template',$data); 
	}

	public function clear_all_verify() {
		$this->session->unset_userdata('count_all');
		$this->session->unset_userdata('count_all_list_verify');
		$this->session->set_userdata('flag_verify',0);
		exit;
	}

	public function count_all_verify() {
		$keyword = trim($this->input->post('search_string')); 
		$this->session->set_userdata('flag_verify',1 );
		$this->Verifys_model->count_all_verify( $keyword );
		exit;
	}

	public function check_id_verify() {
		$keyword = trim($this->input->post('search_string')); 
		$output = $this->Verifys_model->check_id_verify( $keyword );
		echo $output;
		exit;
	}


	public function change_status(){

		$val = trim($this->input->post('val')); 
		$std_id = trim($this->input->post('std_id')); 
		$sitekey = trim($this->input->post('sitekey')); 


		//Add New Data Verify
		$data = array(
			   'ver_sta_id' => $val ,
		);

		$this->Verifys_model->change_status($std_id , $sitekey , $data);		
		$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');
		exit;
	}

	public function list_major() {
		
		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$count_all_verify = $this->input->post('count_all_verify'); 
		
		$search_year = $this->input->post('search_year'); 

        //pagination settings
        $config['base_url'] = base_url().'verify/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_verify == "" ) { $count_all_verify = $this->session->userdata('count_all_verify'); } 

		$config['total_rows'] = $count_all_verify;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;
		
		$data['query'] = $this->Verifys_model->list_verify(  $config['per_page'] , $this->uri->segment(3) , $keyword , $group_field  , $search_year  );
		
		$data['department'] = $this->Verifys_model->list_department();	
		$data['year'] = $this->Years_model->list_all_year();
		
		$data['main_content']="admin/verify/list_major";
		$this->load->view('admin_template',$data); 
	}

	public function statics() {
		echo 1;

	}

	public function add_new() {

		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$count_all_verify = $this->input->post('count_all_verify'); 

        //pagination settings
        $config['base_url'] = base_url().'verify/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		if (  $count_all_verify == "" ) { $count_all_verify = $this->session->userdata('count_all_verify'); } 

		$config['total_rows'] = $count_all_verify;
		$config['per_page'] = 10; 

		$this->pagination->initialize($config); 
		
		$data['query'] = $this->Verifys_model->check_verify(  $config['per_page'] , $this->uri->segment(3) , $keyword , $group_field , 0 ,0  );

		$data['department'] = $this->Verifys_model->list_department();	
		
		//ปีล่าสุดที่เปิดภาคเรียน
		$last_year = $this->Verifys_model->last_year();	
		$data['last_year'] =$last_year[0]->id;
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];
		

		$data['list_major'] = $this->Verifys_model->list_major_by_order( $data['ter_id'] , $data['last_year'] );	

		$data['keyword'] = $keyword;
		$data['group_field'] = $group_field;
		
		$data['year'] = $this->Verifys_model->list_year();
		$data['department'] = $this->Verifys_model->list_department();	
		$data['main_content']="admin/verify/addnew";
		$this->load->view('admin_template',$data); 
	}

	public function add_verify() {

		$keyword = trim($this->input->post('search_string')); 
        $group_field = $this->input->post('group_field'); 
		$count_all_verify_checked = $this->input->post('count_all_verify_checked'); 

        //pagination settings
        $config['base_url'] = base_url().'verify/index';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<ul class="cd-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="button">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="button"><a class="current" href="#0">';
        $config['cur_tag_close'] = '</a></li>';
		
		$data['id'] = $this->uri->segment(3);
		$data['maj_id'] = $this->uri->segment(4);
		$data['dep_id'] = $this->uri->segment(5);
		$data['ter_id'] = $this->uri->segment(6);
		$data['yea_id'] = $this->uri->segment(7);
		$data['std_reg_id'] = $this->uri->segment(8);
		

		$config['total_rows'] =  $this->Verifys_model->count_all_verify_checked($data['dep_id'] , $data['std_reg_id'] );
		
		//print_r($config['total_rows']);
		//exit;

		$config['per_page'] = 100; 

		$this->pagination->initialize($config); 

		$data['id'] = $this->uri->segment(3);
		$data['maj_id'] = $this->uri->segment(4);
		$data['dep_id'] = $this->uri->segment(5);
		$data['ter_id'] = $this->uri->segment(6);
		$data['yea_id'] = $this->uri->segment(7);
		$data['std_reg_id'] = $this->uri->segment(8);
		
		$data['query'] = $this->Verifys_model->check_verify(  $config['per_page'] , $config['total_rows'] , $keyword , $group_field , $data['dep_id']  , $data['std_reg_id'] );
	
		//print_r($data['query'] );

		$data['subject_verify'] = $this->Verifys_model->list_subject_verify($data['id']);	
		
		$data['department'] = $this->Verifys_model->list_department();	

		$data['main_content']="admin/verify/add_verify";
		$this->load->view('admin_template',$data); 
	}

	public function detail_verify_checked(){

		$data['sitekey'] = $this->uri->segment(3);

		$data['query'] = $this->Verifys_model->detail_verify_checked($data['sitekey']);	
		
		$data['main_content']="admin/verify/detail_verify_checked";
		$this->load->view('admin_template',$data); 	
	}

	public function edit_verify_checked(){
	
		$data['id'] = $this->uri->segment(3);
		$data['maj_id'] = $this->uri->segment(4);
		$data['dep_id'] = $this->uri->segment(5);
		$data['ter_id'] = $this->uri->segment(6);
		$data['yea_id'] = $this->uri->segment(7);
		
		$data['query'] = $this->Verifys_model->edit_verify_checked($data['dep_id'] , $data['maj_id'] , $data['ter_id'] , $data['yea_id'] );	 
		
		$data['main_content']="admin/verify/edit_verify_checked";
		$this->load->view('admin_template',$data); 
	}


	public function calendar(){
		
		$data['main_content']="admin/verify/calendar";
		$this->load->view('admin_template',$data); 
	}

	public function full_calendar(){
		
		//ปีล่าสุดที่เปิดภาคเรียน
		$last_year = $this->Verifys_model->last_year();	
		$data['last_year'] =$last_year[0]->id;
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];
		
		$data['query'] = $this->Verifys_model->full_calendar( $this->session->userdata('usr_id') , $data['ter_id'] , $data['last_year']);	

			
		$events = array();
		$e = array();
		foreach ($data['query'] as $item){
			
			$normal = $this->Verifys_model->count_all_normal( $item->sitekey );  
			$late = $this->Verifys_model->count_all_late( $item->sitekey );  
			$leaves = $this->Verifys_model->count_all_leaves( $item->sitekey );  						
			$missing = $this->Verifys_model->count_all_missing( $item->sitekey);  

			$e['title'] = $item->maj_id." : ".$item->maj_thai;
			$e['start'] = $item->log_time;
			$e['tooltip'] =  $item->maj_id.' : '.$item->maj_thai.'  Normal : '.$normal[0]['normal']." , Late : ".$late[0]['late']." , Leave : ".$leaves[0]['leaves']." , Missing : ".$missing[0]['missing'] ;
			//$e['url'] = 'detail_verify_checked/$item->sitekey'.$item->sitekey;
			//$e['allDay']  = false ; // will make the time show
			array_push($events, $e);

		}
		
		echo json_encode($events);
	}

	public function calendar_verify_checked(){
		
		$maj_id = $_POST['maj_id'];
		$yea_id = $_POST['yea_id'];
		$ter_id = $_POST['ter_id'];
		$dep_id = $_POST['dep_id'];

		$data['query'] = $this->Verifys_model->calendar_verify_checked( $dep_id, $maj_id  , $ter_id , $yea_id);	
		
		$events = array();
		$e = array();
		foreach ($data['query'] as $item){
			
			$normal = $this->Verifys_model->count_all_normal( $item->sitekey );  
			$late = $this->Verifys_model->count_all_late( $item->sitekey );  
			$leaves = $this->Verifys_model->count_all_leaves( $item->sitekey );  						
			$missing = $this->Verifys_model->count_all_missing( $item->sitekey);  

			$e['title'] = $item->maj_thai."";
			$e['start'] = $item->log_time;
			$e['tooltip'] = '  Normal : '.$normal[0]['normal']." , Late : ".$late[0]['late']." , Leave : ".$leaves[0]['leaves']." , Missing : ".$missing[0]['missing'] ;

			//$e['url'] = 'http://google.com/';
			//$e['allDay']  = false ; // will make the time show
			array_push($events, $e);

		}
		
		echo json_encode($events);
	}

	public function save_verify_checked(){
		$i = 0;

		$std_id = $this->input->post('std_id');
		$verify_check = $this->input->post('verify_check');

		$ver_id  = $this->input->post('ver_id');
		$maj_id = $this->input->post('maj_id'); 
		$ter_id = $this->input->post('ter_id');
		$dep_id = $this->input->post('dep_id');
		$log_time = trim($this->input->post('log_time'));

		$yea_title = $this->input->post('yea_title');

		$now = time();
		
		$dateInLocal = date(" H:i:s", $now);
		$log_time =$log_time.''.$dateInLocal;

		foreach($std_id as $key=> $std_id_checked) {

			//Add New Data Verify
			$data = array(
			   'ver_id' => $ver_id ,
			   'std_id' => $std_id_checked ,
			   'ver_sta_id' => $verify_check[$i] ,
			   'maj_id' => $maj_id  ,
			   'ter_id' => $ter_id , 
			   'dep_id' => $dep_id , 
			   'yea_title' => $yea_title ,
			   'usr_id' => $this->session->userdata('usr_id'),
			   'log_time' => $log_time ,
			   'sitekey' => md5($log_time) ,
			);
			
			$this->Verifys_model->save_verify_checked($data);	
			$i++;
		}

			$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');
			redirect('verify/list_verify/', 'refresh');
	}
	
	public function save_verify() {

			//Add New Data Verify
			$data = array(
			   'maj_id' => $_POST['maj_id'] ,
			   'maj_detail' => $_POST['maj_detail'] ,
			   'dep_id' => $_POST['dep_id'] ,
			   'ter_id' => $_POST['ter_id'] ,
			   'yea_id' => $_POST['yea_id'] , 
			   'std_reg_id' => $_POST['std_reg_id'] , 
			   'usr_id' => $this->session->userdata('usr_id'),
			   'total_study' => $_POST['total_study'] ,
			   'min_late' =>$_POST['min_late'] ,
			   'min_leave' => $_POST['min_leave'] ,
			   'min_missing' => $_POST['min_missing'] ,
			   'msg_alert' => $_POST['msg_alert'] ,
			);
			
			//print_r($data);
			//exit;

			$this->Verifys_model->save_verify($data);	
			
			$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');
			
			redirect('verify/list_major/', 'refresh');
	}

	public function edit_verify(){
		
		$id = $this->uri->segment(3);

		$data['query'] = $this->Verifys_model->edit_verify($id);
		
		$data['department'] = $this->Verifys_model->list_department();		
		$data['year'] = $this->Verifys_model->list_year();
		
		$data['id'] = $id;

		$data['main_content']="admin/verify/edit";
		$this->load->view('admin_template',$data);

	}

	public function update_verify(){

			//Add New Data Verify
			$data = array(
			   'maj_id' => $_POST['maj_id'] ,
				'dep_id' => $_POST['dep_id'] ,
			   'ter_id' => $_POST['ter_id'] ,
			   'yea_id' => $_POST['yea_id'] , 
			   'total_study' => $_POST['total_study'] ,
			   'min_late' =>$_POST['min_late'] ,
			   'min_leave' => $_POST['min_leave'] ,
			   'min_missing' => $_POST['min_missing'] ,
			   'msg_alert' => $_POST['msg_alert'] ,
			);
		
		$this->Verifys_model->update_verify($_POST['ver_id'],$data);		

		$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');
	
		redirect('/verify/list_major/', 'refresh');
	}
	
	public function list_major_json(){

		//ปีล่าสุดที่เปิดภาคเรียน
		$last_year = $this->Verifys_model->last_year();	
		$data['last_year'] =$last_year[0]->id;
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];
		
		$data['list_major'] = $this->Verifys_model->list_major_by_order( $data['ter_id']  , $data['last_year'] );	

		 foreach ($data['list_major'] as $item):
				$return_arr[] = $item->maj_id;

				 $json_data[]=array(    
						"id"=>$item->id,
						"label"=>$item->maj_id." ".$item->maj_thai,
						"value"=>$item->maj_id);
		 endforeach;
		
		$json= json_encode($json_data);  
		echo $json;  
		exit;
	}

	public function view_verify(){

		$user_id = $this->uri->segment(3);
		$data['main_content']="verify/view";
		$data['query'] = $this->Verifys_model->view_verify($user_id);
		$data['info_verify'] = $this->Verifys_model->info_verify($user_id);
		$data['user_id'] = $user_id;
		$this->load->view('template',$data);
	}

	public function delete_verify(){
		
		$this->session->set_flashdata('message','ลบข้อมูลเรียบร้อยแล้ว!');

		echo $this->Verifys_model->delete_verify($_POST['data_id']);

		exit;
	}

	public function delete_verify_checked(){
		$this->session->set_flashdata('message','ลบข้อมูลเรียบร้อยแล้ว!');
		echo $this->Verifys_model->delete_verify_checked($_POST['data_id']);
		exit;
	}

	public function delete_verify_all_checked(){
		$this->session->set_flashdata('message','ลบข้อมูลเรียบร้อยแล้ว!');
		echo $this->Verifys_model->delete_verify_all_checked($_POST['data_id']);
		exit;
	}
	
	public function import(){
		$data['main_content']="verify/import";
		$this->load->view('template',$data);		
	}

	public function import_verify(){

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

		$data['base_url'] = base_url().'verify/';
		$data['main_content']="admin/verify/import_verify";
		$this->load->view('admin_template',$data); 

	  }//END IF
	}

	public function save_import(){

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("assets/uploads/xls/". $this->session->userdata('file_import') );
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		foreach ($sheetData as $item) {

			$data = array(
			   'std_cardid' => $item['B'] ,
			   'std_fname' => $item['C'] ,
			   'std_lname' => $item['D'] ,
			   'std_gender' => $item['E'] ,
			   'dep_id' => $item['F'] ,
			   'yea_id' => $item['G'] ,
			   'std_email' => $item['H'] ,
			   'std_password' => $item['I'] ,
			   'std_status' => 1 ,
			);

			$this->session->set_flashdata('message','บันทึกข้อมูลสำเร็จ');

			$this->Verifys_model->save_verify($data);		

		}// END For Each

			redirect('/verify/index/', 'refresh');
	}// END Function

	public function export_total_verify(){
			$date = date("m-d-Y-g-i-s");
			
			$data['id'] = $this->uri->segment(3);
			$data['maj_id'] = $this->uri->segment(4);
			$data['dep_id'] = $this->uri->segment(5);
			$data['ter_id'] = $this->uri->segment(6);
			$data['std_reg_id'] = $this->uri->segment(7);
			$data['yea_id'] = $this->uri->segment(8);

			$query = $this->Verifys_model->check_verify( 0 , 0 , 0 , 0 , $data['dep_id']  , $data['std_reg_id'] );
						
			$analysis = $this->Verifys_model->analysis_verify( $data['maj_id'] , $data['dep_id'] , $data['ter_id'] , $data['std_reg_id']  );
			
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Verify');

			$i=2; 
		
			$this->excel->getActiveSheet()->setCellValue('A1', 'ID' );	
			$this->excel->getActiveSheet()->setCellValue('B1', 'Fname');	
			$this->excel->getActiveSheet()->setCellValue('C1', 'Lname');	
			$this->excel->getActiveSheet()->setCellValue('D1', 'dep_thai');	
			$this->excel->getActiveSheet()->setCellValue('E1', 'ter_id');	
			$this->excel->getActiveSheet()->setCellValue('F1', 'yea_title');	

			$this->excel->getActiveSheet()->setCellValue('G1', 'Normal');	
			$this->excel->getActiveSheet()->setCellValue('H1', 'Late');	
			$this->excel->getActiveSheet()->setCellValue('I1', 'Leaves');	
			$this->excel->getActiveSheet()->setCellValue('J1', 'Missing');	

			$this->excel->getActiveSheet()->setCellValue('K1', '');	
			$this->excel->getActiveSheet()->setCellValue('L1', 'Result Late');	
			$this->excel->getActiveSheet()->setCellValue('M1', 'Result Leaves');	
			$this->excel->getActiveSheet()->setCellValue('N1', 'Result Missing');	
			
			
			foreach ($query as $key => $value):
			
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $value['std_cardid']);	

				$this->excel->getActiveSheet()->setCellValue('B'.$i, $value['std_fname'] );	

				$this->excel->getActiveSheet()->setCellValue('C'.$i, $value['std_lname'] );	

				$this->excel->getActiveSheet()->setCellValue('D'.$i, $value['dep_thai'] );	

				$this->excel->getActiveSheet()->setCellValue('E'.$i, $data['ter_id'] );	

				$this->excel->getActiveSheet()->setCellValue('F'.$i, $value['yea_title'] );	

				$count_all_normal = $this->Verifys_model->count_all_normal_total ($value['std_cardid'] , $data['maj_id'] , $data['ter_id'] ,$data['yea_id']  );
				$this->excel->getActiveSheet()->setCellValue('G'.$i, $count_all_normal[0]['normal'] );	

				$count_all_late = $this->Verifys_model->count_all_late_total ($value['std_cardid'] , $data['maj_id'] , $data['ter_id'] ,$data['yea_id']  );
				$this->excel->getActiveSheet()->setCellValue('H'.$i, $count_all_late[0]['late'] );	

				$count_all_leaves = $this->Verifys_model->count_all_leaves_total ($value['std_cardid'] , $data['maj_id'] , $data['ter_id'] ,$data['yea_id']  );
				$this->excel->getActiveSheet()->setCellValue('I'.$i, $count_all_leaves[0]['leaves'] );	

				$count_all_missing = $this->Verifys_model->count_all_missing_total ($value['std_cardid'] , $data['maj_id'] , $data['ter_id'] ,$data['yea_id']  );
				$this->excel->getActiveSheet()->setCellValue('J'.$i, $count_all_missing[0]['missing'] );

				//Analysis

				$analysis_style = array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => 'FF0000')
					));

				if ( $count_all_late[0]['late'] >= $analysis[0]['min_late']  ) { 
							$this->excel->getActiveSheet()->setCellValue('L'.$i, 'Orver' );	
							$this->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($analysis_style);
					} else { 
							$this->excel->getActiveSheet()->setCellValue('L'.$i, 'Normal' );	
					} 


				if ( $count_all_leaves[0]['leaves']  >= $analysis[0]['min_leave'] ) { 
							$this->excel->getActiveSheet()->setCellValue('M'.$i, 'Over' );	
							$this->excel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($analysis_style);
					} else { 
							$this->excel->getActiveSheet()->setCellValue('M'.$i, 'Normal' );	
					} 

				if ( $count_all_missing[0]['missing'] >= $analysis[0]['min_missing']  ) { 
							$this->excel->getActiveSheet()->setCellValue('N'.$i, 'Over' );	
							$this->excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($analysis_style);
					} else { 
							$this->excel->getActiveSheet()->setCellValue('N'.$i, 'Normal' );	
					} 
				
				$i++;
			endforeach;

		foreach(range('B','N') as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}

		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$filename='verify_'.$date .'_.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

	}

	public function export_verify_checked(){
		
		$date = date("m-d-Y-g-i-s");

		$data['maj_id'] = $this->uri->segment(3);
		$data['dep_id'] = $this->uri->segment(4);
		$data['ter_id'] = $this->uri->segment(5);
		$data['yea_id'] = $this->uri->segment(6);
		
		// Query the database.
		$query = $this->Verifys_model->verify_check_export($data['maj_id'] , $data['ter_id']  , $data['yea_id'] );	 	

		 //activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Verify');

		$i=2; 
		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Date' );	
		$this->excel->getActiveSheet()->setCellValue('B1', '');	
		$this->excel->getActiveSheet()->setCellValue('C1', 'Normal');	
		$this->excel->getActiveSheet()->setCellValue('D1', 'Late');	
		$this->excel->getActiveSheet()->setCellValue('E1', 'Leaves');	
		$this->excel->getActiveSheet()->setCellValue('F1', 'Missing');	

		foreach ($query as $key => $value):
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $value->log_time);	
			$this->excel->getActiveSheet()->setCellValue('B'.$i,'' );	

			$count_all_normal = $this->Verifys_model->count_all_normal($value->sitekey);
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $count_all_normal[0]['normal'] );	

			$count_all_late = $this->Verifys_model->count_all_late($value->sitekey);
			$this->excel->getActiveSheet()->setCellValue('D'.$i, $count_all_late[0]['late'] );	

			$count_all_leaves = $this->Verifys_model->count_all_leaves($value->sitekey);
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $count_all_leaves[0]['leaves'] );	

			$count_all_missing = $this->Verifys_model->count_all_missing($value->sitekey);
			$this->excel->getActiveSheet()->setCellValue('F'.$i, $count_all_missing[0]['missing'] );	

			$i++;
		endforeach;

			$this->excel->getActiveSheet()->setCellValue('A'.($i+1), 'Sum');	
			$this->excel->getActiveSheet()->setCellValue('C'.($i+1), '=SUM(C2:C'.($i-1).')');	
			$this->excel->getActiveSheet()->setCellValue('D'.($i+1), '=SUM(D2:D'.($i-1).')');	
			$this->excel->getActiveSheet()->setCellValue('E'.($i+1), '=SUM(E2:E'.($i-1).')');	
			$this->excel->getActiveSheet()->setCellValue('F'.($i+1), '=SUM(F2:F'.($i-1).')');	

			$this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);

			//change the font size
			//$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
			//make the font become bold
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.($i+1))->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A'.($i+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

			//merge cell A1 until D1
			//$this->excel->getActiveSheet()->mergeCells('A1:D1');
			//set aligment to center for that merged cell (A1 to D1)
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$filename='verify_'.$date .'_.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	public function export_detail_verify_checked(){
		$date = date("m-d-Y-g-i-s");
		// Query the database.
		$query = $this->db->query("SELECT NAME,OPHONE,CardNo FROM USERINFO") or die(mysql_error());
 
		 //activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Verify');
		
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
		 
		$filename='verify_'.$date .'_.xls'; //save our workbook as this file name
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