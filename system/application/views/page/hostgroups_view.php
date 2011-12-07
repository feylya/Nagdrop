<script src="<?= base_url();?>lib/droppable.js" type="text/javascript"></script>
<center><a href="javascript:editHostgroup('0')">Add Hostgroup</a></center>

<?php foreach ($hostgroups as $row) {
	?>
<div class="hostgroup" id="hostgroup<?= $row->hostgroup_id; ?>">
<div
	id="{&quot;type&quot;:&quot;hostgroup&quot;,&quot;id&quot;:&quot;<?= $row->hostgroup_id; ?>&quot;}"
	class="ui-state-default ui-corner-all droppable">
<div class="hostname"><?= $row->alias; ?></div>
<div class="hostButtons">
<div class="hostExpandServices "
	onclick="editHostgroup(<?= $row->hostgroup_id; ?>)" title="Edit Host">
<span class="ui-icon ui-icon-folder-open"></span></div>
<div class="hostExpandServices " onclick="javascript:loadHosts();"
	title="Add Hosts"><span class="ui-icon ui-icon-plusthick"></span></div>
<div class="hostExpandServices " onclick="javascript:loadServices();"
	title="Add Services"><span class="ui-icon ui-icon-plusthick"></span></div>
<div class="hostExpandServices" title="Show Services"><span
	class="ui-icon ui-icon-circle-triangle-s"
	id="icon<?= $row->hostgroup_id; ?>"
	onclick="javascript: hostgroupShowHosts('hosts<?= $row->hostgroup_id; ?>', <?= $row->hostgroup_id; ?>); hostgroupShowServices('services<?= $row->hostgroup_id; ?>', <?= $row->hostgroup_id; ?>); $('#hostgroupHolder<?= $row->hostgroup_id; ?>').toggle();"></span>
</div>
</div>
<br />
<br />
<div class="hostgroupHolder"
	id="hostgroupHolder<?= $row->hostgroup_id; ?>">
<div class="hosts" id="hosts<?= $row->hostgroup_id; ?>"></div>
<div class="services" id="services<?= $row->hostgroup_id; ?>""></div>
</div>
</div>
</div>
	<?php
}
?>
