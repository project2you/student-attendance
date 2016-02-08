<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/skin_user/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>assets/skin_user/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url();?>assets/skin_user/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/skin_user/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url();?>assets/skin_user/bower_components/morrisjs/morris.css" rel="stylesheet">

	
    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/skin_user/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- jQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/skin_user/js/jquery.form.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/skin_user/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/skin_user/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript 
    <script src="<?php echo base_url();?>assets/skin_user/bower_components/raphael/raphael-min.js"></script>
    <script src="<?php echo base_url();?>assets/skin_user/bower_components/morrisjs/morris.min.js"></script>
    <script src="<?php echo base_url();?>assets/skin_user/js/morris-data.js"></script>
	-->

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/skin_user/dist/js/sb-admin-2.js"></script>
	

	<script src="<?php echo base_url();?>assets/js/highcharts.js"></script>
	<script src="<?php echo base_url();?>assets/js/data.js"></script>
	<script src="<?php echo base_url();?>assets/js/exporting.js"></script>

<style>

#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>


	<script>

		$(document).ready(function()
		{
			$("#progress").hide();

			var options = { 
			beforeSend: function() 
			{
				$("#progress").show();
				//clear everything
				$("#bar").width('0%');
				$("#message").html("");
				$("#percent").html("0%");
			},
			uploadProgress: function(event, position, total, percentComplete) 
			{
				$("#bar").width(percentComplete+'%');
				$("#percent").html(percentComplete+'%');
		 
			},
			success: function() 
			{
				$("#bar").width('100%');
				$("#percent").html('100%');
			},
			complete: function(response) 
			{
				$("#message").html("<font color='green'>"+response.responseText+"</font>");
				$('#my_image').attr('src', response.responseText );

				$("#message").hide();
			},
			error: function()
			{
				$("#message").html("<font color='red'> ERROR: unable to upload files</font>");
		 
			}
		 
		}; 
		 
		 // Submit Module Student_Edit
		 <?php 
			 if ($this->uri->segment(3) =="student_edit" ) {
		 ?>
			$("#myForm").ajaxForm(options);
		 <?php } ?>

	});

	</script>

	<script>

		$(document).ready(function() {

	    $("#bnt_std_password").click(function() {
			

			if (  $("#std_new_password").val() !=  $("#std_confirm_password").val() ) {
				
				$("#message").html("<font color='red'> ERROR: กรุณาตรวจสอบรหัสผ่านอีกครั้ง!! </font>");						

			}else {
				var base_url = "<?php echo base_url(); ?>";
		
				 $.ajax({
				 type: "POST",
				 url:  base_url+"front_profiles/student_update_password", 
				 data: {std_old_password: $("#std_old_password").val() ,  std_new_password: $("#std_new_password").val() , std_confirm_password:  $("#std_new_password").val() } ,
				 dataType: "text",  
				 cache:false,
				 success: 
					  function(data){
							if ( data == 1)
							{
								$("#message").html("<font color='green'> อัปเดทข้อมูลรหัสผ่านใหม่เรียบร้อย!! </font>");
							}else{
								$("#message").html("<font color='red'> เกิดข้อผิดพลาด:  กรุณาตรวจสอบรหัสผ่าน!! </font>");						
							}
					  }
				});

				return false;
			 }

			});
		});

	</script>


</head>