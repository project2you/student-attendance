<section id="main" class="column">
		
		<h4 class="alert_info">Add New Major </h4>
	
			<article class="module width_full">
				<header><h3>เพิ่มรายวิชา</h3></header>

				<form action="<?php echo base_url();?>major/save_major" method="post" enctype="multipart/form-data" />

				<div class="module_content">

						<fieldset>
							<label style="width:14%;" >รหัสรายวิชา</label>
							<input  type="text" name="maj_id"  id="maj_id" style="width:20%;" data-validation="required" >
							<label id="check_maj_id" style="width:14%;" ></label>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อภาษาไทย</label>
							<input type="text" name="maj_thai" id="maj_thai"  maxlength="100" style="width:50%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อภาษาอังกฤษ</label>
							<input type="text" name="maj_eng" id="maj_eng" maxlength="100" style="width:50%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >คำอธิบายรายวิชา</label>
							<TEXTAREA NAME="maj_des" ROWS="5" COLS="10"style="width:50%;"> </TEXTAREA>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >หน่วยกิจ</label>
							<input type="text" name="maj_unit" id="maj_unit" maxlength="1" style="width:10%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ภาคเรียน</label>
							<input type="text" name="maj_term" id="maj_term" maxlength="1" style="width:10%;" data-validation="required" >
						</fieldset>

						<fieldset>
						<label style="width:14%;" >สาขา/แผนก</label>
						<select name="dep_id" class="err" style="width:20%;"  data-validation="required" >
								<?php echo "<option value='0' selected >* สาขา/แผนก *</option>"; ?>
								<?php foreach ($department as $dep):?>
											<?php if ($dep->id == $group_field ){ ?>
													<?php echo "<option value='".$dep->id."' selected >".$dep->dep_thai."</option>"; ?>
											<?php }else { ?>
													<?php	echo "<option value='".$dep->id."'  >".$dep->dep_thai."</option>"; ?>
											<?php  } ?>
								 <?php endforeach;?>  
						</select>
						</fieldset>
						

						<fieldset>
						<label style="width:14%;" >ปีการศึกษา</label>
						<select name="maj_year" class="err" style="width:20%;" data-validation="required" >
								<?php echo "<option value='0' selected >* ปีการศึกษา *</option>"; ?>
								<?php foreach ($year as $yea):?>
											<?php if ($yea->id == $group_field ){ ?>
													<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
											<?php }else { ?>
													<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
											<?php  } ?>
								 <?php endforeach;?>  
						</select>
						</fieldset>
	
					<fieldset>
						<label style="width:14%;" >สถานะ</label>
						<input type="checkbox" name="maj_status" id="maj_status" value="1" checked style="width:20%;">
					</fieldset>


			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>major/index/'"  value="Cancel">
				</div>
				</form>
			</footer>
		</article><!-- end of post new article -->

	
			<article class="module width_full">
				<header><h3>นำเข้าไฟล์ Excel</h3></header>

				<form action="<?php echo base_url();?>major/view_import" method="post" enctype="multipart/form-data" />

				<div class="module_content">
	
					<fieldset>
						<label style="width:14%;" >ไฟล์  Excel </label>
						<input type="file" name="userfile" />
					</fieldset>


			<footer>
				<div class="submit_link">
					<input type="submit" value="Import" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>major/index/'"  value="Cancel">
				</div>
				</form>
			</footer>
		</article><!-- end of post new article -->

	<script> $.validate(); </script>
