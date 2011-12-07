<!-- Need to include the javascript again to make the div draggable -->
<script src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>
<div class="contentMessage ui-state-default ui-corner-all">Services</div>
<?php 
//HostGrouphosts...
if (isset($HGservices)) {
    foreach ($HGservices as $s) {
    	//var_dump($s);
	?>
	
	<div class = "serviceDraggable ui-state-default ui-corner-all" id="host<?= $s->hostgroup_service_id ?>">
	    <img src="<?= base_url(); ?>images/notes.gif" alt="<?=$s->display_name;?>" width="20" height="20">
		<img src="<?= base_url(); ?>images/delete.gif" height=16 width=16 onclick="removeServiceFromHostgroup(<?= $s->hostgroup_service_id; ?>);"/>
	    <br/>
		<?= $s->display_name; ?>
	</div>
	
	<?php
	}
}
?>
