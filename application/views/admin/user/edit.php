<form action="<?php echo base_url();?>user/update_user" method="post" enctype="multipart/form-data" />
<?php foreach ($query as $item):?>
<section id="main" class="column">
		
		<h4 class="alert_info">Edit User </h4>
	
	<article class="module width_full">
			<header><h3>แก้ไขรายการผู้ใช้</h3></header>
				<div class="module_content">
					
						<input  type="hidden" name="usr_id"  id="usr_id" value="<?php echo $item->usr_id; ?>" />

						<fieldset>
							<label style="width:14%;" >ชื่อ</label>
							<input  type="text" name="usr_fname"  id="usr_fname" value="<?php echo trim($item->usr_fname); ?>" style="width:20%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >นามสกุล</label>
							<input type="text" name="usr_lname" id="usr_lname"  value="<?php echo trim($item->usr_lname); ?>" style="width:20%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >อีเมล์</label>
							<input type="text" name="usr_email" id="usr_email" value="<?php echo trim($item->usr_email); ?>" style="width:20%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >รหัสผ่าน</label>
							<input type="text" name="usr_password" id="usr_password" value="<?php echo trim($item->usr_password); ?>" style="width:20%;" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ระดับ</label>

							<?php 
									$data_gender = array(
									'3' => 'User',
									'2' => 'Technical',
									'1' => 'Administrator'
									);

									echo form_dropdown('usr_level', $data_gender, trim($item->usr_level) );
							?>

						</fieldset>

					<fieldset>
						<label style="width:14%;" >สาขา/แผนก</label>
						<select name="usr_department" class="err">
                        		<?php foreach ($department as $dep):?>
                            			<?php if ($dep->id == $item->usr_department ){ ?>
											       	<?php echo "<option value='".$dep->id."' selected >".$dep->dep_thai."</option>"; ?>
					                           <?php }else { ?>
													<?php	echo "<option value='".$dep->id."'  >".$dep->dep_thai."</option>"; ?>
                                		<?php  } ?>
                            	<?php endforeach;?>  
						</select>
					</fieldset>

					<fieldset>
						<label style="width:14%;" >รูปภาพ</label>
						&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url()."assets/uploads/photo/".$item->usr_picture; ?>" alt="Smiley face">
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
					<input type="button"  onclick="location.href='<?php echo  base_url();?>user/index/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
	<?php endforeach;?>
</form>

<script> $.validate(); </script>
