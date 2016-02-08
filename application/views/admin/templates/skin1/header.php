<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>Dashboard Admin Panel</title>
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/layout.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/paginate.css" type="text/css" media="screen" />


	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script src="<?php echo base_url();?>assets/js/jquery-1.12.0.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/hideshow.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.equalHeight.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>

	<script src="<?php echo base_url();?>assets/js/highcharts.js"></script>
	<script src="<?php echo base_url();?>assets/js/data.js"></script>
	<script src="<?php echo base_url();?>assets/js/exporting.js"></script>

	<script src="<?php echo base_url();?>assets/js/jquery.form-validator.min.js"></script>

	<!-- Full Calendar >
	<!-->
	<script src='<?php echo base_url();?>assets/js/calendar/fullcalendar.min.js'></script>
	<script src='<?php echo base_url();?>assets/js/calendar/lib/moment.min.js'></script>

	<link href='<?php echo base_url();?>assets/js/calendar/fullcalendar.css' rel='stylesheet' />
	<link href='<?php echo base_url();?>assets/js/calendar/fullcalendar.print.css' rel='stylesheet' media='print' />

	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
	<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>

	<?php 
		if ( $this->uri->segment(2) == 'edit_verify_checked' ){
	?>

	<script>

	$(document).ready(function() {
        
		var monthNames = ["January", "February", "March", "April", "May", "June",
			"July", "August", "September", "October", "November", "December"
		];

		var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
		
		var base_url = "<?php echo base_url(); ?>";

		$.ajax({
		   url: base_url+'verify/calendar_verify_checked',
		   type: 'POST',
            data: {
                maj_id: <?php if ( $this->uri->segment(4) == 0 ) { echo 0;
                } else {
					echo $this->uri->segment(4);
				} 
				?> , ter_id : <?php echo $this->uri->segment(6); ?>
				   , dep_id : <?php echo $this->uri->segment(5); ?>
				   , yea_id : <?php echo $this->uri->segment(7); ?>,
            },
		   async: false,
		   success: function(response){
			 json_events = response;
		   }
		});
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: y+'-'+monthNames[date.getMonth()],
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: JSON.parse(json_events),
			eventRender: function(event, element) {
				element.attr('title', event.tooltip);
			}
		});
		
	});

	</script>

	<?php 
		
		}
	?>
	
	<!-- Full_Calendar >
	<!-->

	<?php 
		
		if ( $this->uri->segment(2) == 'calendar' ){
	?>

		<script>

		$(document).ready(function() {
			
			var monthNames = ["January", "February", "March", "April", "May", "June",
			  "July", "August", "September", "October", "November", "December"
			];

			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			
			var base_url = "<?php echo base_url(); ?>";
			
			$.ajax({
			   url: base_url+'verify/full_calendar',
			   type: 'POST',
				data: { },
			   async: false,
			   success: function(response){
				 json_events = response;
			   }
			});
			
			$('#verify_calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,basicWeek,basicDay'
				},
				defaultDate: y+'-'+monthNames[date.getMonth()],
				editable: true,
				eventLimit: true, // allow "more" link when too many events
				events: JSON.parse(json_events),
				eventRender: function(event, element) {
					element.attr('title', event.tooltip);
				}
			});
			
		});

		</script>

	<?php 			
		}
	?>


	<!-- END Full_Calendar >
	<!-->
	

	<script type="text/javascript">

	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

	});

    </script>
    

<script>

// Select All for Delete ID Students
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});

$(document).ready(function(){   

    $("#bnt_search_student").click(function() {
	
	var base_url = "<?php echo base_url(); ?>";
	var  search_cardid =  $('select[name=search_cardid]').val();

     $.ajax({
         type: "POST",
         url:  base_url+"student/count_all_student", 
         data: {search_string: $("#search_string").val()  , search_cardid: search_cardid },
         dataType: "text",  
         cache:false,
         success: 
              function(data){
			   document.getElementById("count_all_student").value = data;
			   document.getElementById('form1').submit();
              }
          });

     return false;

	});

	$("#bnt_clear").click(function() {
		
		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"student/clear_all_student", 
			 data: {search_string: $("#search_string").val()},
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					window.location.href=window.location.href;
				  }
		});

		return false;

	 });


    $("#bnt_search_user").click(function() {
	
	var base_url = "<?php echo base_url(); ?>";

     $.ajax({
         type: "POST",
         url:  base_url+"user/count_all_user", 
         data: {search_string: $("#search_string").val()},
         dataType: "text",  
         cache:false,
         success: 
              function(data){
			   document.getElementById("count_all_user").value = data;
			   document.getElementById('form1').submit();
              }
          });

     return false;

	});

	$("#bnt_clear_user").click(function() {
		
		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"user/clear_all_user", 
			 data: {search_string: $("#search_string").val()},
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					window.location.href=window.location.href;
				  }
		});

		return false;

	 });


    $("#bnt_search_verify").click(function() {
	
	var base_url = "<?php echo base_url(); ?>";

     $.ajax({
         type: "POST",
         url:  base_url+"verify/count_all_verify", 
         data: {search_string: $("#search_string").val()},
         dataType: "text",  
         cache:false,
         success: 
              function(data){
			   document.getElementById("count_all_verify").value = data;
			   document.getElementById('form1').submit();
              }
          });

     return false;

	});

    $("#bnt_search_static").click(function() {	
		document.getElementById('form1').submit();
	});

	$("#bnt_clear_major").click(function() {
		
		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"major/clear_all_major", 
			 data: {search_string: $("#search_string").val()},
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					window.location.href=window.location.href;
				  }
		});

		return false;

	 });

	$("#bnt_clear_verify").click(function() {
		
		var base_url = "<?php echo base_url(); ?>";
		
		 $.growlUI('System Notification', 'Please waiting cleaning!!!'); 

		 $.ajax({
			 type: "POST",
			 url:  base_url+"verify/clear_all_verify/", 
			 data: {search_string: $("#search_string").val()},
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					window.location.href=window.location.href;
				  }
		});

		return false;

	 });

	$("#bnt_clear_department").click(function() {
		
		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"department/clear_all_department", 
			 data: {search_string: $("#search_string").val()},
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					window.location.href=window.location.href;
				  }
		});

		return false;

	 });


    var minlength = 3;

    $("#std_cardid").focusout(function () {
        var that = this,
        value = $(this).val();

		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"student/check_id_student", 
			 data: {search_string: value },
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					if (data > 0){
						$("#check_id_student").html("<p style='color:red'> *** มีข้อมูลซ้ำ ***</p>");
						document.getElementById("submit_save").disabled = true;
						$("#submit_save").removeClass("alt_btn");
					}else{
						$("#check_id_student").html("<p style='color:blue'> </p>");
						document.getElementById("submit_save").disabled = false;
						$("#submit_save").addClass("alt_btn");
					}
				  }
		});

		return false;
		
    });


    $("#usr_email").focusout(function () {
        var that = this,
        value = $(this).val();

		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"user/check_usr_email", 
			 data: {search_string: value },
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					if (data > 0){
						$("#check_usr_email").html("<p style='color:red'> *** มีข้อมูลซ้ำ ***</p>");
						document.getElementById("submit_save").disabled = true;
						$("#submit_save").removeClass("alt_btn");
					}else{
						$("#check_usr_email").html("<p style='color:blue'> </p>");
						document.getElementById("submit_save").disabled = false;
						$("#submit_save").addClass("alt_btn");
					}
				  }
		});

		return false;
		
    });


    $("#maj_id").focusout(function () {
        var that = this,
        value = $(this).val();

		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"major/check_maj_id", 
			 data: {search_string: value },
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					if (data > 0){
						$("#check_maj_id").html("<p style='color:red'> *** มีข้อมูลซ้ำ ***</p>");
						document.getElementById("submit_save").disabled = true;
						$("#submit_save").removeClass("alt_btn");
					}else{
						$("#check_maj_id").html("<p style='color:blue'> </p>");
						document.getElementById("submit_save").disabled = false;
						$("#submit_save").addClass("alt_btn");
					}
				  }
		});

		return false;
		
    });


    $("#yea_title").focusout(function () {
        var that = this,
        value = $(this).val();
		var status_edit = $("#status_edit").val()

		var base_url = "<?php echo base_url(); ?>";
		
		 $.ajax({
			 type: "POST",
			 url:  base_url+"year/check_year_title", 
			 data: {search_string: value },
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					if ( (data > 0  &&  status_edit == 0 )   ){
						$("#check_year_title").html("<p style='color:red'> *** มีข้อมูลซ้ำ ***</p>");
						document.getElementById("submit_save").disabled = true;
						$("#submit_save").removeClass("alt_btn");
					}else{
						$("#check_year_title").html("<p style='color:blue'> </p>");
						document.getElementById("submit_save").disabled = false;
						$("#submit_save").addClass("alt_btn");
					}
				  }
		});

		return false;
		
    });


    $("#dep_id").focusout(function () {
        var that = this,
        value = $(this).val();
		
		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"department/check_dep_id", 
			 data: {search_string: value },
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
					                                                                            
					if (data > 0){
						$("#check_dep_id").html("<p style='color:red'> *** มีข้อมูลซ้ำ ***</p>");
						document.getElementById("submit_save").disabled = true;
						$("#submit_save").removeClass("alt_btn");
					}else{
						$("#check_dep_id").html("<p style='color:blue'> </p>");
						document.getElementById("submit_save").disabled = false;
						$("#submit_save").addClass("alt_btn");
					}
				  }
			});

			return false;		
		});

	});


function confirmDelete(id,url) {

    var txt;
    var r = confirm("คุณต้องการที่จะลบข้อมูลนี้ใช่หรือไม่?");
	var base_url = "<?php echo base_url(); ?>";
	

    if (r == true) {

		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
 
       
		 $.ajax({
			 type: "POST",
			 url:  base_url+url, 
			 data: {data_id: id},
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
						 location.reload();
				  }
		});

		setTimeout($.unblockUI, 1000); 
    } 
}


function confirmDeleteStudent(id,url) {

	var arraydata=$('input:checkbox:checked').serialize()

    var txt;
    var r = confirm("คุณต้องการที่จะลบข้อมูลนี้ใช่หรือไม่?");
	var base_url = "<?php echo base_url(); ?>";
	

    if (r == true) {

		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
 
		 $.ajax({
			 type: "POST",
			 url:  base_url+url, 
			 data: {data_id: arraydata},
			 cache:false,
			 success: 
				  function(data){
						 location.reload();
				  }
		});

		setTimeout($.unblockUI, 1000); 
    } 
}


function confirmDeleteMajor(id,url) {

	var arraydata=$('input:checkbox:checked').serialize();

    var txt;
    var r = confirm("คุณต้องการที่จะลบข้อมูลนี้ใช่หรือไม่?");
	var base_url = "<?php echo base_url(); ?>";
	

    if (r == true) {

		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
 
		 $.ajax({
			 type: "POST",
			 url:  base_url+url, 
			 data: {data_id: arraydata},
			 cache:false,
			 success: 
				  function(data){
						location.reload();
				  }
		});

		setTimeout($.unblockUI, 1000); 
    } 
}

</script>

<script type="text/javascript"> 

$(document).ready(function() { 
	
	////////////////////////////////////////////////////////////////////////////////

	$('#icon_import_verify').click(function() { 
        $.blockUI({ message: $('#import_verify') }); 
 
		$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI); 

    }); 

	$('#yes_import').click(function() { 
            $.unblockUI(); 
			
            return false; 
	}); 

	$('#no_import').click(function() { 
            $.unblockUI(); 
            return false; 
	}); 

	////////////////////////////////////////////////////////////////////////////////

	$('#list_major').click(function() { 
        $.blockUI({ message: $('#list_major_select') }); 
 
		$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI); 

    }); 

	$('#yes_list_major').click(function() { 
            
			var x = document.getElementById("mySelect").selectedIndex;
			
			var dep_detail  = $("#mySelect option:selected").html()
				dep_detail = dep_detail.split(":");

				document.getElementById("maj_detail").value = dep_detail[1];


				document.getElementById("maj_id").value  = dep_detail[0];
			
				//alert( document.getElementById("maj_id").value );


			$.unblockUI(); 
			
			$( "#maj_detail" ).focus();

            return false; 
	}); 

	$('#no_list_major').click(function() { 
            $.unblockUI(); 
            return false; 
	}); 

	///////////////////////////////////////////////////////////////////////////


	 $('#mnu_logout').click(function() { 
        $.blockUI({ message: $('#logout') }); 
 
		$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI); 

    }); 

	$('#yes_logout').click(function() { 
            $.unblockUI(); 
			window.location.replace('<?php echo base_url()."login/logout/"; ?>');
            return false; 
	}); 

	$('#no_logout').click(function() { 
            $.unblockUI(); 
            return false; 
	}); 

	 $('#submit_save').click(function() { 

		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
 
        setTimeout($.unblockUI, 1000); 
    }); 


	 $('#bnt_reload').click(function() { 

		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
 
        setTimeout($.unblockUI, 2000); 
    }); 

	 $('#bnt_export_verify').click(function() { 

		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
 
        setTimeout($.unblockUI, 2000); 
    }); 


	$("#change_status").click(function() {
		
		$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } }); 
 
        setTimeout($.unblockUI, 1000); 
		location.reload();
		//window.history.back();
	 });

}); 
</script>

<script>


  $(function() {
    $( "#log_time" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
  });

  </script>


