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

		<header><h3 class="tabs_involved"> User Managment </h3>

		<?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'form1');
		
              echo form_open('user/index/', $attributes);
   
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

		?>			

			<fieldset>
				
				<label style="width:15%;" >ค้นหาอีเมล์</label>

				<input type="text" name="search_string"  id="search_string" value="<?php echo $keyword; ?>" style="width:20%;">
				<input type="hidden" name="count_all_user" id="count_all_user" value="0" >
				
				<label style="width:5%;" >แผนก</label>

				<select name="group_field" class="err" style="width:25%;" >
                        <?php echo "<option value='0' selected >  *** กรุณาเลือกแผนก ***</option>"; ?>
						<?php foreach ($department as $dep):?>

                            		<?php if ($dep->id == $group_field ){ ?>
					                     	<?php echo "<option value='".$dep->id."' selected >".$dep->dep_thai."</option>"; ?>
					                <?php }else { ?>
											<?php	echo "<option value='".$dep->id."'  >".$dep->dep_thai."</option>"; ?>
                                   	<?php  } ?>

                         <?php endforeach;?>  
				</select>
				
				<button type="submit" form="form1" id="bnt_search_user" value="Submit">ตกลง</button>
				<button type="button" id="bnt_clear_user" value="Clear">ยกเลิก</button>

			</fieldset>
			<?php echo form_close(); ?>
		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" >No.</th> 
    				<th style="width:15%;" >Name</th> 
					<th style="width:15%;" >Surname</th> 
    				<th style="width:20%;">Department</th> 
    				<th style="width:15%;" >Email.</th>  
					<th style="width:20%;">Action</th> 
				</tr> 
			</thead> 
		
			<tbody> 
                    <?php  $i=1; foreach ($query as $item):?>
						<tr>
							<td class="align-center"><?php echo $item['usr_id']; ?></td>
							<td><?php echo $item['usr_fname']; ?>  </td>
							<td><?php echo $item['usr_lname']; ?> </td>
							<td> <?php if ($item['usr_department'] == 0) { echo "ผู้ดูแลระบบ"; } else { echo $item['dep_thai']; }  ?> </td>
							<td><?php echo $item['usr_email']; ?></td>
							<td>

								<a href="<?php echo base_url()."user/add_user/"; ?>" class="table-icon delete" title="Block">
									<input type="image" src="<?php echo base_url();?>assets/images/icn_add_new.png" title="Block">
								</a>

								<a href="<?php echo  base_url()."user/edit_user/".$item['usr_id']; ?>" class="table-icon edit" title="Edit"> 
										<input type="image" src="<?php echo base_url();?>assets/images/icn_edit.png" title="Edit" >
								</a>

								<input type="image" src="<?php echo base_url();?>assets/images/icn_trash.png" title="Trash" onclick="confirmDelete(<?php echo $item['usr_id']; ?>,'user/delete_user')" >

							</td> 
						</tr>
					<?php endforeach;?>    

			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
			
		

		</div><!-- end of .tab_container -->
		
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

		<?php //echo $this->session->flashdata('total_rows');//$count_all_user; ?>
		<?php //echo 	$this->session->userdata('last_query'); ?>