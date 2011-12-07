<script src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>

<div class="center">
<div class="header">SERVICES</div>
<div class="close"><a href="javascript: "
	onclick="$('#groups').removeClass('move'); $('.holder').hide('blind', {}, 500);">Close</a>
</div>
<br />
<?=$pagination;?></div>
<div class="contents"><?php foreach ($menuServices as $s) { ?>
<div class="serviceDraggable draggable ui-state-default ui-corner-all"
	title="<?= $s->display_name; ?>"
	id="{&quot;type&quot;:&quot;service&quot;,&quot;id&quot;:&quot;<?= $s->service_id; ?>&quot;}">
<img src="<?= base_url(); ?>images/notes.gif"
	alt="<?= $s->display_name; ?>" width="20" height="20"><?= $s->display_name; ?>
</div>
<?php } ?></div>
