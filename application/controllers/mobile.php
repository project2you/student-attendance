<?php
class Mobile extends CI_Controller {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->library('excel');
		$this->load->model('users_model');
		$this->load->model('Students_model');
		$this->load->model('departments_model');
		$this->load->model('Majors_model');
		$this->load->model('Statics_model');
		$this->load->model('Mobiles_model');
		$this->load->model('Verifys_model');
		$this->load->model('Years_model');
		$this->load->model('Settings_model');

		$this->load->helper('date');

    }

	public function login(){


		$query = $this->Mobiles_model->login( $_POST['username'],$_POST['password'] );
		
		//ChromePhp::log(count($query[0]));

		if (count($query[0]) > 0) {
			echo 1;
			$this->session->set_userdata('usr_id',$query[0]->usr_id);
			$this->session->set_userdata('usr_fname',$query[0]->usr_fname);
			$this->session->set_userdata('usr_email',$query[0]->usr_email);
			$this->session->set_userdata('usr_level',$query[0]->usr_level);
		}else{
			echo 0;
		}	
	}

	public function mobile_chang_password(){

		//$query = $this->Mobiles_model->chang_password( $_POST['old'],$_POST['pass1'],$_POST['pass2'] );
			
			//ChromePhp::log($_POST['pass1']." = ".$_POST['pass2']);

			if ($_POST['pass1'] != $_POST['pass2'] ){
				echo 1;
			}else{
			
				if ($_POST['oldpass'] ){

					$query = $this->Mobiles_model->login( $this->session->userdata('usr_email')  ,$_POST['oldpass'] );
				
					if (count($query[0]) > 0) {
						$data = array(
						   'usr_password' =>$_POST['pass1']
						);
							$this->Mobiles_model->update_password( $this->session->userdata('usr_id'),$data);
						echo 3;
					}else{
						echo 2;
					}
					exit;
				} 

			}
	}

	public function list_all_department(){

		$html="";
		$query = $this->Mobiles_model->list_all_department();
	
		foreach ($query as $item){

			$html .= '<li data-role="list-divider"> <span class="ui-li-count"></span></li>';
			$html .= '<li >';
			$html .= '<h3><a href="#"> แผนก : '.$item->dep_thai.'</a></h3>';
						$html .= '<p>xx</p>';
			$html .= '<p class="ui-li-aside"><strong></strong></p>';

			$html .= '</li>';
		}
		print_r($html);
		exit;
	}

	public function list_all_major(){

		$html="";

		$last_year = $this->Statics_model->last_year();	
		$data['last_year'] =$last_year[0]->id;

		$date_year =date('m');
		if ($date_year <=7 ) { $data['ter_id'] = 2 ; } else { $data['ter_id'] = 1; } 			

		$query = $this->Mobiles_model->list_major( $data['ter_id'] , $data['last_year'] );
	
		foreach ($query as $item){

			$html .= '<li data-role="list-divider"> <span class="ui-li-count"></span></li>';
			$html .= '<li >';
			$html .= '<h3><a href="#"> รหัสวิชา '.$item->maj_id.' : '.$item->maj_thai.'</a></h3>';
			$html .= '<p> คำอธิบาย : '.$item->maj_des.'</p>';
			$html .= '<p class="ui-li-aside"><strong></strong></p>';
			$html .= '</li>';
		}

		print_r($html);
		exit;
	}

	public function mobile_list_verify(){
		
		$html="";
		
		$last_year = $this->Statics_model->last_year();	
		
		$data['last_year'] =$last_year[0]->id;
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];
		
		$query = $this->Mobiles_model->list_verify( $data['ter_id'] , $data['last_year'] );
		
		foreach ($query as $item){
		
			// Check Total Verify
			$total = $this->Verifys_model->count_verify_checked( $item->v_maj_id  , $item->dep_id  , $item->ter_id  ,$item->yea_id  );
			

			$html .= '<li data-role="list-divider"> <span class="ui-li-count"></span></li>';
			$html .= '<li >';
			
			$html .= '<h3><a href="#" onclick=gotoURL("id='.$item->id.'&maj_id='.$item->v_maj_id.'&dep_id='.$item->dep_id.'&ter_id='.$item->ter_id.'&yea_id='.$item->yea_id.'&std_reg_id='.$item->std_reg_id.'");  > รหัสวิชา '.$item->maj_id.' : '.$item->maj_thai.' ( Checked :  '.$total.' Time) </a></h3>';	

			$html .= '<p><strong></strong></p>';
			$html .= '<p class="ui-li-aside"><strong> เทอม '. $item->ter_id.' / '.   $item->yea_title. '</strong></p>';
			$html .= '</li>';
		}
		
		print_r($html);
		exit;
	}

	public function add_verify(){

		$html = "";
		
		$config['total_rows'] =  $this->Verifys_model->count_all_verify_checked(  $_POST['maj_id'] ,  $_POST['yea_id']  );
		
		$config['per_page'] = 100; 
		
		//ChromePhp::log($_POST['maj_id'].' - '.$_POST['yea_id'] );
		
		$query = $this->Verifys_model->check_verify(  $config['per_page'] , $config['total_rows'] , '' , '' , $_POST['dep_id']  , $_POST['std_reg_id'] );
		
		$i=0;
		$r=1;
		
		$html .= "
		<div data-role=\"listview\" data-filter=\"true\" id=\"myList\">
		<form id=myForm> <table>"; 
		foreach ($query as $item){
			
			$html .= "  <fieldset data-role=\"controlgroup\" data-type=\"horizontal\" data-role=\"fieldcontain\"> 
						<tr>
						<td>".$r."</td>
						<td>".$item['std_cardid']."</td>
						<td>".$item['std_fname']." ".$item['std_lname']."</td>
						<td>
								<input type=hidden name=id[".$i."] value=".$item['std_cardid']." >
								<input type=radio name=myRadio[".$i."] value=1 checked/> ปรกติ 
								<input type=radio name=myRadio[".$i."] value=2 /> สาย 
								<input type=radio name=myRadio[".$i."] value=3 /> ลา 
								<input type=radio name=myRadio[".$i."] value=4 /> ขาด 
						</td>
						</tr>
						</fieldset> 
						";
			$r++;
			$i++;
		}

		$html .= "
					<input type=hidden name=maj_id value=".$_POST['maj_id']." >
					<input type=hidden name=ver_id value=".$_POST['id']." >
					<input type=hidden name=dep_id value=".$_POST['dep_id']." >
					<input type=hidden name=ter_id value=".$_POST['ter_id']." >
					<input type=hidden name=yea_title value=".$_POST['yea_id']." >
		";
		
		$html .= "</table>  </form>
		
		</div>
		
		";

		$html .= "<script>
					
				</script>";

		print_r($html);
		exit;
	}

	public function mobile_save_verify(){
		
		//$now = time();
		//$gmt = local_to_gmt($now);
		//$date_now = date('Y-d-m H:i:s',$gmt);
		$i=0;
	
			//print_r($_POST['myRadio'][$i]);

			$now = time();
			$gmt = local_to_gmt($now);
			$date_now = date('Y-m-d H:i:s',$gmt);
			
			$i=0;
			foreach($_POST['id'] as $key) {

				//Add New Data Verify
				$data = array(
				   'std_id' => $key ,
				   'ver_id' => $_POST['ver_id'] , 
				   'dep_id' => $_POST['dep_id'] ,
				   'ver_sta_id' => $_POST['myRadio'][$i] , 
				   'maj_id' =>  $_POST['maj_id'] , 
				   'ter_id' =>  $_POST['ter_id'] , 
				   'yea_title' =>  $_POST['yea_title'] , 
				   'usr_id' => $this->session->userdata('usr_id') , 
				   'log_time' => $date_now ,
				   'sitekey' => md5($date_now) ,
			);
			
			$this->Verifys_model->save_verify_checked($data);	
			$i++;
		}

		//print_r($_POST['id'][0]);
		exit;
	}

	public function mobile_statics()
	{
		$data['year'] = $this->Statics_model->list_all_year();	

		$last_year = $this->Statics_model->last_year();	
		
		$data['last_year'] =$last_year[0]->id;
		
		//กำหนด ภาคการศึกษา
		$data['term_setting'] = $this->Settings_model->term_setting();
		$data['ter_id'] = $data['term_setting'][0]["set_ter_part"];
		
		$html = "";
		$r=0;
		$i=0;

		$static_summary = $this->Statics_model->static_summary(  $data['ter_id'] ,  $last_year[0]->id );

		$html .= "
		<div data-role=\"listview\" id=\"myList\">
		<form id=myForm> <table>
		<fieldset data-role=\"controlgroup\" data-type=\"horizontal\" data-role=\"fieldcontain\"> 
						<tr>
							<td> No. </td>
							<td> ID. </td>
							<td> Title </td>
							<td> Normal</td>
							<td> Late </td>
							<td> Leave </td>
							<td> Miss </td>
						</tr>
		"; 

		foreach ($static_summary as $item  => $value ){
			
			$nor = $this->Statics_model->static_count_normal($value->id , $value->ter_id  , $value->yea_id);  

			$lat = $this->Statics_model->static_count_late($value->id , $value->ter_id  , $value->yea_id); 

			$lea = $this->Statics_model->static_count_leave($value->id , $value->ter_id  , $value->yea_id); 

			$mis = $this->Statics_model->static_count_missing($value->id , $value->ter_id  , $value->yea_id); 

			$r++;

			$html .= "  
						<tr>
							<td>".$r."</td>
							<td>".$value->maj_id."</td>
							<td>".$value->maj_thai."</td>
							<td>".$nor[0]->nor."</td>
							<td>".$lat[0]->lat."</td>
							<td>".$lea[0]->lea ." </td>
							<td>".$mis[0]->mis."</td>
						</tr>
						";
			$i++;
		}
		
		$html = $html."
		
						<tr>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
						</tr>		
		</fieldset>";
		print_r($html);
		exit;
	}

}

?>