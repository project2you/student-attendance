<form action="<?php echo base_url();?>student/save_student" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Add New Students </h4>
	
	<article class="module width_full">
			<header><h3>แก้ไขรายละเอียด</h3></header>
				<div class="module_content">
					
						<fieldset>
							<label style="width:14%;" >รหัสนักศักษา</label>
							<input  type="text" name="std_cardid"  id="std_cardid" style="width:20%;"  data-validation="required" >
							<label id="check_id_student" style="width:14%;" ></label>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อ</label>
							<input  type="text" name="std_fname"  id="std_fname" style="width:20%;"  data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >นามสกุล</label>
							<input type="text" name="std_lname" id="std_lname"  style="width:20%;"  data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >เพศ</label>
							
							<SELECT NAME="std_gender">
								<OPTION VALUE="1" SELECTED> ชาย </OPTION>
								<OPTION VALUE="2"> หญิง </OPTION>
							</SELECT>

						</fieldset>

						<fieldset>
							<label style="width:14%;" >อายุ</label>
							<input type="text" name="std_birthday" id="std_birthday" style="width:20%;"  data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >อีเมล์</label>
							<input type="text" name="std_email" id="std_email" style="width:20%;"  data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >รหัสผ่าน</label>
							<input type="text" name="std_password" id="std_password" style="width:20%;"  data-validation="required" >
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
                            						<?php if ($sec->id == $item->sec_id ){ ?>
					                                    	<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
					                                   <?php }else { ?>
																	<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
                                   						<?php  } ?>
                            						<?php endforeach;?>  
						</select>
					</fieldset>

					<fieldset>
						<label style="width:14%;" >อัปโหลดรูปภาพ</label>
						<input type="file" name="userfile" style="width:20%;">
					</fieldset>


					<fieldset>
						<label style="width:14%;" >สถานะนักศึกษา</label>
						<input type="checkbox" name="std_status" id="std_status" value="1" checked style="width:20%;"  data-validation="required" >
					</fieldset>

			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>student/list_student/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
</form>

<script> $.validate(); </script>
