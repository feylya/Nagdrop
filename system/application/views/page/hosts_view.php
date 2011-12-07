<!-- Need to reinclude the javascript to make the Div's droppable -->
<script
	src="<?= base_url();?>lib/droppable.js" type="text/javascript"></script>
<center><a href="javascript:editHost('0')">Add Host</a></center>
<?php
foreach ($hosts as $row) {

	?>
<div class="host " id="host<?= $row->host_id; ?>">
<div
	id="{&quot;type&quot;:&quot;host&quot;,&quot;id&quot;:&quot;<?= $row->host_id; ?>&quot;}"
	class="ui-state-default ui-corner-all droppable">
<div class="hostname"><?= $row->display_name; ?> (<?= $row->alias; ?>)
<div class="images"><img
	src="<?= base_url(); ?>images/logos/<?= $row->icon_image; ?>" height=20
	width=20 /></div>
</div>
<!--<div style="height:90%; float: left; font-size: 8px;">
			<div>5 OK</div>
			<div>2 WARNING</div>
			<div>1 CRITICAL</div>
			<div>0 UNKNOWN</div>
			</div>-->

<div
	class=<?php switch ($row->current_state) 
	{
		case NULL:
			echo '"hostStatus">';
			break;
		case 0:
			echo '"hostStatus up">';
			break;
		case 1:
			echo '"hostStatus critical">';
			break;
		case 2:
			echo '"hostStatus critical">';
			break;
	}?>
	<div class="hostCondition">
                    <div class="hostStatusText">
                        <?= $row->current_state_friendly; ?>
                    </div>
	<div class="hostStatusInformation">
                        <?= $row->output; ?>
                    </div></div>
<br />
<div class="hostTime">
<div class="hostStatusPeriod"><em>Since </em> <?= $row->last_state_change; ?>
</div>
<div class="hostStatusCheckTime"><em>Last Check </em> <?= $row->status_update_time; ?>
</div>
</div>
</div>
<div class="hostButtons">
<div class="hostExpandServices "
	onclick="editHost(<?= $row->host_id; ?>)" title="Edit Host"><span
	class="ui-icon ui-icon-folder-open"></span></div>
<div class="hostExpandServices " onclick="javascript:loadHostgroups();"
	title="Add Hostgroups"><span class="ui-icon ui-icon-plusthick"></span>
</div>
<div class="hostExpandServices " onclick="javascript:loadServices();"
	title="Add Services"><span class="ui-icon ui-icon-plusthick"></span></div>
<div class="hostExpandServices" id="button<?= $row->host_id; ?>"
	title="Show Services"><span class="ui-icon ui-icon-circle-triangle-s"
	id="icon<?= $row->host_id; ?>"
	onclick="javascript: $('#hostHolder<?= $row->host_id; ?>').toggle(); hostShowServices('services<?= $row->host_id; ?>', <?= $row->host_id; ?>); hostShowHostgroups('hostgroups<?= $row->host_id; ?>', <?= $row->host_id; ?>); "></span>
</div>
</div>
<div class="hostHolder" id="hostHolder<?= $row->host_id; ?>">
<div class="services ui-corner-bottom"
	id="services<?= $row->host_id; ?>"><?php //$this->load->view('part/host_services_view', $services[$row->host_id]); ?>
</div>
<div class="hostgroups ui-corner-bottom"
	id="hostgroups<?= $row->host_id; ?>"><!-- here goes the hostgroup list -->
</div>
</div>
</div>
</div>
                        <?php } ?>


