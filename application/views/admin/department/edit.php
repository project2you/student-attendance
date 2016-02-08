<form action="<?php echo base_url();?>department/update_department" method="post" enctype="multipart/form-data" />
<?php foreach ($query as $item):?>
<section id="main" class="column">
		
		<h4 class="alert_info">Edit Department </h4>
	
	<article class="module width_full">
			<header><h3>แก้ไขข้อมูลแผนก</h3></header>
				<div class="module_content">
					
						<input  type="hidden" name="id"  id="id" value="<?php echo $item->id; ?>" />

						<fieldset>
							<label style="width:14%;" >รหัสแผนก</label>
							<input  type="text" name="dep_id"  id="dep_id" value="<?php echo $item->dep_id; ?>" style="width:20%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อแผนก/ไทย</label>
							<input type="text" name="dep_thai" id="dep_thai" value="<?php echo $item->dep_thai; ?>" style="width:20%;">
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ชื่อแผนก/อังกฤษ</label>
							<input type="text" name="dep_eng" id="dep_eng" value="<?php echo $item->dep_eng; ?>" style="width:20%;">

						</fieldset>

					<fieldset>
						<label style="width:14%;" >สถานะ</label>
						<input type="checkbox" name="dep_status" id="dep_status" value="1" checked style="width:20%;">
					</fieldset>


			<footer>
				<div class="submit_link">
					<input type="submit" value="Save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>department/index/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
	<?php endforeach;?>
</form>