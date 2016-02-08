  <div id="content">
    <div id="main">
      <div class="full_w">
	    <div class="h_title">Import Students</div>

				<?php echo form_open_multipart('student/view_import_student');?> 

					<div class="element">
						<label for="attach">Attachments</label>
						<input type="file" name="userfile" />
					</div>
					
					<div class="entry">
					  <button type="submit" class="add">บันทึกข้อมูล</button> <button class="cancel">Cancel</button>
					</div>
				</form>
			</div>
	  </div>
		<div class="clear"></div>
	</div>
</div