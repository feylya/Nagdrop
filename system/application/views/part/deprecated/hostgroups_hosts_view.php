<!-- Need to include the javascript again to make the div draggable -->
<script src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>
<div class="contentMessage ui-state-default ui-corner-all">Hosts</div>
<?php 
//HostGrouphosts...
if (isset($HGhosts)) {
    foreach ($HGhosts as $h) {
	?>
	<div class = "hostDraggable ui-state-default ui-corner-all" id="host<?= $h->hostgroup_member_id; ?>">
	    <img src="<?= base_url(); ?>images/logos/<?= $h->icon_image;?>" alt="<?=$h->alias;?>" width="20" height="20">
		<img src="<?= base_url(); ?>images/delete.gif" height=16 width=16 onclick="removeServiceFromHostgroup(<?= $h->hostgroup_member_id; ?>);"/>
	    <br/>
		<?= $h->alias; ?>
	</div>
	
	<?php
	}
}
?>
