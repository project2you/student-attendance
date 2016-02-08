<form action="<?php echo base_url();?>year/update_year" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Add New Year </h4>
	
	<article class="module width_full">
			<header><h3>เพิ่มปีการศึกษา</h3></header>
				<div class="module_content">
					
						<fieldset>
							<INPUT TYPE="hidden" NAME="status_edit" id="status_edit" VALUE="1">

							<INPUT TYPE="hidden" NAME="yea_id" id="yea_id" VALUE="<?php echo $yea_id; ?>">

							<label style="width:14%;" >ปีการศึกษา</label>
							<input  type="text" name="yea_title"  id="yea_title" style="width:20%;" value="<?php echo $query[0]->yea_title?>" data-validation="required" >
						</fieldset>

			<footer>
				<div class="submit_link">
					<input type="submit" id="submit_save" value="Save" class="alt_btn">
					<input type="button"  onclick="location.href='<?php echo  base_url();?>department/index/'"  value="Cancel">
				</div>
			</footer>
		</article><!-- end of post new article -->
</form>

<script> $.validate(); </script>
