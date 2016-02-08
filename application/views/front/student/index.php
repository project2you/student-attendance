   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> <?php echo "ยินดีต้อนรับ ".$this->session->userdata('std_fname'). ' '.$this->session->userdata('std_lname'); ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

			<?php 
			$alert =0;				
			foreach ($result as $item):
			
			?>

			  <!-- Check Late -->
			<?php
			$late = $this->Fronts_model->check_late($this->session->userdata('std_cardid') , $item->ver_id); 							
				if ($late[0]->late >= $item->min_late){
					$alert == 1;
			?>
				<div class="panel-body">
					<div class="alert alert-danger alert-dismissable">
						 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 <?php echo "คุณมาสาย...เกินจำนวน ในรายวิชา : ".$item->maj_id." : ".$item->maj_thai." : ".$item->msg_alert;  ?>
					</div>
				</div>
			<?php } ?>


			  <!-- Check leaves -->
			<?php
			$leaves = $this->Fronts_model->check_leaves($this->session->userdata('std_cardid') , $item->ver_id); 
				if ($leaves[0]->leaves >= $item->min_late){
					$alert == 1;
			?>
					<div class="panel-body">
						<div class="alert alert-danger alert-dismissable">
							 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									 <?php echo "คุณลาเรียน...เกินจำนวน ในรายวิชา : ".$item->maj_id." : ".$item->maj_thai." : ".$item->msg_alert;  ?>
						</div>
					</div>
			<?php } ?>


			  <!-- Check missing -->
			<?php
				$missing = $this->Fronts_model->check_missing($this->session->userdata('std_cardid') , $item->ver_id); 
				if ($missing[0]->missing >= $item->min_late){
					$alert == 1;
			?>
					<div class="panel-body">
						<div class="alert alert-danger alert-dismissable">
							 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									 <?php echo "คุณขาดเรียน...เกินจำนวน ในรายวิชา : ".$item->maj_id." : ".$item->maj_thai." : ".$item->msg_alert;  ?>
						</div>
					</div>

			<?php } ?>

			<?php endforeach;?>  
			
			<!-- System Alert Dialogbox -->
			<?php if ( $alert == 1) { ?>

			<script>
				$(document).ready(function() {
					$('#myModal').modal('show');
				});
			</script>

			<!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"> <img src="<?php echo base_url();?>assets/images/alert-icon.png"> ระบบแจ้งเตือนการเข้าชั้นเรียน เกินกำหนด</h4>
                                        </div>
                                        <div class="modal-body"> 
											<img src="<?php echo base_url();?>assets/images/service-icon.png">
													เนื่องจากมีการ ขาด/ลา/มาสาย บางรายวิชาเกินกำหนด กรุณาติดต่ออาจารย์ผู้สอน.
										</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
            <!-- /.modal -->

			<?php } ?>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-circle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">ปรกติ</div>
                                    <div>
									<?php 
											$normal = $this->Fronts_model->sum_check_normal( $this->session->userdata('std_cardid') ); 
											print_r($normal[0]->normal);
									?> ครั้ง
									</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"></span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-warning fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">มาสาย</div>
                                    <div>
									<?php 
											$late = $this->Fronts_model->sum_check_late( $this->session->userdata('std_cardid') ); 
											print_r($late[0]->late);
									?>  ครั้ง
									</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"></span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-retweet fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">ลาเรียน</div>
                                    <div>
									<?php 
											$leaves = $this->Fronts_model->sum_check_leaves( $this->session->userdata('std_cardid') ); 
											print_r($leaves[0]->leaves);
									?>  ครั้ง
										
									</div>
                                </div>
                            </div>
                        </div>
						
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"></span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
						
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"> ขาด</div>
                                    <div>
									<?php 
											$missing = $this->Fronts_model->sum_check_missing( $this->session->userdata('std_cardid') ); 
											print_r($missing[0]->missing);
									?>  ครั้ง
																			
									</div>
                                </div>
                            </div>
                        </div>

                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"></span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> ตารางสรุปผลการเช็คประวัติ
                            <div class="pull-right">
							<!-- 
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div> /.row -->
                            </div>
                        </div>
                        <!-- /.panel-heading -->
						
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รหัสวิชา</th>
                                            <th>ชื่อวิชา</th>
                                            <th>ปรกติ</th>
                                            <th>สาย</th>
                                            <th>ลา</th>
                                            <th>ขาด</th>
                                            <th>รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach ($result as $item):?>
                                        <tr>
                                            <td><?php echo $item->ver_id; ?></td>
                                            <td> <a href="<?php echo base_url().'front_profiles/history/'.$item->id.'/'.$item->mid; ?>"> <?php echo $item->maj_id; ?> </a> </td>
                                            <td><?php echo $item->maj_thai; ?></td>
                                            <td><?php  
													$normal = $this->Fronts_model->check_normal($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($normal[0]->normal);
												?>
											</td>
                                            <td> <?php  
													$late = $this->Fronts_model->check_late($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($late[0]->late);
												?>											
											</td>
                                            <td><?php  
													$leaves = $this->Fronts_model->check_leaves($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($leaves[0]->leaves);
												?>	
											</td>
                                            <td><?php  
													$missing = $this->Fronts_model->check_missing($this->session->userdata('std_cardid') , $item->ver_id); 
													print_r($missing[0]->missing);
												?>	
											</td>

                                            <td><?php  
													echo $normal[0]->normal + $late[0]->late + $leaves[0]->leaves + $missing[0]->missing ;
												?>	
											</td>


                                        </tr>
                                        <?php endforeach;?>  

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->

                    </div>
                    <!-- /.panel -->

                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> เช็คชื่อ 5  อันดับล่าสุด
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
							
								<?php foreach ($top_list as $item):?>

								<?php echo ChromePhp::log($item); ?>

                                <a href="#" class="list-group-item"> 
									<?php 
										$des =  mb_substr($item->maj_thai,0,13,'UTF-8'); 
										$log_time =  mb_substr($item->log_time,0,10,'UTF-8'); 
									?>
                                    <i class="fa fa-comment fa-fw"></i> <?php echo $item->maj_id.' '.$des; ?>
                                    <span class="pull-right text-muted small"><em><?php echo $log_time; ?> </em>
                                    </span>
                                </a>
								
								<?php endforeach;?>  
                               
                            </div>
                            <!-- /.list-group 
								<a href="#" class="btn btn-default btn-block">View All Alerts</a>
							-->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                        
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->