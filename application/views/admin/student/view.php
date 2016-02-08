		<div id="main">
		  <div class="clear"></div>
		  <div class="full_w">
		    <div class="h_title">Manage pages - table</div>
				<?php  $i=1; foreach ($info_student as $info):?>
					<h2>รหัสประจำตัว : <?php echo $info->CardNo; ?> | นาย : <?php echo $info->NAME?> | สาขา : <?php echo $info->DEPTNAME?>  </h2>
				<?php endforeach;?>    
					<p>ข้อมูลการลงเวลานักศึกษา</p>
				
				<div class="entry">
					<div class="sep"></div>
				</div>
				<table>
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Check Time</th>
							<th scope="col">Device Name</th>
							<th scope="col">Card No</th>
							<th scope="col">IP Address</th>
							<th scope="col" style="width: 65px;">Modify</th>
						</tr>
					</thead>
						
					<tbody>
                    
                    <?php  $i=1; foreach ($query as $item):?>
						<tr>
							<td class="align-center"><?php echo $i++; ?></td>
							<td><?php echo $item->CHECKTIME; ?></td>
							<td><?php echo $item->devicename; ?></td>
							<td><?php echo $item->cardno; ?></td>
							<td><?php echo $item->ip; ?></td>
							<td>
								<a href="<?php echo base_url()."student/delete_view_student/".$item->LOGID."/".$user_id; ?>" class="table-icon delete" title="Delete"></a>
							</td>
						</tr>
					<?php endforeach;?>    
                                        
					</tbody>
				</table>
				<div class="entry">
					<div class="pagination">
						<?php echo $this->pagination->create_links(); ?>
					</div>
					<div class="sep"></div>		
					<a class="button add" href="<?php echo base_url()."student/delte_all_view_student"?>">ลบข้อมูลทั้งหมด</a>  
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>