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

		<header><h3 class="tabs_involved"> Department </h3>

		<?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'form1');
		
              echo form_open('department/index/', $attributes);
   
              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

		?>			

			<fieldset>
				
				<label style="width:15%;" >รหัสแผนก</label>

				<input type="text" name="search_string"  id="search_string" value="<?php echo $keyword; ?>" style="width:20%;">
				<input type="hidden" name="count_all_department" id="count_all_department" value="0" >
				
				<button type="submit" form="form1" id="bnt_search_department" value="Submit">ตกลง</button>
				<button type="button" id="bnt_clear_department" value="Clear">ยกเลิก</button>

			</fieldset>
			<?php echo form_close(); ?>
		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" >No.</th> 
    				<th style="width:15%;" >dep_id</th> 
					<th style="width:15%;" >dep_eng</th> 
    				<th style="width:20%;">dep_thai</th> 
					<th style="width:15%;" >Menu.</th>  
				</tr> 
			</thead> 
		
			<tbody> 
                    <?php  $i=1; foreach ($query as $item):?>
						<tr>
							<td class="align-center"><?php echo $item['id']; ?></td>
							<td><?php echo $item['dep_id']; ?>  </td>
							<td><?php echo $item['dep_eng']; ?> </td>
							<td> <?php echo $item['dep_thai'];  ?> </td>
							<td>
								<a href="<?php echo base_url()."department/add_department/"; ?>" class="table-icon delete" title="Block">
									<input type="image" src="<?php echo base_url();?>assets/images/icn_add_new.png" title="Block">
								</a>

								<a href="<?php echo  base_url()."department/edit_department/".$item['id']; ?>" class="table-icon edit" title="Edit"> 
										<input type="image" src="<?php echo base_url();?>assets/images/icn_edit.png" title="Edit" >
								</a>

								<input type="image" src="<?php echo base_url();?>assets/images/icn_trash.png" title="Trash" onclick="confirmDelete(<?php echo $item['id']; ?>,'department/delete_department')" >

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
					if ($this->session->userdata('flag_department') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_department; ?>