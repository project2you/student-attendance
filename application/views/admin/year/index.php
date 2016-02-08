<section id="main" class="column">

		<?php

		if($this->session->flashdata('message') != ''){
			 
			 echo '<h4 class="alert_success">'.$this->session->flashdata('message').' </h4>';
		}

		?>
		
		<article class="module width_full">

		<header><h3 class="tabs_involved"> Year </h3>


		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" >ลำดับ.</th> 
					<th style="width:15%;" >ปีการศึกษา</th> 
					<th style="width:50%;" >เมนู.</th>  
				</tr> 
			</thead> 
		
			<tbody> 
                    <?php  $i=1; foreach ($query as $item):?>
						<tr>
							<td class="align-center"><?php echo $item['id']; ?></td>
							<td><?php echo $item['yea_title']; ?>  </td>
							<td>
								<a href="<?php echo base_url()."year/add_year/"; ?>" class="table-icon delete" title="Block">
									<input type="image" src="<?php echo base_url();?>assets/images/icn_add_new.png" title="Block">
								</a>

								<a href="<?php echo  base_url()."year/edit_year/".$item['id']; ?>" class="table-icon edit" title="Edit"> 
										<input type="image" src="<?php echo base_url();?>assets/images/icn_edit.png" title="Edit" >
								</a>

								<input type="image" src="<?php echo base_url();?>assets/images/icn_trash.png" title="Trash" onclick="confirmDelete(<?php echo $item['id']; ?>,'year/delete_year')" >

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
					if ($this->session->userdata('flag_year') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_year; ?>