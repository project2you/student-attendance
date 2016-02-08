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

		<header><h3 class="tabs_involved"> Major </h3>

		<?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'form1');
		
              echo form_open('major/index/', $attributes);
   
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

		?>			

			<fieldset>
				
				<label style="width:10%;" >รหัสวิชา</label>
				<input type="text" name="search_string"  id="search_string" value="<?php echo $keyword; ?>" style="width:20%;">
				<input type="hidden" name="count_all_major" id="count_all_major" value="0" >
				

				<label style="width:10%;" >ภาคเรียน</label>
				<input type="text" name="search_term"  maxlength="1" id="search_term" value="<?php echo $search_term; ?>" style="width:5%;">
				
				<label style="width:2%;" >ปี</label>
				<select name="group_field" class="err" style="width:10%;" >
                        <?php echo "<option value='0' selected >* ปี *</option>"; ?>
						<?php foreach ($year as $yea):?>
                            		<?php if ($yea->id == $group_field ){ ?>
					                     	<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
					                <?php }else { ?>
											<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
                                   	<?php  } ?>
                         <?php endforeach;?>  
				</select>

				<button type="submit" form="form1" id="bnt_search_major" value="Submit">ตกลง</button>
				<button type="button" id="bnt_clear_major" value="Clear">ยกเลิก</button>

			</fieldset>


			<?php echo form_close(); ?>
		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" > <input type="checkbox" id="selecctall"/> </th> 
    				<th style="width:7%;" >รหัสวิชา</th> 
					<th style="width:15%;" >ชื่อวิชา</th> 
    				<th style="width:5%;">หน่วยกิจ</th> 
    				<th style="width:5%;" >เทอม.</th>  
					<th style="width:5%;" >ปี.</th>  
    				<th style="width:10%;">สาขา/แผนก</th> 
					<th style="width:10%;" >เมนู.</th>  
				</tr> 
			</thead> 
		
			<tbody> 
                    <?php  $i=1; foreach ($query as $item):?>
						<tr>
							<td class="align-center"> 
								<input class="checkbox1" type="checkbox" name="del_std_id[]" value="<?php echo $item['id']; ?>">
							</td>

							<td><?php echo $item['maj_id']; ?>  </td>
							<td><?php echo $item['maj_thai']; ?> </td>
							<td> <?php echo $item['maj_unit'];  ?> </td>
							<td><?php echo $item['maj_term']; ?></td>
							<td><?php echo $item['yea_title']; ?></td>
							<td><?php echo $item['dep_thai']; ?></td>

							<td>
								<a href="<?php echo base_url()."major/add_major/"; ?>" class="table-icon delete" title="Block">
									<input type="image" src="<?php echo base_url();?>assets/images/icn_add_new.png" title="Block">
								</a>

								<a href="<?php echo  base_url()."major/edit_major/".$item['id']; ?>" class="table-icon edit" title="Edit"> 
										<input type="image" src="<?php echo base_url();?>assets/images/icn_edit.png" title="Edit" >
								</a>

								<input type="image" src="<?php echo base_url();?>assets/images/icn_trash.png" title="Trash" onclick="confirmDeleteMajor(<?php echo $item['id']; ?>,'major/delete_major')" >

							</td> 
						</tr>
					<?php endforeach;?>    

			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->
		
			<footer>
				<div class="submit_link">
						<form action="<?php echo base_url();?>major/view_import" method="post" enctype="multipart/form-data" />
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
					if ($this->session->userdata('flag_major') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_major; ?>

