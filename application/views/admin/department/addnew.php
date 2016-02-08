<form action="<?php echo base_url();?>department/save_department" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Add New Department </h4>
	
	<article class="module width_full">
			<header><h3>เพิ่มแผนก</h3></header>
				<div class="module_content">
					

						<fieldset>
							<label style="width:14%;" >รหัสแผนก</label>
							<input  type="text" name="dep_id"  id="dep_id" style="width:20%;">
							<label id="check_dep_id" style="width:14%;" ></label>
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อแผนก/ไทย</label>
							<input type="text" name="dep_thai" id="dep_thai"  style="width:20%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อแผนก/อังกฤษ</label>
							<input type="text" name="dep_eng" id="dep_eng" style="width:20%;">

						</fieldset>

					<fieldset>
						<label style="width:14%;" >สถานะ</label>
						<input type="checkbox" name="dep_status" id="dep_status" value="1" checked style="width:20%;">
					</fieldset>


			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" id="submit_save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>department/index/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
</form>