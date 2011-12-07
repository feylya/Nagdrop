<div><?php 
$hg = $hostgroup[0];
//$th = $thost[0];
$attributes = array('id'=>'hostgroupForm');
//The form URL doesn't matter (or exist). It's all called through the dialog javascript in core.js
echo form_open('popup/hostgroup/modify', $attributes);
?> <input type="hidden" value="<?= $hg->hostgroup_id; ?>"
	name="hostgroup_id" id="hostgroup_id">

<fieldset><label for="alias"> Name </label> <input name="alias"
	id="alias" value="<?= $hg->alias; ?>" maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text">&nbsp;&nbsp;
</fieldset>
<?php
echo form_close();
?></div>
