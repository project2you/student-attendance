<form action="<?php echo base_url();?>year/save_year" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Add New Year</h4>
	
	<article class="module width_full">
			<header><h3>เพิ่มปีการศึกษา</h3></header>
				<div class="module_content">
					
						<fieldset>
							<label style="width:14%;" >ปีการศึกษา</label>
							<INPUT TYPE="hidden" NAME="status_edit" id="status_edit" VALUE="0">
							<input  type="text" name="yea_title"  id="yea_title" style="width:20%;" data-validation="required" >
							<label id="check_year_title" style="width:14%;" ></label>
						</fieldset>

			<footer>
				<div class="submit_link">
					<input type="submit" id="submit_save" value="Save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>year'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
</form>

<script> $.validate(); </script>
