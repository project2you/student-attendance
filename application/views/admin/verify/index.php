<section id="main" class="column">
		
		<?php

		if($this->session->flashdata('message') != ''){
			 
			 echo '<h4 class="alert_success">'.$this->session->flashdata('message').' </h4>';
		}

		?>
		
	
		<!-- 
		<article class="module width_full">
			<header><h3>Stats</h3></header>
			<div class="module_content">
			
				<div class="clear"></div>
			</div>
		</article>
		end of stats article -->
		
		<article class="module width_full">

		<header>
			<h3 class="tabs_involved"> Verify Managment </h3>
		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">

			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" ></th> 
    				<th style="width:20%;" >รายวิชาสอน.</th> 
    				<th style="width:20%;" >เช็คประวัติ.</th> 
    				<th style="width:20%;" >ปฏิทินข้อมูล</th> 

					<!-- Hide of 
    				<th style="width:20%;" >นำเข้าไฟล์ Excel</th> 
    				<th style="width:20%;" >ตัวอย่างไฟล์ .xls</th> 
					#Menu -->

				</tr> 
			</thead> 
			<tr>

					<td class="align-center"> </td>
					<td class="align-center"> 
						<a href="<?php echo base_url()."verify/list_major/"; ?>" class="table-icon delete" title="Block">
							<input type="image" id="verify_add" src="<?php echo base_url();?>assets/images/verify_add.png" title="Add New" > 
						</a>

					</td>
						
					<td class="align-center" > 
						<a href="<?php echo base_url()."verify/list_verify/"; ?>" class="table-icon delete" title="Block">
							<input type="image" src="<?php echo base_url();?>assets/images/verify_edit.png" title="Edit" > 
						</a>
					
					</td>
					
					 
					<td class="align-center"> 

						<a href="<?php echo base_url()."verify/calendar/"; ?>" class="table-icon delete" title="Block">
							<input type="image" src="<?php echo base_url();?>assets/images/event-search-icon.png" title="Edit" > 
						</a>

					</td>
					
					<!-- Hide of 
					<td class="align-center"> 
						<input type="image" id="icon_import_verify" src="<?php echo base_url();?>assets/images/verify_export.png" title="Edit" >  
					</td>

					<td class="align-center"> 
						<input type="image" src="<?php echo base_url();?>assets/images/help.png" title="Help" > 
					</td>
					#Menu -->

			<tr>							
			</tbody>
			</table>

			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->
		

		<footer>

		</footer>
		

		</article><!-- end of content manager article -->
		
			

		<div class="clear"></div>

		<br>

		<section>
			<nav role="navigation">

			</nav>

		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_student; ?>
		<?php //echo 	$this->session->userdata('last_query'); ?>

		<div id="import_verify" style="display:none; cursor: default"> 
				<header>
					<h2 class="tabs_involved"> <img src="<?php echo base_url();?>assets/images/icn_export.png"> นำเข้าข้อมูลไฟล์ Excel </h2>
				</header>			

				<form action="<?php echo base_url();?>verify/import_verify" method="post" enctype="multipart/form-data">
						<label style="width:10%;">นำเข้าไฟล์  Excel </label>
						<input type="file" name="userfile">
						<p></p>
						<input type="submit" value="Upload File" class="alt_btn">
						<input type="button" id="no_import" value="Cancel" class="alt_btn">
				</form>
						
				<p></p>
		</div> 

