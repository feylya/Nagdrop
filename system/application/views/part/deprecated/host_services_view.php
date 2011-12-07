<!-- Need to include the javascript again to make the div draggable -->
<script src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>
	<?php 
	if ($service) {
		foreach ($service as $s)
		{?>
			<div class="service ui-corner-all" id="<?= $s->service_host_id; ?>"> 
	            <div class="serviceName">
	            	<img src="<?= base_url(); ?>images/delete.gif" height=16 width=16 onclick="removeService(<?= $s->service_host_id; ?>);"/>
					<?= $s->display_name; ?>
				</div>
			</div>
			
		<?php
		}
	}?>

&nbsp;<br />	
	
<!--	
//Storing the original for now
//REMOVE!

<div class="service">
        <div class="serviceName">Service</div>	
        <div class="serviceStatusText odd">Status</div>
        <div class="serviceCheckTime">Last Check</div>
        <div class="servicePeriod odd">Duration</div>
        <div class="serviceCheck">Check</div>
        <div class="serviceInformation odd">Status Information</div>
    </div>

	<?php 
	if ($service) {
		foreach ($service as $s)
		{?>
			<div class="service" id="<?= $s->service_host_id; ?>">        
	            <div class="serviceName">
	            	<img src="<?= base_url(); ?>images/delete.gif" height=16 width=16 onclick="removeService(<?= $s->service_host_id; ?>);"/>
					<?= $s->display_name; ?>
				</div>	
	            <div class="serviceStatusText odd">CRITICAL</div>
	            <div class="serviceCheckTime">12-29-2009 20:12:01</div>
	            <div class="servicePeriod odd">47d 6h 55m 27s</div>
	            <div class="serviceCheck">1/3</div>
	            <div class="serviceInformation odd">PING CRITICAL - Packet loss = 100% </div>
			</div>
			
		<?php
		}
	}?>
	-->