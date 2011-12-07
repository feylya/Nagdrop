<!-- Need to reinclude the javascript to make the Div's droppable -->
<script
	src="<?= base_url();?>lib/droppable.js" type="text/javascript"></script>
<center><a href="javascript:editServiceTemplate('0')">Add Service
Template</a></center>

<?php
foreach ($tservices as $row) {
	?>
<div class="service" id="service<?= $row->tservice_id; ?>">
<div
	id="{&quot;type&quot;:&quot;service&quot;,&quot;id&quot;:&quot;<?= $row->tservice_id; ?>&quot;}"
	class="ui-state-default ui-corner-all droppable">
<div class="serviceName"><?= $row->display_name; ?></div>
<div class="hostButtons">
<div class="hostExpandServices "
	onclick="editServiceTemplate(<?= $row->tservice_id; ?>)"
	title="Edit Service Template"><span class="ui-icon ui-icon-folder-open"></span>
</div>
<div class="hostExpandServices" title="Show Services"><span
	class="ui-icon ui-icon-circle-triangle-s"
	id="icon<?= $row->tservice_id; ?>"
	onclick="javascript: $('#serviceHolder<?= $row->tservice_id; ?>').toggle(); tserviceShowServices('serviceHolder<?= $row->tservice_id; ?>', <?= $row->tservice_id; ?>); "></span>
</div>
</div>
<br />
<br />
<div id="serviceHolder<?= $row->tservice_id; ?>" class="serviceHolder">
<div class="hosts" id="hosts<?= $row->tservice_id; ?>"></div>
<div class="hostgroups" id="hostgroups<?= $row->tservice_id; ?>"></div>
</div>
</div>
</div>
	<?php } ?>
