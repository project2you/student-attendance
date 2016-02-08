 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Graph</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
								กราฟสถิติการเข้าชั้นเรียน
                        </div>
                        <div class="panel-body">


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
								<td class="align-center"><?php echo $item->maj_thai; ?></td>
											<td class="align-center" ><?php  
													$normal = $this->Fronts_model->check_normal($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($normal[0]->normal);
												?>
											</td>
                                            <td class="align-center"> <?php  
													$late = $this->Fronts_model->check_late($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($late[0]->late);
												?>											
											</td>
                                            <td class="align-center"><?php  
													$leaves = $this->Fronts_model->check_leaves($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($leaves[0]->leaves);
												?>	
											</td>
                                            <td class="align-center"><?php  
													$missing = $this->Fronts_model->check_missing($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($missing[0]->missing);
												?>	
											</td>

							</tr>
						<?php endforeach;?>    

					</tbody>
				</table>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

		<script> 
			$(function () { 
				// Chart
				$('#container').highcharts({
					data: {
						table: 'datatable'
					},
					chart: {
						type: 'column'
					},
					title: {
						text: 'สถิติภาพรวมการเข้าชั้นเรียน ภาคเรียนที่ ' 
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

		
		<!--
		<script type="text/javascript">
        $(document).ready(function() {
            var options = {
                chart: {
                    renderTo: 'container',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: 'Web Sales & Marketing Efforts'
                },
                tooltip: {
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: '#000000',
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                            }
                        }
                    }
                },
                series: [{
                    type: 'bar',
                    name: 'Browser share',
                    data: []
                }]
            }
            
            $.getJSON("render_graph", function(json) {
                options.series[0].data = json;
                chart = new Highcharts.Chart(options);
            });
            
        });   
        </script>
		-->
		