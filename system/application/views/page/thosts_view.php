<script src="<?= base_url();?>lib/droppable.js" type="text/javascript"></script>

<center><a href="javascript:editHostTemplate('0')">Add Host Template</a></center>
<?php
foreach ($thosts as $row) {

	?>
<div class="host " id="thost<?= $row->thost_id; ?>">
<div
	id="{&quot;type&quot;:&quot;thost&quot;,&quot;id&quot;:&quot;<?= $row->thost_id; ?>&quot;}"
	class="ui-state-default ui-corner-all droppable">
<div class="hostname"><?= $row->thost_name; ?>
<div class="images"><img
	src="<?= base_url(); ?>images/logos/<?= $row->icon_image; ?>" height=20
	width=20 /></div>
</div>
<div class="hostButtons">
<div class="hostExpandServices "
	onclick="editHostTemplate(<?= $row->thost_id; ?>)"
	title="Edit Host Template"><span class="ui-icon ui-icon-folder-open"></span>
</div>
<div class="hostExpandServices" id="button<?= $row->thost_id; ?>"
	title="Show Hosts"><span class="ui-icon ui-icon-circle-triangle-s"
	id="icon<?= $row->thost_id; ?>"
	onclick="javascript: $('#hostHolder<?= $row->thost_id; ?>').toggle(); thostShowHosts('hostHolder<?= $row->thost_id; ?>', <?= $row->thost_id; ?>); "></span>
</div>
</div>
<div class="hostHolder" id="hostHolder<?= $row->thost_id; ?>"></div>
</div>
</div>
	<?php } ?>


