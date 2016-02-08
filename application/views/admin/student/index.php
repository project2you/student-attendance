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

		<header><h3 class="tabs_involved"> Student Managment </h3>

		<?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'form1');
		
              echo form_open('student/index/', $attributes);
   
              //echo form_label('Search:', 'search_string');
              //echo form_input($search_string_selected);
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

		?>			

			<fieldset>
				
				<label style="width:5%;" >รหัส</label>

				<input type="text" name="search_string"  id="search_string" value="<?php echo $keyword; ?>" style="width:15%;">
				<input type="hidden" name="count_all_student" id="count_all_student" value="0" >
				

				<select name="search_cardid" class="err" style="width:21%;" >
                        <?php echo "<option value='0' selected >  *** เลือกชั้นปี ***  </option>"; 
						?>
						<?php foreach ($year as $yea):?>
                            		<?php if ($yea->id == $search_cardid ){ ?>
					                     	<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
					                <?php }else { ?>
											<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
                                   	<?php  } ?>
                         <?php endforeach;?>  
				</select>

				<select name="group_field" class="err" style="width:22%;" >
                        <?php echo "<option value='0' selected >  *** เลือกสาขา ***</option>"; ?>
						<?php foreach ($department as $dep):?>
                            		<?php if ($dep->id == $group_field ){ ?>
					                     	<?php echo "<option value='".$dep->id."' selected >".$dep->dep_thai."</option>"; ?>
					                <?php }else { ?>
											<?php	echo "<option value='".$dep->id."'  >".$dep->dep_thai."</option>"; ?>
                                   	<?php  } ?>
                         <?php endforeach;?>  
				</select>
				
				<button type="submit" form="form1" id="bnt_search_student" value="Submit">ตกลง</button>
				<button type="button" id="bnt_clear" value="Clear">ยกเลิก</button>

			</fieldset>
			<?php echo form_close(); ?>
		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr>
					<th style="width:5%;" > <input type="checkbox" id="selecctall"/> </th> 
    				<th style="width:15%;" >ID.</th> 
    				<th style="width:15%;" >Name</th> 
					<th style="width:15%;" >Surname</th> 
    				<th style="width:15%;">Department</th> 
					<th style="width:10%;" >Year</th> 
					<th style="width:20%;">Action</th> 
				</tr> 
			</thead> 
		
			<tbody> 
                    <?php  
						$i=1; 
						foreach ($query as $item):
					?>
						<tr>
							<td class="align-center"> 

								<input class="checkbox1" type="checkbox" name="del_std_id[]" value="<?php echo $item['std_id']; ?>">

							</td>

							<td><?php echo $item['std_cardid']; ?></td>
							<td><?php echo $item['std_fname']; ?>  </td>
							<td><?php echo $item['std_lname']; ?> </td>
							<td><?php echo $item['dep_thai']; ?></td>
							<td><?php echo $item['yea_title']; ?></td>
							<td>

								<a href="<?php echo base_url()."student/add_student/"; ?>" class="table-icon delete" title="Block">
									<input type="image" src="<?php echo base_url();?>assets/images/icn_add_new.png" title="Block">
								</a>

								<a href="<?php echo  base_url()."student/edit_student/".$item['std_id']; ?>" class="table-icon edit" title="Edit"> 
										<input type="image" src="<?php echo base_url();?>assets/images/icn_edit.png" title="Edit" >
								</a>

								<input type="image" src="<?php echo base_url();?>assets/images/icn_trash.png" title="Trash" onclick="confirmDeleteStudent(<?php echo $item['std_id']; ?>,'student/delete_student')" >

							</td> 
						</tr>
					<?php $i++; endforeach;?>    

			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
			
		

		</div><!-- end of .tab_container -->
		

		<footer>
				<div class="submit_link">
						<form action="<?php echo base_url();?>student/view_import" method="post" enctype="multipart/form-data" />
						<label style="width:10%;" >นำเข้าไฟล์  Excel </label>
						<input type="file" name="userfile" />
						<input type="submit" value="Upload File" class="alt_btn">
						</form>
				</div>
		</footer>

		</article><!-- end of content manager article -->
		
			

		<div class="clear"></div>
		
		<br>

		<section>
			<nav role="navigation">
				<?php 
					if ($this->session->userdata('flag_student') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_student; ?>
		<?php //echo 	$this->session->userdata('last_query'); ?>