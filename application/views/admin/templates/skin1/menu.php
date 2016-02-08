<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="index.html">Website Admin</a></h1>
			<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="<?php base_url();?>/webapp/front_profiles">Students Site</a></div>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo $this->session->userdata('usr_fname'); ?> </p>
			<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a href="<?php echo base_url()."dashboard";?>">Website Admin</a> 
				
				<div class="breadcrumb_divider"></div> 
				<a href="<?php echo base_url().$this->uri->segment(1);?>" class="current"> <?php echo $this->uri->segment(1); ?></a>
				
				<?php if ($this->uri->segment(2) != "" ) { ?>
					<div class="breadcrumb_divider"></div> 
					<a href="javascript:history.back()">Go Back</a>									
				<?php }  ?>

			</article>
		</div>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<form class="quick_search">
			<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
		</form>
		<hr/>
		
		<?php if ( $this->session->userdata('set_mnu1') == 1 ) { ?>
		<h3>สถิติรายงานข้อมูล</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo base_url();?>statics/index/"">รายงานผลภาพรวม</a></li>
		</ul>
		<?php } ?>


		<?php if ( $this->session->userdata('set_mnu2') == 1 ) { ?>
		<h3>ปฏิทินการเช็คชื่อ</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo base_url();?>verify/calendar/"">ปฏิทินการเช็คชื่อ</a></li>
		</ul>
		<?php } ?>

		<?php if ( $this->session->userdata('set_mnu3') == 1 ) { ?>
		<h3>เช็คประวัติการเรียน</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo base_url();?>verify/list_verify/">ประวัติการเช็คชื่อ</a></li>			
		</ul>
		<?php } ?>

		<?php if ( $this->session->userdata('set_mnu4') == 1 ) { ?>
		<h3>ข้อมูลรายวิชาสอน</h3>
		<ul class="toggle">
			<li class="icn_add_user"><a href="<?php echo base_url();?>verify/add_new/">เพิ่มรายวิชาสอน</a></li>			
			<li class="icn_categories"><a href="<?php echo base_url();?>verify/list_major/">ข้อมูลรายวิชาสอน</a></li>			
		</ul>
		<?php } ?>

		<?php if ( $this->session->userdata('set_mnu5') == 1 ) { ?>
		<h3>ข้อมูลนักศึกษา</h3>
		<ul class="toggle">
			<li class="icn_add_user"><a href="<?php echo base_url();?>student/add_student/">เพิ่มข้อมูลนักศึกษา</a></li>			
			<li class="icn_categories"><a href="<?php echo base_url();?>student/index/">ดูข้อมูลนักศึกษา</a></li>
		</ul>
		<?php } ?>

		<?php if ( $this->session->userdata('set_mnu6') == 1 ) { ?>
		<h3>ข้อมูลผู้ใช้ระบ</h3>
		<ul class="toggle">
			<li class="icn_add_user"><a href="<?php echo base_url();?>user/add_user/">เพิ่มข้อมูลผู้ใช้</a></li>
			<li class="icn_categories"><a href="<?php echo base_url();?>user/index/">ดูข้อมูลผู้ใช้</a></li>
		</ul>
		<?php } ?>

		<?php if ( $this->session->userdata('set_mnu7') == 1 ) { ?>
		<h3>กำหนดภาคเรียน</h3>
		<ul class="toggle">
			<li class="icn_security"><a href="<?php echo base_url();?>setting/term_setting">กำหนดภาคเรียน</a></li>
		</ul>
		<?php } ?>


		<?php if ( $this->session->userdata('set_mnu8') == 1 ) { ?>
		<h3>กำหนดค่าระบบ</h3>
		<ul class="toggle">
			<li class="icn_photo"><a href="<?php echo base_url();?>major/">ข้อมูลรายวิชา</a></li>
			<li class="icn_audio"><a href="<?php echo base_url();?>department/">แผนก/สาขา</a></li>
			<li class="icn_video"><a href="<?php echo base_url();?>year/">ปีการศึกษา</a></li>
		</ul>
		<?php } ?>


		<?php if ( $this->session->userdata('set_mnu9') == 1 ) { ?>

			<h3>ผู้ดูแลระบบ</h3>
			<ul class="toggle">
				<li class="icn_video"><a href="<?php echo base_url();?>setting/">กำหนดสิทธิ์ใช้งาน</a></li>
			</ul>
		<?php } ?>		

		<h3>ออกจากระบบ</h3>
		<ul class="toggle">
			<li class="icn_jump_back"><a href="#" id="mnu_logout" >ออกจากระบบ Logout</a></li>
		</ul>

		<div id="logout" style="display:none; cursor: default"> 
				<header>
					<h2 class="tabs_involved"> <img src="<?php echo base_url();?>assets/images/exit.png">  คุณต้องการที่จะออกจากระบบ? </h2>
				</header>				
				<input type="button" id="yes_logout" value="Yes" /> 
				<input type="button" id="no_logout" value="No" /> 
				<p></p>
		</div> 

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2016 </strong></p>
			<p>ผู้พัฒนา อ.คมสัน โกเสนตอ</p>
			<p>วิจัย วช. งบประมาณ ปี 2558 <a href="http://www.cmru.ac.th">  </a></p>
			<p>วิทยาลัยแม่ฮ่องสอน มหาวิทยาลัยราชภัฏเชียงใหม่</p>
			<center><p></p></center>
			<br><br>
		</footer>
	</aside><!-- end of sidebar -->