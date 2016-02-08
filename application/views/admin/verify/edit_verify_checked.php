
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

		<header><h3 class="tabs_involved"> Verify Managment </h3>

		<ul class="tabs">
   			<li><a href="#tab1">List Data</a></li>
    		<li><a href="#tab2">Calendar</a></li>
		</ul>

		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" >No.</th> 
    				<th style="width:15%;" >วัน / เดือน / ปี </th> 
    				<th style="width:10%;" > <center>  ปรกติ  </center> </th> 
    				<th style="width:10%;" > <center>  มาสาย </center> </th> 
    				<th style="width:10%;" > <center>  ลา  </center> </th> 
    				<th style="width:10%;" > <center>  ขาดเรียน </center> </th> 

					<th style="width:20%;">Action</th> 
				</tr> 
			</thead> 
		
			<tbody> 

                    <?php  
						$i=1; $count_normal=0;  $count_late=0;  $count_leaves=0;  $count_missing=0;  	
						foreach ($query as $key => $value):
					?>

						<tr>
							<td class="align-center"><?php echo $i; ?></td>
							<td><?php echo $value->log_time; ?>  </td>

							<td><center><?php  
									$normal = $this->Verifys_model->count_all_normal( $value->sitekey );  
									echo $normal[0]['normal']; 
									$count_normal = $count_normal +$normal[0]['normal']; 
								?>  
							</center></td>

							<td><center><?php 
									$late = $this->Verifys_model->count_all_late( $value->sitekey );  
									echo $late[0]['late']; 
									$count_late = $count_late + $late[0]['late']; 
								?>  
							</center></td>

							<td><center><?php 
									$leaves = $this->Verifys_model->count_all_leaves( $value->sitekey );  
									echo $leaves[0]['leaves']; 
									$count_leaves = $count_leaves +$leaves[0]['leaves']; 
								?>  
							</center></td>

							<td><center><?php 
									$missing = $this->Verifys_model->count_all_missing( $value->sitekey);  
									echo $missing[0]['missing']; 
									$count_missing = $count_missing +$missing[0]['missing']; 
								?> 
							</center></td>

							<td>
								<a href="<?php echo base_url()."verify/detail_verify_checked/".$value->sitekey; ?>" class="table-icon delete" title="Block">
									<input type="image" src="<?php echo base_url();?>assets/images/icon_view.png" title="Block">
								</a>
								
								<input type="image" src="<?php echo base_url();?>assets/images/icn_trash.png" title="ลบรายการข้อมูล" onclick="confirmDelete('<?php echo $value->sitekey; ?>','verify/delete_verify_all_checked')" >

							</td> 

						</tr>
					<?php $i++; endforeach;?>    
						
						<thead> 
						<tr>
							<td class="align-center"> </td>
							<td><b>	สรุปผลรวม   </b></td>

							<td>	<center> <?php echo $count_normal; ?> </center> </td>

							<td>	<center> <?php echo $count_late; ?> </center> </td>

							<td>	<center> <?php echo $count_leaves; ?> </center> </td>

							<td>	<center> <?php echo $count_missing; ?> </center> </td>

							<td>	</td> 

						</tr>
						<thead> 
			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
			
			<div id="tab2" class="tab_content">


					<div id="calendar" style="width: auto; margin: 0 auto">
					
					</div>
					
			</div><!-- end of #tab2 -->

		</div><!-- end of .tab_container -->
		
		<footer>

				<div class="submit_link">
						<input type="button" id="bnt_reload" onclick="window.location.reload();" value="Refresh" class="alt_btn">
						<input type="button" id="bnt_export_verify" onclick="window.location.replace('<?php echo base_url().'verify/export_verify_checked/'.$maj_id."/".$dep_id."/".$ter_id."/".$yea_id."'"; ?>);" value="ส่งออกไฟล์ Excel" class="alt_btn">
						</form>
				</div>
				
		</footer>

		</article><!-- end of content manager article -->
		
			

		<div class="clear"></div>
		
		<br>

		<section>
			<nav role="navigation">
				<?php 
					if ($this->session->userdata('flag') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_verify; ?>