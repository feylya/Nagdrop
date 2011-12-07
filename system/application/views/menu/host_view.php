<script src="<?= base_url();?>lib/draggable.js" type="text/javascript"></script>

<div class="center">
<div class="header">HOSTS</div>
<div class="close"><a href="javascript: "
	onclick="$('#groups').removeClass('move'); $('.holder').hide('blind', {}, 500);">Close</a>
</div>
<br />
<?=$pagination;?></div>
<div class="contents"><?php foreach ($menuHosts as $h) { ?>
<div class="hostDraggable draggable ui-state-default ui-corner-all"
	id="{&quot;type&quot;:&quot;host&quot;,&quot;id&quot;:&quot;<?= $h->host_id; ?>&quot;}">
<img src="<?= base_url(); ?>images/logos/<?= $h->icon_image;?>"
	alt="<?=$h->display_name;?>" width="20" height="20"> <br />
<?= $h->display_name; ?></div>
<?php } ?></div>
