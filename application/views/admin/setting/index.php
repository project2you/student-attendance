<section id="main" class="column">
		
		<!-- 
		<article class="module width_full">
			<header><h3>Stats</h3></header>
			<div class="module_content">
			
				<div class="clear"></div>
			</div>
		</article>
		end of stats article -->
		
		<?php

		if($this->session->flashdata('message') != ''){
			 
			 echo '<h4 class="alert_success">'.$this->session->flashdata('message').' </h4>';
		}

		?>

		<article class="module width_full">

		<header><h3 class="tabs_involved"> Setting </h3>

		</header>

		<form action="<?php echo base_url();?>setting/save_setting" method="post" enctype="multipart/form-data" />
		
		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:8%;" >No.</th> 
    				<th style="width:12%;" >ชื่อ.</th> 
    				<th style="width:8%;" >สถิติ</th> 
					<th style="width:8%;" >ปฏิทิน</th> 
    				<th style="width:10%;">เช็คประวัติ</th> 
					<th style="width:8%;" >รายวิชา.</th> 
    				<th style="width:8%;">นักศึกษา</th> 
					<th style="width:8%;" >ผู้ใช้ระบบ.</th> 
					<th style="width:8%;" >ภาคเรียน.</th> 
    				<th style="width:8%;">กำหนดค่า</th> 
					<th style="width:8%;" >สิทธิ์เข้าถึง.</th> 

					
				</tr> 
			</thead> 
		
			<tbody> 
						<tr>
							<td class="align-center"> 1. </td>
							<td class="align-center"> Administrator </td>

							<td> <INPUT TYPE="checkbox" NAME="admin[1]" value="1" <?php if ($setting[0]['set_mnu1'] == 1 ) { echo 'checked'; } ?> > </td>
							<td><INPUT TYPE="checkbox" NAME="admin[2]" value="1" <?php if ($setting[0]['set_mnu2'] == 1 ) { echo 'checked'; } ?> > </td>
							<td> <INPUT TYPE="checkbox" NAME="admin[3]" value="1" <?php if ($setting[0]['set_mnu3'] == 1 ) { echo 'checked'; } ?> > </td>
							<td> <INPUT TYPE="checkbox" NAME="admin[4]" value="1" <?php if ($setting[0]['set_mnu4'] == 1 ) { echo 'checked'; } ?>></td> 
							<td> <INPUT TYPE="checkbox" NAME="admin[5]" value="1" <?php if ($setting[0]['set_mnu5'] == 1 ) { echo 'checked'; } ?>></td> 
							<td> <INPUT TYPE="checkbox" NAME="admin[6]" value="1" <?php if ($setting[0]['set_mnu6'] == 1 ) { echo 'checked'; } ?>></td> 
							<td> <INPUT TYPE="checkbox" NAME="admin[7]" value="1" <?php if ($setting[0]['set_mnu7'] == 1 ) { echo 'checked'; } ?>></td> 
							<td> <INPUT TYPE="checkbox" NAME="admin[8]" value="1" <?php if ($setting[0]['set_mnu8'] == 1 ) { echo 'checked'; } ?>></td> 
							<td> <INPUT TYPE="checkbox" NAME="admin[9]" value="1" <?php if ($setting[0]['set_mnu9'] == 1 ) { echo 'checked'; } ?>></td> 

						</tr>

						<tr>
							<td class="align-center"> 2. </td>
							<td class="align-center"> Teachnical </td>
							<td> <INPUT TYPE="checkbox" NAME="tech[1]" value="1" <?php if ($setting[1]['set_mnu1'] == 1 ) { echo 'checked'; } ?> > </td>
							<td><INPUT TYPE="checkbox" NAME="tech[2]" value="1" <?php if ($setting[1]['set_mnu2'] == 1 ) { echo 'checked'; } ?>> </td>
							<td> <INPUT TYPE="checkbox" NAME="tech[3]" value="1" <?php if ($setting[1]['set_mnu3'] == 1 ) { echo 'checked'; } ?> > </td>
							<td> <INPUT TYPE="checkbox" NAME="tech[4]" value="1" <?php if ($setting[1]['set_mnu4'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="tech[5]" value="1" <?php if ($setting[1]['set_mnu5'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="tech[6]" value="1" <?php if ($setting[1]['set_mnu6'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="tech[7]" value="1" <?php if ($setting[1]['set_mnu7'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="tech[8]" value="1" <?php if ($setting[1]['set_mnu8'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="tech[9]" value="1" <?php if ($setting[1]['set_mnu9'] == 1 ) { echo 'checked'; } ?> ></td> 

						</tr>

						<tr>
							<td class="align-center"> 3. </td>
							<td class="align-center"> User </td>
							<td> <INPUT TYPE="checkbox" NAME="user[1]" value="1" <?php if ($setting[2]['set_mnu1'] == 1 ) { echo 'checked'; } ?> > </td>
							<td><INPUT TYPE="checkbox" NAME="user[2]" value="1" <?php if ($setting[2]['set_mnu2'] == 1 ) { echo 'checked'; } ?> > </td>
							<td> <INPUT TYPE="checkbox" NAME="user[3]" value="1" <?php if ($setting[2]['set_mnu3'] == 1 ) { echo 'checked'; } ?>> </td>
							<td> <INPUT TYPE="checkbox" NAME="user[4]" value="1" <?php if ($setting[2]['set_mnu4'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="user[5]" value="1" <?php if ($setting[2]['set_mnu5'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="user[6]" value="1" <?php if ($setting[2]['set_mnu6'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="user[7]" value="1" <?php if ($setting[2]['set_mnu7'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="user[8]" value="1" <?php if ($setting[2]['set_mnu8'] == 1 ) { echo 'checked'; } ?> ></td> 
							<td> <INPUT TYPE="checkbox" NAME="user[9]" value="1" <?php if ($setting[2]['set_mnu9'] == 1 ) { echo 'checked'; } ?> ></td> 

						</tr>

			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
			
		

		<footer>
				<div class="submit_link">
						<input type="submit" id="submit_save" value="บันทึกข้อมูล" class="alt_btn">
						</form>
				</div>
		</footer>


		</article><!-- end of content manager article -->
		
		<div class="clear"></div>
		
		<br>

		<section>
			<nav role="navigation">

				
			</nav>
		</section>