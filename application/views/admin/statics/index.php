<section id="main" class="column">

		<?php

		if($this->session->flashdata('message') != ''){
			 
			 echo '<h4 class="alert_success">'.$this->session->flashdata('message').' </h4>';
		}

		?>
		
		<article class="module width_full">

<header><h3 class="tabs_involved">  Dashboard </h3>

		<?php

            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'form1');
            echo form_open('statics/search_static/', $attributes);
            $data_submit = array('name' => 'form1', 'class' => 'btn btn-primary', 'value' => 'Go');
		?>			

			<fieldset>

				<label style="width:20%;" >ภาคศึกษา/เทอม</label>

				<input type="text" name="ter_id"  id="ter_id" value="<?php echo $ter_id; ?>" style="width:5%;">		

				<label style="width:15%;" >ปีการศึกษา</label>

				<select name="group_field" id="yea_id" class="err" style="width:20%;" >
                        <?php echo "<option value='0' selected > * ปีการศึกษา * </option>"; ?>
						<?php foreach ($year as $yea):?>

                            		<?php if ($yea->id == $last_year){ ?>
					                     	<?php echo "<option value='".$yea->id."' selected >".$yea->yea_title."</option>"; ?>
					                <?php }else { ?>
											<?php	echo "<option value='".$yea->id."'  >".$yea->yea_title."</option>"; ?>
                                   	<?php  } ?>

                         <?php endforeach;?>  
				</select>
				
				<button type="submit" form="form1" id="bnt_search_static" value="Submit">ค้นหาข้อมูล</button>

			</fieldset>
			<?php echo form_close(); ?>
		</header>


	<div class="tab_container">
			<div id="tab1" class="tab_content">

			<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

			<table id="datatable">
				<thead>
					<tr>
						<th></th>
						<th>ปรกติ</th>
						<th>สาย</th>
						<th>ลา</th>
						<th>ขาด</th>
					</tr>
				</thead>

				<tbody> 
                    <?php $i=1; foreach ($static_summary as $item):?>
						<tr>
							<td class="align-center"><?php echo substr($item->maj_thai,0,30); ?></td>
							<td>
								<?php $nor = $this->Statics_model->static_count_normal($item->id , $item->ter_id  , $item->yea_id); print_r( $nor[0]->nor ); ?> 
							</td>

							<td>
								<?php $lat = $this->Statics_model->static_count_late($item->id , $item->ter_id  , $item->yea_id); print_r( $lat[0]->lat ); ?>  
							</td>

							<td>
								<?php $lea = $this->Statics_model->static_count_leave($item->id , $item->ter_id  , $item->yea_id); print_r( $lea[0]->lea ); ?>  
							</td>

							<td>
								<?php $mis = $this->Statics_model->static_count_missing($item->id , $item->ter_id  , $item->yea_id); print_r( $mis[0]->mis ); ?>
							</td>
						</tr>
					<?php endforeach;?>    

				</tbody>
			</table>

		</div>
	</div>
		</article><!-- end of content manager article -->
		
		<div class="clear"></div>
		
		<br>

		<section>
			<nav role="navigation">
				<?php 
					if ($this->session->userdata('flag_static') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>

		<?php //echo $this->session->flashdata('total_rows');//$count_all_user; ?>
		<?php //echo 	$this->session->userdata('last_query'); ?>


<script type="text/javascript"> 

$(document).ready(function() { 

 $("#ter_id").focusout(function () {
        var that = this,
        value = $(this).val();
		
		if ( (value == "" )  || ( value == 0 ) ) {
			document.getElementById("bnt_search_static").disabled = true;
			$("#bnt_search_static").removeClass("alt_btn");

		}else{
			document.getElementById("bnt_search_static").disabled = false;		
		}
		
    });

// Chart
    $('#container').highcharts({
        data: {
            table: 'datatable'
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'สถิติภาพรวมการเข้าชั้นเรียน ภาคเรียนที่ ' +  $("#ter_id").val() + " / " + $("#yea_id option:selected").html()
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Units'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.point.y + ' ' + this.point.name.toLowerCase();
            }
        }
    });

}); 
</script>

