<section id="main" class="column">
		
		<?php

		if($this->session->flashdata('message') != ''){
			 
			 echo '<h4 class="alert_success">'.$this->session->flashdata('message').' </h4>';
		}

		?>
		
		<article class="module width_full">

		<header><h3 class="tabs_involved"> Verify Managment </h3>

		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">

			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" >No.</th> 
    				<th style="width:15%;" >รหัสนักศึกษา.</th> 
    				<th style="width:15%;" >ชื่อ</th> 
					<th style="width:15%;" >นามสกุล</th> 
    				<th style="width:20%;">สาขา/แผนก</th> 
					<th style="width:10%;" >ปีการศึกษา</th> 
					<th style="width:20%;">ปรกติ / สาย / ลา / ขาด</th> 
				</tr> 
			</thead> 
		
			<tbody> 
                     <?php $i=1; foreach ($query as $key => $value):?>
						<tr>
							<td class="align-center">
								<?php echo $i; ?>
								<INPUT TYPE="hidden" NAME="std_id[]" VALUE="<?php echo $value->std_cardid; ?>">
							</td>

							<td><?php echo $value->std_cardid; ?></td>
							<td><?php echo $value->std_fname; ?>  </td>
							<td><?php echo $value->std_lname; ?> </td>
							<td><?php echo $value->dep_thai; ?></td>
							<td><?php echo $value->yea_title; ?></td>
							<td>
								<?php

									if ($value->ver_sta_id == 1 ) {$check = 'True';} else { $check = 'False';}
									$data = array(
										'id'        => $value->std_cardid ,
										'name'        => 'verify_check['.$i.']',
										'checked'     => $check,
										'value'     => 1,
										'style'       => 'margin:10px',
										);
									echo form_radio($data);
									
									if ($value->ver_sta_id == 2 ) {$check = True;} else { $check = False;}
									$data = array(
										'id'        => $value->std_cardid ,
										'name'        => 'verify_check['.$i.']',
										'checked'     => $check,
										'value'     => 2,
										'style'       => 'margin:10px',
										);

									echo form_radio($data);

									if ($value->ver_sta_id == 3 ) {$check = True;} else { $check = False;}
									$data = array(
										'id'        => $value->std_cardid ,
										'name'        => 'verify_check['.$i.']',
										'checked'     => $check,
										'value'     => 3,
										'style'       => 'margin:10px',
										);

									echo form_radio($data);

									if ($value->ver_sta_id == 4 ) {$check = True;} else { $check = False;}
									$data = array(
										'id'        => $value->std_cardid ,
										'name'        => 'verify_check['.$i.']',
										'checked'     => $check,
										'value'     => 4,
										'style'       => 'margin:10px',
										);

									echo form_radio($data);
									$i++;
								?>
							</td> 
						</tr>
					<?php endforeach;?>    

			</tbody> 
			</table>

			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->

		<footer>
				<div class="submit_link">
						<!-- 
						 <INPUT TYPE="hidden" NAME="maj_id" VALUE="<?php echo $value->maj_id; ?>">
						<INPUT TYPE="hidden" NAME="ter_id" VALUE="<?php echo $value->ter_id; ?>">
						<INPUT TYPE="hidden" NAME="yea_title" VALUE="<?php echo $value->yea_id; ?>">
						-->
						<INPUT TYPE="hidden" ID="sitekey" NAME="sitekey" VALUE="<?php echo $value->sitekey; ?>">
						

						<input type="button" id="change_status" value="บันทึกข้อมูล" class="alt_btn">
				</div>
		</footer>
		
		</article><!-- end of content manager article -->
		
		<div class="clear"></div>

		<br>

		<section>
			<nav role="navigation">
				<?php 
					if ($this->session->userdata('flag') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_student; ?>
		<?php //echo 	$this->session->userdata('last_query'); ?>

<script>
    $(document).ready(function() {

    $("input:radio").change(function(){
        var that = this,
        value = $(this).val();
		std_id = $(this).attr("id");
		sitekey = $("#sitekey").val()

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


		var base_url = "<?php echo base_url(); ?>";

		 $.ajax({
			 type: "POST",
			 url:  base_url+"verify/change_status", 
			 data: {std_id: std_id , val : value , sitekey : sitekey  },
			 dataType: "text",  
			 cache:false,
			 success: 
				  function(data){
						// Something to do
				  }
			});
			return false;		
		});


	});
</script>
