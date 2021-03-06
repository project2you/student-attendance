<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Profile Student</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
							<a href=""<?php echo base_url();?>front_profiles/student_edit"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                       
                        <li class="divider"></li>
                        <li>
							<a href="<?php echo base_url();?>front_profiles/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="<?php echo base_url();?>front_profiles/dashboard"><i class="fa fa-dashboard fa-fw"></i> หน้าหลัก</a>
                        </li>


                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> ข้อมูลผู้ใช้ <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url();?>front_profiles/student_edit">แก้ไขข้อมูล</a>
                                </li>
                                <li>
									<a href="<?php echo base_url();?>front_profiles/student_password">เปลี่ยนรหัสผ่าน</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="<?php echo base_url();?>front_profiles/student_notify"><i class="fa fa-sitemap fa-fw"></i> การแจ้งเตือน</a>
                            <!-- /.nav-second-level -->
                        </li>
						
                        <li>
                            <a href="<?php echo base_url();?>front_profiles/student_graph"><i class="fa fa-bar-chart-o fa-fw"></i>ภาพรวมสถิติ</a>
                            <!-- /.nav-second-level -->
                        </li>
						
                        <li>
                            <a href="<?php echo base_url();?>front_profiles/logout"><i class="fa fa-files-o fa-fw"></i> ออกจากระบบ Logout</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
