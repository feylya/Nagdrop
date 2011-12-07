<script src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>

<div class="center">
<div class="header">SERVICE GROUPS</div>
<div class="close"><a href="javascript: "
	onclick="$('#groups').removeClass('move'); $('.holder').hide('blind', {}, 500);">Close</a>
</div>
<br />
<?=$pagination;?></div>
<div class="contents"><?php foreach ($menuServicegroups as $s) { ?>
<div
	class="servicegroupsDraggable draggable ui-state-default ui-corner-all"
	title="<?= $s->display_name; ?>"
	id="{&quot;type&quot;:&quot;servicegroup&quot;,&quot;id&quot;:&quot;<?= $s->servicegroup_id; ?>&quot;}">
<img src="<?= base_url(); ?>images/notes.gif"
	alt="<?= $s->display_name; ?>" width="20" height="20"><?= $s->display_name; ?>
</div>
<?php } ?></div>
