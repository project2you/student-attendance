<?php
class Front_profiles extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$this->authen->check_student_login($this->session->userdata('std_cardid') );

		$this->load->library('excel');
		$this->load->library('upload');

		$this->load->model('Fronts_model');
		$this->load->model('Verifys_model');		
		$this->load->model('Students_model');
		$this->load->model('Settings_model');
		$this->load->model('Years_model');

		$data['header']="header";
		$data['menu']="menu";
		$data['footer']="footer";
    }
	
	public function dashboard(){
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];
		$this->session->set_userdata('ter_id',$data['ter_id']);

		//ปีล่าสุดที่เปิดภาคเรียน
		$last_year = $this->Verifys_model->last_year();	
		$data['last_year'] =$last_year[0]->id;
		$this->session->set_userdata('last_year',$data['last_year']);

		$data['result'] = $this->Fronts_model->check_verify($this->session->userdata('std_cardid')  , $data['ter_id'] , $data['last_year'] );

		$data['top_list'] = $this->Fronts_model->top_list($this->session->userdata('std_cardid'));

		$data['main_content']="front/student/index";
		$this->load->view('front_template',$data); 
	}

	public function student_edit(){
		
		$data['list_student'] = $this->Fronts_model->list_student( $this->session->userdata('std_cardid') );

		$data['main_content']="front/student/student_edit";
		$this->load->view('front_template',$data); 		
	}

	public function update_profiles(){ 

		   //Add New Data Student
			$data = array(
			   'std_fname' => $_POST['std_fname'] ,
			   'std_lname' => $_POST['std_lname'] ,
			   'std_gender' => $_POST['std_gender'] , 
			   'std_birthday' => $_POST['std_birthday']  ,
			   'std_email' => $_POST['std_email'] ,
				'std_address' => $_POST['std_address'] ,
				'std_tel' => $_POST['std_tel'] 
			);
			
			$this->Fronts_model->update_profiles( $this->session->userdata('std_cardid') , $data);	
	}

	public function update_picture(){
		
		if(trim($_FILES["myfile"]["tmp_name"]) != "")
			{
				$images = $_FILES["myfile"]["tmp_name"];
				$new_images = "thumb_".$this->session->userdata('std_cardid').'_'.$_FILES["myfile"]["name"];
				copy($_FILES["myfile"]["tmp_name"],"assets/uploads/photo/".$_FILES["myfile"]["name"]);
				$width=150; //*** Fix Width & Heigh (Autu caculate) ***//
				$size=GetimageSize($images);
				$height=round($width*$size[1]/$size[0]);
				$images_orig = ImageCreateFromJPEG($images);
				$photoX = ImagesX($images_orig);
				$photoY = ImagesY($images_orig);
				$images_fin = ImageCreateTrueColor($width, $height);
				ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
				ImageJPEG($images_fin,"assets/uploads/photo/".$new_images);
				ImageDestroy($images_orig);
				ImageDestroy($images_fin);
			}

			$fileName = $_FILES["myfile"]["name"];
			$ret[]= $fileName;
			
			$data_picture = array(
				'std_picture' => $new_images, 
			);

			$this->Students_model->update_student_picture( $this->session->userdata('std_cardid') , $data_picture);	

			//echo  base_url()."assets/uploads/photo/".$new_images;
			  redirect('/front_profiles/student_edit', 'refresh');

			//ChromePhp::log($ret);
			//exit;
	}

	public function student_password(){

		$data['main_content']="front/student/student_password";
		$this->load->view('front_template',$data); 		
		
	}

	public function student_update_password(){

		$check_password = $this->Fronts_model->student_check_password( $this->session->userdata('std_cardid') , $_POST['std_old_password'] );

		//ChromePhp::log($check_password[0]->check_password);
		
		if ($check_password[0]->check_password == 1 ){

			//Add New Data Student
			$data = array(
			   'std_password' =>$_POST['std_new_password'] 
			);
			$this->Fronts_model->student_update_password( $this->session->userdata('std_cardid') , $_POST['std_new_password'] ,$data );	
			echo 1;
		}else{
			echo 0;
		};

	}

	public function history(){

		$var_id = $this->uri->segment(3);
		$dep_id = $this->uri->segment(4);

		$data['result'] = $this->Fronts_model->history( $var_id ,$dep_id  );

		$data['main_content']="front/student/student_history";
		$this->load->view('front_template',$data); 				
	}

	public function student_graph(){
		
		$data['static_summary'] = $this->Fronts_model->static_summary( $this->session->userdata('std_cardid') , $this->session->userdata('ter_id')  ,  $this->session->userdata('last_year')  );	
		
		$data['main_content']="front/student/student_graph";
		$this->load->view('front_template',$data); 				
	}

	/*
	public function render_graph(){
		
		$data['static_summary'] = $this->Fronts_model->static_summary( $this->session->userdata('std_cardid') , $this->session->userdata('ter_id')  ,  $this->session->userdata('last_year')  );	
		
		foreach ($data['static_summary'] as $item){
			print_r($item);
			exit;

			$row[0] = $item[0];
		    $row[1] = $item[1];
			$row[2] = $item[2];
			$row[3] = $item[3];
			$row[4] = $item[4];
			exit;
		    array_push($rows,$row);
		}
		print json_encode($rows, JSON_NUMERIC_CHECK);
		ChromePhp::log(1);
		exit;
	}
	*/

	public function student_notify(){
		
		$data['result'] = $this->Fronts_model->check_verify($this->session->userdata('std_cardid') , $this->session->userdata('ter_id') , $this->session->userdata('last_year'));

		$data['main_content']="front/student/student_notify";
		$this->load->view('front_template',$data); 		
	}

	public function logout(){
		
		session_unset();

		redirect('/front_login/', 'refresh');

	}

}

?>