<script src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>

<div class="center">
<div class="header">HOSTGROUPS</div>
<div class="close"><a href="javascript: "
	onclick="$('#groups').removeClass('move'); $('.holder').hide('blind', {}, 500);">Close</a>
</div>
<br />
<?=$pagination;?></div>
<div class="contents"><?php foreach ($menuHostgroups as $h) { ?>
<div
	class="hostgroupsDraggable draggable ui-state-default ui-corner-all"
	id="{&quot;type&quot;:&quot;hostgroup&quot;,&quot;id&quot;:&quot;<?= $h->hostgroup_id; ?>&quot;}">
<img src="<?= base_url(); ?>images/notes.gif" alt="<?=$h->alias;?>"
	width="20" height="20"> <br />
<?= $h->alias; ?></div>
<?php } ?></div>
