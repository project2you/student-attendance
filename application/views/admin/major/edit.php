<form action="<?php echo base_url();?>major/update_major" method="post" enctype="multipart/form-data" />
<?php foreach ($query as $item):?>
<section id="main" class="column">
		
		<h4 class="alert_info">Edit Department </h4>
	
	<article class="module width_full">
			<header><h3>แก้ไขข้อมูลแผนก</h3></header>
				<div class="module_content">
					
						<input  type="hidden" name="id"  id="id" value="<?php echo $item->id; ?>" />

						<fieldset>
							<label style="width:14%;" >รหัสรายวิชา</label>
							<input  type="text" name="maj_id" id="maj_id" value="<?php echo $item->maj_id; ?>" style="width:20%;" data-validation="required" >
							<label id="check_maj_id" style="width:14%;" ></label>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อภาษาไทย</label>
							<input type="text" name="maj_thai" id="maj_thai" value="<?php echo $item->maj_thai; ?>" style="width:50%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อภาษาอังกฤษ</label>
							<input type="text" name="maj_eng" id="maj_eng" value="<?php echo $item->maj_eng; ?>" style="width:50%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >คำอธิบายรายวิชา</label>
							<TEXTAREA NAME="maj_des" ROWS="5" COLS="10" style="width:50%;"> <?php echo $item->maj_des; ?> </TEXTAREA>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >หน่วยกิจ</label>
							<input type="text" name="maj_unit" id="maj_unit" value="<?php echo $item->maj_unit; ?>" style="width:10%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ภาคเรียน</label>
							<input type="text" name="maj_term" id="maj_term" value="<?php echo $item->maj_term; ?>" style="width:10%;" data-validation="required" >
						</fieldset>

						<fieldset>
						<label style="width:14%;" >สาขา/แผนก</label>
						<select name="dep_id" class="err" style="width:20%;" >
								<?php echo "<option value='0' selected >* สาขา/แผนก *</option>"; ?>
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
						<label style="width:14%;" >ปีการศึกษา</label>
						<select name="maj_year" class="err" style="width:20%;" >
								<?php echo "<option value='0' selected >* ปีการศึกษา *</option>"; ?>
								<?php foreach ($year as $yea):?>
											<?php if ($yea->id == $item->maj_year ){ ?>
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
			</footer>
		</article><!-- end of post new article -->
	<?php endforeach;?>
</form>

<script> $.validate(); </script>
