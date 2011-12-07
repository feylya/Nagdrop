<div><?php 
$s = $tservice[0];
//$th = $thost;
$attributes = array('id'=>'serviceTemplateForm');
//The form URL doesn't matter (or exist). It's all called through the dialog javascript in core.js
echo form_open('popup/service/modify', $attributes);
?> <input type="hidden" value="<?= $s->tservice_id; ?>"
	name="tservice_id" id="tservice_id">

<fieldset><label for="display_name"> Display name </label> <input
	name="display_name" value="<?= $s->display_name; ?>" id="display_name"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <br>
<?php

//Being really lazy here and using the Code Igniter Select Form Helper

$name = 'check_command_id';
echo form_label('Check Commands', $name);
echo '&nbsp;';
echo form_dropdown($name, $commands, $s->check_command_id);
?>
<fieldset><legend> Enable Checks: </legend> <input
	name="active_checks_enabled" value="1"
	<?php if ($s->active_checks_enabled) { echo 'checked="checked"'; } ?>
	id="active_checks_enabled" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Active Checks <input
	name="passive_checks_enabled" value="1"
	<?php if ($s->passive_checks_enabled) { echo 'checked="checked"'; } ?>
	id="passive_checks_enabled" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Passive Checks <input
	name="event_handler_enabled" value="1"
	<?php if ($s->event_handler_enabled) { echo 'checked="checked"'; } ?>
	id="event_handler_enabled" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Event Handler <input
	name="notifications_enabled" value="1"
	<?php if ($s->notifications_enabled) { echo 'checked="checked"'; } ?>
	id="notifications_enabled" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Notifications <input
	name="obsess_over_service" value="1"
	<?php if ($s->obsess_over_service) { echo 'checked="checked"'; } ?>
	id="obsess_over_service" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Obsess</fieldset>
<fieldset><legend> Notify On: </legend> <input name="notify_on_warning"
	value="1"
	<?php if ($s->notify_on_warning) { echo 'checked="checked"'; } ?>
	id="notify_on_warning" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="notify_on_unknown" value="1"
	<?php if ($s->notify_on_unknown) { echo 'checked="checked"'; } ?>
	id="notify_on_unknown" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unkown <input
	name="notify_on_critical" value="1"
	<?php if ($s->notify_on_critical) { echo 'checked="checked"'; } ?>
	id="notify_on_critical" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Critical <input
	name="notify_on_recovery" value="1"
	<?php if ($s->notify_on_recovery) { echo 'checked="checked"'; } ?>
	id="notify_on_recovery" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Recovery <input
	name="notify_on_flapping" value="1"
	<?php if ($s->notify_on_flapping) { echo 'checked="checked"'; } ?>
	id="notify_on_flapping" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Flapping <input
	name="notify_on_downtime" value="1"
	<?php if ($s->notify_on_downtime) { echo 'checked="checked"'; } ?>
	id="notify_on_downtime" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Downtime</fieldset>
<fieldset><legend> Stalk: </legend> <input name="stalk_on_warning"
	value="1"
	<?php if ($s->stalk_on_warning) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->stalk_on_warning== 't') { echo 't_'; }?>stalk_on_warning"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="stalk_on_unknown" value="1"
	<?php if ($s->stalk_on_unknown) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->stalk_on_unknown== 't') { echo 't_'; }?>stalk_on_unknown"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unreachable <input
	name="stalk_on_critical" value="1"
	<?php if ($s->stalk_on_critical) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->stalk_on_critical== 't') { echo 't_'; }?>stalk_on_critical"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Up</fieldset>
<fieldset><legend> Flap Detection </legend> <input
	name="flap_detection_enabled" value="1"
	<?php if ($s->flap_detection_enabled) { echo 'checked="checked"'; } ?>
	id="flap_detection_enabled" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Enabled <input
	name="flap_detection_on_ok" value="1"
	<?php if ($s->flap_detection_on_ok) { echo 'checked="checked"'; } ?>
	id="flap_detection_on_ok" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="flap_detection_on_warning" value="1"
	<?php if ($s->flap_detection_on_warning) { echo 'checked="checked"'; } ?>
	id="flap_detection_on_warning" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="flap_detection_on_unknown" value="1"
	<?php if ($s->flap_detection_on_unknown) { echo 'checked="checked"'; } ?>
	id="flap_detection_on_unknown" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unreachable <input
	name="flap_detection_on_critical" value="1"
	<?php if ($s->flap_detection_on_critical) { echo 'checked="checked"'; } ?>
	id="flap_detection_on_critical" style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Up</fieldset>
<fieldset><legend> Misc </legend> <label for="notes"> Notes </label>&nbsp;
<input name="notes" value="<?= $s->notes; ?>" id="notes" maxlength="100"
	size="20" class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <label for="notes_url">
Notes URL </label>&nbsp; <input name="notes_url"
	value="<?= $s->notes_url; ?>" id="notes_url" maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp;<br />
<label for="icon_image"> Icon Image </label>&nbsp; <input
	name="icon_image" value="<?= $s->icon_image; ?>" id="icon_image"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <label
	for="icon_image_alt"> Icon Image Alt </label>&nbsp; <input
	name="icon_image_alt" value="<?= $s->icon_image_alt; ?>"
	id="icon_image_alt" maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp;</fieldset>
</fieldset>
	<?php
	echo form_close();

	?></div>
