<!-- Need to include the javascript again to make the div draggable -->
<script
	src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>
<div class="contentMessage ui-state-default ui-corner-all">Services</div>
<?php
//HostGrouphosts...
if (isset($services)) {
	foreach ($services as $s) {
		//var_dump($s);
		?>

<div class="serviceDraggable ui-state-default ui-corner-all"
	id="service<?= $s->div_id ?>"><img
	src="<?= base_url(); ?>images/notes.gif" alt="<?=$s->display_name;?>"
	width="20" height="20"> <img src="<?= base_url(); ?>images/delete.gif"
	height=16 width=16
	onclick="javascript: <?=$javascript;?>('service<?= $s->div_id ?>',<?= $s->div_id; ?>, <?=$s->owner_id;?>);" />
<br />
		<?= $s->display_name; ?></div>

		<?php
	}
}
?>
