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

		<?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'form1');
		
              echo form_open('verify/list_major/', $attributes);
   
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

		?>			

			<fieldset>
				
				<label style="width:10%;" >รหัสวิชา</label>

				<input type="text" name="search_string"  id="search_string" value="<?php echo $keyword; ?>" style="width:15%;">
				<input type="hidden" name="count_all_verify" id="count_all_verify" value="0" >
				
				<select name="group_field" class="err" style="width:20%;" >
                        <?php echo "<option value='0' selected > *  สาขา/แผนก *  </option>"; ?>
						<?php foreach ($department as $dep):?>

                            		<?php if ($dep->id == $group_field ){ ?>
					                     	<?php echo "<option value='".$dep->id."' selected >".$dep->dep_thai."</option>"; ?>
					                <?php }else { ?>
											<?php	echo "<option value='".$dep->id."'  >".$dep->dep_thai."</option>"; ?>
                                   	<?php  } ?>

                         <?php endforeach;?>  
				</select>
				


				<select name="search_year" class="err" style="width:18%;" >
                        <?php echo "<option value='0' selected > * ปีการศึกษา *</option>"; 
						?>
						<?php foreach ($year as $yea):?>
                            		<?php if ($yea->id == $search_cardid ){ ?>
					                     	<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
					                <?php }else { ?>
											<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
                                   	<?php  } ?>
                         <?php endforeach;?>  
				</select>


				<button type="submit" form="form1" id="bnt_search_verify" value="Submit">ตกลง</button>
				<button type="button" id="bnt_clear_verify" value="Clear">ยกเลิก</button>

			</fieldset>
			<?php echo form_close(); ?>
		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" >No.</th> 
    				<th style="width:15%;" >รหัสวิชา</th> 
					<th style="width:20%;" >ชื่อวิชา</th> 
    				<th style="width:20%;">สาขา/แผนก</th> 
    				<th style="width:8%;" >ชั้นปี.</th>  
    				<th style="width:8%;" >เทอม/ปี.</th>  
					<th style="width:15%;">Action</th> 
				</tr> 
			</thead> 
		
			<tbody> 
                    <?php  $i=1; foreach ($query as $item):?>
						<tr>
							<td class="align-center"><?php echo $i; ?></td>
							<td><?php echo $item['maj_detail']; ?>  </td>
							<td><?php echo $item['maj_thai']; ?> </td>
							<td> <?php echo $item['dep_thai'];  ?> </td>
							<td><?php print_r($this->Years_model->check_year($item['std_reg_id'])); ?></td>
							<td><?php echo $item['ter_id']." / ".$item['yea_title']; ?></td>
							<td>

								<a href="<?php echo base_url()."verify/add_new/"; ?>" class="table-icon delete" title="Block">
									<input type="image" src="<?php echo base_url();?>assets/images/icn_add_new.png" title="Block">
								</a>

								<a href="<?php echo  base_url()."verify/edit_verify/".$item['ver_id']; ?>" class="table-icon edit" title="Edit"> 
									<input type="image" src="<?php echo base_url();?>assets/images/icn_edit.png" title="Edit" >
								</a>

								<input type="image" src="<?php echo base_url();?>assets/images/icn_trash.png" title="Trash" onclick="confirmDelete(<?php echo $item['ver_id']; ?>,'verify/delete_verify')" >

							</td> 
						</tr>
					<?php $i++; endforeach;?>    

			</tbody> 
			</table>

			<?php if (count($query) == 0  ) {  ?>
				<br>
					<div> <center>
						<a href="<?php echo  base_url()."verify/add_new/"; ?>" class="table-icon edit" title="Edit"> 
							<input type="image" src="<?php echo base_url();?>assets/images/icn_add_new.png" title="Block">
							<br> เพิ่มรายการใหม่
						</a>
					</center> </div> 

			<?php } ?>
			</div><!-- end of #tab1 -->
			
			

		<footer>
				
		</footer>

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

		<?php //echo $this->session->flashdata('total_rows');//$count_all_verify; ?>
