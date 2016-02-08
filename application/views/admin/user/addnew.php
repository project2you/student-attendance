<form action="<?php echo base_url();?>user/save_user" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Add New User </h4>
	
	<article class="module width_full">
			<header><h3>เพิ่มรายการผู้ใช้</h3></header>
				<div class="module_content">
					

						<fieldset>
							<label style="width:14%;" >ชื่อ</label>
							<input  type="text" name="usr_fname"  id="usr_fname" style="width:20%;" data-validation="length alphanumeric" 		 data-validation-length="3-12" data-validation-error-msg=" ชื่อผู้ใช้ควรมีอย่างน้อย (3-12 อักษร)" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >นามสกุล</label>
							<input type="text" name="usr_lname" id="usr_lname"  style="width:20%;" data-validation="required"  >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >อีเมล์</label>
 							<input type="text" name="email" id="usr_email" style="width:20%;" data-validation="email" data-validation="required" >
							<label id="check_usr_email" style="width:14%;" ></label>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >รหัสผ่าน</label>
							<input type="text" name="usr_password" id="usr_password" style="width:20%;" data-validation="required" >
						</fieldset>

						<fieldset>

							<label style="width:14%;" >ระดับ</label>

							<?php 
									$data_gender = array(
									'3' => 'User',
									'2' => 'Technical',
									'1' => 'Administrator'
									);

									echo form_dropdown('usr_level', $data_gender, 'User');
							?>
							
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
						<label style="width:14%;" >อัปโหลดรูปภาพ</label>
						<input type="file" name="userfile" style="width:20%;">
					</fieldset>

					<fieldset>
						<label style="width:14%;" >สถานะ</label>
						<input type="checkbox" name="usr_level" id="usr_level" value="1" checked style="width:20%;">
					</fieldset>


			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>user/list_user/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
</form>

<script> $.validate(); </script>
