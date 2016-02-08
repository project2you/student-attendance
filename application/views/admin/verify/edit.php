<form action="<?php echo base_url();?>verify/update_verify" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Edit Data </h4>
	
	<article class="module width_full">
			<header><h3>แก้ไขรายวิชา</h3></header>
				<div class="module_content">


						<fieldset>
							<label style="width:14%;" >รหัสรายวิชา</label>
							<input  type="hidden" name="maj_id" id="maj_id" value="<?php echo $query[0]->maj_id ;?>" style="width:20%;" data-validation="required" >
							
							<input  type="text" name="maj_detail"  id="maj_detail" value="<?php echo $query[0]->maj_detail ;?>" style="width:20%;" data-validation="required" disabled>

							<INPUT TYPE="hidden" NAME="ver_id" VALUE="<?php echo $id;?>">

						</fieldset>

						<fieldset>
							<label style="width:14%;" >ปีการศึกษา</label>
							<select name="yea_id" class="err">
													<?php foreach ($year as $yea):?>
														<?php if ($yea->id == $query[0]->yea_id ){ ?>
																<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
														   <?php }else { ?>
																		<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
															<?php  } ?>
														<?php endforeach;?>  
							</select>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >เทอม</label>
							<input type="text" name="ter_id" id="ter_id" value="<?php echo $query[0]->ter_id ;?>" style="width:20%;" data-validation="required"  >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >สาขา/แผนก</label>
							<select name="dep_id" class="err">
									<?php foreach ($department as $dep):?>
											<?php if ($dep->id == $query[0]->dep_id ){ ?>
														<?php echo "<option value='".$dep->id."' selected >".$dep->dep_thai."</option>"; ?>
												   <?php }else { ?>
														<?php	echo "<option value='".$dep->id."'  >".$dep->dep_thai."</option>"; ?>
											<?php  } ?>
									<?php endforeach;?>  
							</select>
						</fieldset>


						<fieldset>
							<label style="width:14%;" >รหัสปี/นักศึกษา</label>
							<select name="yea_id" class="err">
													<?php foreach ($year as $yea):?>
														<?php if ($yea->id == $query[0]->std_reg_id ){ ?>
																<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
														   <?php }else { ?>
																		<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
															<?php  } ?>
														<?php endforeach;?>  
							</select>
						</fieldset>


						<fieldset>
							<label style="width:14%;" >จำนวนครั้งที่สอน</label>
							<input type="text" name="total_study" id="total_study" value="<?php echo $query[0]->total_study ;?>" style="width:20%;" data-validation="required"  >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >สถานะต่ำสุด/มาสาย</label>
							<input type="text" name="min_late" id="min_late" value="<?php echo $query[0]->min_late ;?>" style="width:20%;" data-validation="required"  >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >สถานะต่ำสุด/การลา</label>
							<input type="text" name="min_leave" id="min_leave" value="<?php echo $query[0]->min_leave ;?>" style="width:20%;" data-validation="required"  >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >สถานะต่ำสุด/ขาดเรียน</label>
							<input type="text" name="min_missing" id="min_missing" value="<?php echo $query[0]->min_missing ;?>" style="width:20%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ข้อความแจ้งเตือน</label>
							<input type="text" name="msg_alert" id="msg_alert" value="<?php echo $query[0]->msg_alert ;?>" style="width:20%;" data-validation="required" >
						</fieldset>

			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>verify/list_major/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
</form>


<script> $.validate(); </script>

