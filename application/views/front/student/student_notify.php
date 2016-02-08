 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Notify</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
								การแจ้งเตือน
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                   

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
                                            
											<th>สถานะสาย</th>
                                            <th>สถานะลา</th>
                                            <th>สถานะขาด</th>


                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
										
										foreach ($result as $item):
										
										?>
                                        <tr>
                                            <td><?php echo $item->ver_id; ?></td>
                                            <td><?php echo $item->maj_id; ?></td>
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

                                            <td><?php
													
													if ( $late[0]->late > $item->min_late ) {  
														echo ' <button type="button" class="btn btn-danger">Danger</button>' ;
													} else if ( $late[0]->late ==  $item->min_late ) { 
														echo '<button type="button" class="btn btn-warning">Warning</button>';
													} else {
														echo ' <button type="button" class="btn btn-success">Normal</button>';
													}														
											?> </td>

                                            <td><?php
													
													if ( $leaves[0]->leaves == $item->min_leave ) {  
														echo ' <button type="button" class="btn btn-danger">Danger</button>' ;
													} else { 
														echo ' <button type="button" class="btn btn-success">Normal</button>';
														}														
											?> </td>


                                            <td><?php
													
													if ( $missing[0]->missing == $item->min_missing ) {  
														echo ' <button type="button" class="btn btn-danger">Danger</button>' ;
													} else { 
														echo ' <button type="button" class="btn btn-success">Normal</button>';
														}														
											?> </td>

                                        </tr>
                                        <?php endforeach;?>  

                                    </tbody>
                                </table>


                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
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