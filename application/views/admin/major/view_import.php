<section id="main" class="column">
		
		<!-- 
		<article class="module width_full">
			<header><h3>Stats</h3></header>
			<div class="module_content">
			
				<div class="clear"></div>
			</div>
		</article>
		end of stats article -->
		
		<article class="module width_full">

		<header><h3 class="tabs_involved"> Import Files </h3>

		</header>


		<div class="tab_container">
			<div id="tab1" class="tab_content">
			<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
    				<th style="width:5%;" >No.</th> 
    				<th style="width:10%;" >รหัสวิชา</th> 
					<th style="width:10%;" >ชื่อวิชาไทย</th> 
					<th style="width:10%;" >ชื่อภาษาอังกฤษ</th> 
					<th style="width:10%;" >คำอธิบาย</th> 
    				<th style="width:5%;">หน่วยกิจ</th> 
    				<th style="width:5%;" >ปี.</th>  
					<th style="width:5%;" >เทอม.</th>    
				</tr> 
			</thead> 
		
			<tbody> 
                    <?php  $i=1; foreach ($sheetData as $item):?>
						<tr>
							<td><?php echo $sheetData[$i]['A']; ?></td>
							<td><?php echo $sheetData[$i]['B']; ?></td>
							<td><?php echo $sheetData[$i]['C']; ?></td>
							<td><?php echo $sheetData[$i]['D']; ?></td>
							<td><?php echo $sheetData[$i]['E']; ?></td>
							<td><?php echo $sheetData[$i]['F']; ?></td>
							<td><?php echo $sheetData[$i]['G']; ?></td>
							<td><?php echo $sheetData[$i]['H']; ?></td>

					<?php $i++; endforeach;?>    

			</tbody> 
			</table>
			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->

			<footer>
				<div class="submit_link">
					<input type="submit" onclick="location.href='<?php echo $base_url."save_import/";?>';"  value="บันทึกข้อมูล" class="alt_btn">
					<input type="submit" onclick="location.href='<?php echo $base_url."index/";?>';" value="ยกเลิก">
				</div>
			</footer>
			
		</article><!-- end of content manager article -->
	

		<div class="clear"></div>

			
		<br>

		<section>
			<nav role="navigation">
				<?php 
					if ($this->session->userdata('flag_major') == 0 ){
						echo $this->pagination->create_links(); 
					}
				?>
			</nav>
		</section>
