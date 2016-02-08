 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
								แก้ไขข้อมูล
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                   <form role="form" id ="profileForm" action="<?php echo base_url()."front_profiles/update_profiles"?>" method="post" enctype="multipart/form-data">

										<div class="form-group">
                                            <label>รหัสประจำตัว</label>
                                            <input class="form-control" name="std_cardid" value="<?php echo $list_student[0]->std_cardid; ?>" disabled >
                                        </div>
										
										<div class="form-group">
                                            <label>ชื่อนักศึกษา</label>
                                            <input class="form-control" name="std_fname" value="<?php echo $list_student[0]->std_fname; ?>" >
                                        </div>

										<div class="form-group">
                                            <label>นามสกุล</label>
                                            <input class="form-control" name="std_lname" value="<?php echo $list_student[0]->std_lname; ?>" >
                                        </div>

										<div class="form-group">
                                            <label>เพศ</label>
											 
											 <div class="form-group">
                                                <select id="disabledSelect" name="std_gender" class="form-control">
                                                    <option value=1>ชาย</option>
													<option value=2>หญิง</option>
                                                </select>
                                            </div>

                                        </div>

										<div class="form-group">
                                            <label>วัน เดือน ปี เกิด</label>
                                            <input class="form-control" name="std_birthday" value="<?php echo $list_student[0]->std_birthday ; ?>" >
                                        </div>

										<div class="form-group">
                                            <label>แผนก</label>
                                            <input class="form-control" value="<?php echo $list_student[0]->dep_thai ; ?>" disabled >
                                        </div>


										<div class="form-group">
                                            <label>ปีการศึกษา</label>
                                            <input class="form-control" value="<?php echo $list_student[0]->yea_title ; ?>" disabled >
                                        </div>


										<div class="form-group">
                                            <label>อีเมล์</label>
                                            <input class="form-control" name="std_email" value="<?php echo $list_student[0]->std_email; ?>" >
                                        </div>

										<div class="form-group">
                                            <label>ที่อยู่</label>
                                             <textarea class="form-control" name="std_address" rows="3"><?php echo $list_student[0]->std_address; ?> </textarea> 
                                        </div>


										<div class="form-group">
                                            <label>เบอร์โทร</label>
                                            <input class="form-control" name="std_tel" value="<?php echo $list_student[0]->std_tel; ?>" >
                                        </div>

										<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>


                                      </form>
                                </div>


                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    <h1>รูปภาพ</h1>

									<img id ="my_image" src="<?php echo base_url()."assets/uploads/photo/".$list_student[0]->std_picture; ?>" alt="Smiley face">
									
                                   <form id ="myForm" action="<?php echo base_url()."front_profiles/update_picture"?>" method="post" enctype="multipart/form-data">
                                        <fieldset>

											 <p></p>

											 <input type="file" size="60" name="myfile">
											
											 <div>
											 <p></p>
												<button type="submit" class="btn btn-primary">บันทึกรูปภาพ</button>
											 </div>

											 <div id="progress">
												<div id="bar"></div>
												<div id="percent">0%</div >
											</div>
											
											<br/>
										 
											<div id="message"></div>

                                        </fieldset>
                                    </form>

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