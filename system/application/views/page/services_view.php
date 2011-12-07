<!-- Need to reinclude the javascript to make the Div's droppable -->
<script
	src="<?= base_url();?>lib/droppable.js" type="text/javascript"></script>
<center><a href="javascript:editService('0')">Add Service</a></center>

<?php
foreach ($services as $row) {
	?>
<div class="service" id="service<?= $row->service_id; ?>">
<div
	id="{&quot;type&quot;:&quot;service&quot;,&quot;id&quot;:&quot;<?= $row->service_id; ?>&quot;}"
	class="ui-state-default ui-corner-all droppable">
<div class="serviceName"><?= $row->display_name; ?></div>
<div class="hostButtons">
<div class="hostExpandServices "
	onclick="editService(<?= $row->service_id; ?>)" title="Edit Service"><span
	class="ui-icon ui-icon-folder-open"></span></div>
<div class="hostExpandServices " onclick="javascript:loadHostgroups();"
	title="Add Hostgroups"><span class="ui-icon ui-icon-plusthick"></span>
</div>
<div class="hostExpandServices " onclick="javascript:loadHosts();"
	title="Add Hosts"><span class="ui-icon ui-icon-plusthick"></span></div>
<div class="hostExpandServices" title="Show Services"><span
	class="ui-icon ui-icon-circle-triangle-s"
	id="icon<?= $row->service_id; ?>"
	onclick="javascript: $('#serviceHolder<?= $row->service_id; ?>').toggle();serviceShowHosts('hosts<?= $row->service_id; ?>', <?= $row->service_id; ?>); serviceShowHostgroups('hostgroups<?= $row->service_id; ?>', <?= $row->service_id; ?>);"></span>
</div>
</div>
<br />
<br />
<div id="serviceHolder<?= $row->service_id; ?>" class="serviceHolder">
<div class="hosts" id="hosts<?= $row->service_id; ?>"></div>
<div class="hostgroups" id="hostgroups<?= $row->service_id; ?>"></div>
</div>
</div>
</div>
	<?php } ?>
</div>


