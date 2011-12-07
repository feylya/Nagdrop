<!-- Need to include the javascript again to make the div draggable -->
<script
	src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>
<div class="contentMessage ui-state-default ui-corner-all">Hostgroups</div>
<?php
//HostGrouphosts...
if (isset($hostgroups)) {
	foreach ($hostgroups as $hg) {
		//var_dump($s);
		?>

<div class="serviceDraggable ui-state-default ui-corner-all"
	id="hostgroup<?= $hg->div_id ?>"><img
	src="<?= base_url(); ?>images/notes.gif" alt="<?=$hg->display_name;?>"
	width="20" height="20"> <img src="<?= base_url(); ?>images/delete.gif"
	height=16 width=16
	onclick="javascript: <?=$javascript;?>('hostgroup<?= $hg->div_id ?>', <?= $hg->div_id; ?>, <?=$hg->owner_id;?>);" />
<br />
		<?= $hg->display_name; ?></div>

		<?php
	}
}
?>
