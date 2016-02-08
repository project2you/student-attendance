
<section id="main" class="column">

		<?php

		if($this->session->flashdata('message') != ''){
			 
			 echo '<h4 class="alert_success">'.$this->session->flashdata('message').' </h4>';
		}

		?>
		
		<!-- 
		<article class="module width_full">
			<header><h3>Stats</h3></header>
			<div class="module_content">
			
				<div class="clear"></div>
			</div>
		</article>
		end of stats article -->
		
		<article class="module width_full">

		<header><h3 class="tabs_involved"> Verify Managment </h3>

		<ul class="tabs">
    		<li><a href="#tab1">Calendar</a></li>
		</ul>

		</header>

		<div class="tab_container">
			<div id="tab1" class="tab_content">

					<div id="verify_calendar" style="width: auto; margin: 0 auto">
					
					</div>

			</div><!-- end of #tab1 -->
			
		</div><!-- end of .tab_container -->
		
		<footer>	
				
		</footer>

		</article><!-- end of content manager article -->

		<div class="clear"></div>
		
		<br>

		<section>
			<nav role="navigation">
				
			</nav>
		</section>