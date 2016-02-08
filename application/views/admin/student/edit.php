	<form action="<?php echo base_url();?>student/update_student" method="post" enctype="multipart/form-data" />
<?php foreach ($query as $item):?>
<section id="main" class="column">
	
	<article class="module width_full">
			<header><h3>แก้ไขรายละเอียด</h3></header>
				<div class="module_content">
					
						<fieldset>
							<label style="width:14%;" >รหัสนักศักษา</label>
							  <input  type="hidden" name="std_id"  id="usr_id" value="<?php echo $item->std_id; ?>" />
							   <input  type="text" name="std_cardid"  id="std_cardid" value="<?php echo $item->std_cardid; ?>"style="width:20%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อ</label>
							<input  type="text" name="std_fname"  id="std_fname" value="<?php echo trim($item->std_fname); ?>" style="width:20%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >นามสกุล</label>
							<input type="text" name="std_lname" id="std_lname" value="<?php echo trim($item->std_lname); ?> "style="width:20%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >เพศ</label>

							<SELECT NAME="std_gender">
								<OPTION VALUE="1" <?php if ($item->std_gender == 1) { echo "SELECTED"; } ?>> ชาย </OPTION>
								<OPTION VALUE="2" <?php if ($item->std_gender == 2) { echo "SELECTED"; } ?> > หญิง </OPTION>
							</SELECT>

						</fieldset>

						<fieldset>
							<label style="width:14%;" >วันเดือนปีเกิด</label>
							<input type="text" name="std_birthday" id="std_birthday" value="<?php echo $item->std_birthday; ?> "style="width:20%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >อีเมล์</label>
							<input type="text" name="std_email" id="std_email" value="<?php echo $item->std_email; ?> "style="width:20%;">
						</fieldset>


						<fieldset>
							<label style="width:14%;" >รหัสผ่าน</label>
							<input type="text" name="std_password" id="std_password" value="<?php echo $item->std_password; ?> "style="width:20%;">
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
						<label style="width:14%;" >ปีการศึกษา</label>
						<select name="yea_id" class="err">
                        						<?php foreach ($year as $yea):?>
                            						<?php if ($yea->id == $item->yea_id ){ ?>
					                                    	<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
					                                   <?php }else { ?>
																	<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
                                   						<?php  } ?>
                            						<?php endforeach;?>  
						</select>
					</fieldset>

					<fieldset>
						<label style="width:14%;" >รูปภาพ</label>
						&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url()."assets/uploads/photo/".$item->std_picture; ?>" alt="Smiley face">
					</fieldset>

					<fieldset>
						<label style="width:14%;" >อัปโหลดรูปภาพ</label>
						<input type="file" name="userfile" style="width:20%;">
					</fieldset>

			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>student/list_student/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
<?php endforeach;?>  
</form>