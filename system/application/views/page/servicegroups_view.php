<script src="<?= base_url();?>lib/droppable.js" type="text/javascript"></script>

<?php foreach ($servicegroups as $row) {
	?>
<div class="hostgroup">
<div
	id="{&quot;type&quot;:&quot;hostgroup&quot;,&quot;id&quot;:&quot;<?= $row->servicegroup_id; ?>&quot;}"
	class="ui-state-default ui-corner-all droppable">
<div class="hostname"><?= $row->alias; ?></div>
<div class="hostButtons">
<div class="hostExpandServices "
	onclick="editHost(<?= $row->servicegroup_id; ?>)" title="Edit Host"><span
	class="ui-icon ui-icon-folder-open"></span></div>
<div class="hostExpandServices " onclick="javascript:loadHosts();"
	title="Add Hosts"><span class="ui-icon ui-icon-plusthick"></span></div>
<div class="hostExpandServices " onclick="javascript:loadServices();"
	title="Add Services"><span class="ui-icon ui-icon-plusthick"></span></div>
<div class="hostExpandServices" title="Show Services"><span
	class="ui-icon ui-icon-circle-triangle-s"
	id="icon<?= $row->servicegroup_id; ?>"
	onclick="$('icon<?= $row->servicegroup_id;?>').toggleClass('ui-icon-circle-triangle-s').toggleClass('ui-icon-circle-triangle-n');$('#servicegroups<?= $row->servicegroup_id; ?>').toggle();"></span>
</div>
</div>
<br />
<br />
<div class="servicegroups"
	id="servicegroups<?= $row->servicegroup_id; ?>"><?php 
	//We only want to call this if there are hosts in the group
	if (isset($row->HGhosts)) { $this->load->view('part/servicegroups_hosts_view', $row); }
	?></div>
<div class="services" id="services<?= $row->servicegroup_id; ?>"><?php 
//We only want to call this if there are hosts in the group
if (isset($row->HGservices)) { $this->load->view('part/hostgroups_services_view', $row); }
?></div>
</div>
</div>
<?php
}
?>
</div>
