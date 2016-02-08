<form action="<?php echo base_url();?>verify/save_verify" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Add New Data </h4>
	
	<article class="module width_full">
			<header><h3>เพิ่มข้อมูลรายวิชา</h3></header>
				<div class="module_content">
					
						<fieldset>
							<label style="width:14%;" >รหัสรายวิชา</label>
							<input  type="hidden" name="maj_id"  id="maj_id" style="width:20%;" value="" data-validation="required" >
							<input  type="text" name="maj_detail"  id="maj_detail" style="width:20%;" placeholder=" ใส่รหัสรายวิชา ..."  data-validation="required" >

							<input type="image" id="list_major" src="<?php echo base_url();?>assets/images/list_major.png" width="24px" title="Block">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ปีการศึกษา</label>
							<select name="yea_id" class="err">
													<?php foreach ($year as $yea):?>
														<?php if ($sec->id == $item->sec_id ){ ?>
																<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
														   <?php }else { ?>
																		<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
															<?php  } ?>
														<?php endforeach;?>  
							</select>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >เทอม</label>
							<input type="text" name="ter_id" id="ter_id" style="width:20%;" placeholder="1" data-validation="required" value="<?php echo $ter_id;?>">
						</fieldset>


						<fieldset>
							<label style="width:14%;" >สาขา/แผนก</label>
							<select name="dep_id" class="err">
									<?php foreach ($department as $dep):?>
											<?php if ($dep->id == $item->dep_id ){ ?>
														<?php echo "<option value='".$dep->id."' selected >".$dep->dep_thai."</option>"; ?>
												   <?php }else { ?>
														<?php	echo "<option value='".$dep->id."'  >".$dep->dep_thai."</option>"; ?>
											<?php  } ?>
									<?php endforeach;?>  
							</select>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >รหัสปี/นักศึกษา</label>
							<select name="std_reg_id" class="err">
													<?php foreach ($year as $yea):?>
														<?php if ($sec->id == $item->sec_id ){ ?>
																<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
														   <?php }else { ?>
																		<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
															<?php  } ?>
														<?php endforeach;?>  
							</select>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >จำนวนครั้งที่สอน</label>
							<input type="text" name="total_study" id="total_study" style="width:20%;" placeholder="16" data-validation="required" value="16">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >สายไม่เกิน/ครั้ง</label>
							<input type="text" name="min_late" id="min_late" style="width:20%;" placeholder="3" data-validation="required" value="3">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ลาไม่เกิน/ครั้ง</label>
							<input type="text" name="min_leave" id="min_leave" style="width:20%;" placeholder="3" data-validation="required" value="3">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ขาดไม่เกิน/ครั้ง</label>
							<input type="text" name="min_missing" id="min_missing" style="width:20%;" placeholder="3" data-validation="required" value="3">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ข้อความแจ้งเตือน</label>
							<input type="text" name="msg_alert" id="msg_alert" style="width:20%;" data-validation="required" value="กรุณาติดต่ออาจารย์ประจำวิชา">
						</fieldset>


			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>verify/index/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
</form>

		<div id="list_major_select" style="display:none; cursor: default"> 
				<header>
					<h2 class="tabs_involved"> <img src="<?php echo base_url();?>assets/images/icn_export.png"> เลือกรายการวิชา </h2>
				</header>			

				
						<label style="width:10%;">เลือกสาขา </label>

							<select id="mySelect" class="err" multiple>
													<?php foreach ($list_major as $maj):?>
													<?php	echo "<option value='".$maj->id."'  >".$maj->id.':'.$maj->maj_id.' :'.$maj->maj_thai."</option>"; ?>
													<?php endforeach;?>  
							</select>

						<p></p>
						<input type="button" id="yes_list_major" value="Ok" class="alt_btn">
						<input type="button" id="no_list_major" value="Cancel" class="alt_btn">

						
				<p></p>
		</div> 


<script> $.validate(); </script>
