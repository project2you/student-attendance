<form action="<?php echo base_url();?>setting/term_setting_update" method="post" enctype="multipart/form-data" />

<section id="main" class="column">
		
		<h4 class="alert_info">Term Setting </h4>
	
	<article class="module width_full">
			<header><h3>วันเปิด/ปิดภาคเรียน</h3></header>
				<div class="module_content">
					
						<fieldset>
							<INPUT TYPE="hidden" NAME="status_edit" id="status_edit" VALUE="1">

							<INPUT TYPE="hidden" NAME="yea_id" id="yea_id" VALUE="<?php  ?>">

							<label style="width:14%;" >วันเปิดภาคเรียน</label>
							<input  type="text" name="set_ter_open"  id="set_ter_open" style="width:10%;" value="<?php echo $term_setting[0]['set_ter_open']; ?>" data-validation="required" >

						</fieldset>

						<fieldset>
							<label style="width:14%;" >วันปิดภาคเรียน</label>
							<input  type="text" name="set_ter_close"  id="set_ter_close" style="width:10%;" value="<?php echo $term_setting[0]['set_ter_close'];  ?>" data-validation="required" >
						</fieldset>

						<fieldset>
							<label style="width:14%;" >ภาคที่</label>
							<input  type="text" name="set_ter_part"  id="set_ter_part" style="width:5%;" value="<?php echo $term_setting[0]['set_ter_part'];  ?>" data-validation="required" >

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
