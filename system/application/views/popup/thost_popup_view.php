<div><?php 
$th = $thost[0];
//$th = $thost[0];
$attributes = array('id'=>'hostForm');
//The form URL doesn't matter (or exist). It's all called through the dialog javascript in core.js
echo form_open('popup/host/modify', $attributes);
?> <input type="hidden" value="<?= $th->thost_id; ?>" name="thost_id"
	id="thost_id">
<fieldset><label for="thost_name"> Template name </label> <input
	name="thost_name" value="<?= $th->thost_name; ?>" id="thost_name"
	maxlength="100" size="100"
	class="select ui-widget-content ui-corner-all" type="text">&nbsp; <br>
<?php
//Being really lazy here and using the Code Igniter Select Form Helper
$name = 'check_command_id';
echo form_label('Check Commands', $name);
echo '&nbsp;';
echo form_dropdown($name, $commands, $th->check_command_id);
?>
<fieldset><legend> Enable Checks: </legend> <input
	name="active_checks_enabled" value="1"
	<?php if ($th->active_checks_enabled) { echo 'checked="checked"'; } ?>
	id="active_checks_enabled" style="margin: 1px;" type="checkbox">Active
Checks <input name="passive_checks_enabled" value="1"
<?php if ($th->passive_checks_enabled) { echo 'checked="checked"'; } ?>
	id="passive_checks_enabled" style="margin: 1px;" type="checkbox">Passive
Checks <input name="event_handler_enabled" value="1"
<?php if ($th->event_handler_enabled) { echo 'checked="checked"'; } ?>
	id="event_handler_enabled" style="margin: 1px;" type="checkbox">Event
Handler <input name="notifications_enabled" value="1"
<?php if ($th->notifications_enabled) { echo 'checked="checked"'; } ?>
	id="notifications_enabled" style="margin: 1px;" type="checkbox">Notifications
<input name="obsess_over_host" value="1"
<?php if ($th->obsess_over_host) { echo 'checked="checked"'; } ?>
	id="obsess_over_host" style="margin: 1px;" type="checkbox">Obsess</fieldset>
<fieldset><legend> Notify On: </legend> <input name="notify_on_down"
	value="1"
	<?php if ($th->notify_on_down) { echo 'checked="checked"'; } ?>
	id="notify_on_down" style="margin: 1px;" type="checkbox">Down <input
	name="notify_on_unreachable" value="1"
	<?php if ($th->notify_on_unreachable) { echo 'checked="checked"'; } ?>
	id="notify_on_unreachable" style="margin: 1px;" type="checkbox">Unreachable
<input name="notify_on_recovery" value="1"
<?php if ($th->notify_on_recovery) { echo 'checked="checked"'; } ?>
	id="notify_on_recovery" style="margin: 1px;" type="checkbox">Recovery <input
	name="notify_on_flapping" value="1"
	<?php if ($th->notify_on_flapping) { echo 'checked="checked"'; } ?>
	id="notify_on_flapping" style="margin: 1px;" type="checkbox">Flapping <input
	name="notify_on_downtime" value="1"
	<?php if ($th->notify_on_downtime) { echo 'checked="checked"'; } ?>
	id="notify_on_downtime" style="margin: 1px;" type="checkbox">Downtime</fieldset>
<fieldset><legend> Stalk: </legend> <input name="stalk_on_down"
	value="1"
	<?php if ($th->stalk_on_down) { echo 'checked="checked"'; } ?>
	id="stalk_on_down" style="margin: 1px;" type="checkbox">Down <input
	name="stalk_on_unreachable" value="1"
	<?php if ($th->stalk_on_unreachable) { echo 'checked="checked"'; } ?>
	id="stalk_on_unreachable" style="margin: 1px;" type="checkbox">Unreachable
<input name="stalk_on_up" value="1"
<?php if ($th->stalk_on_up) { echo 'checked="checked"'; } ?>
	id="stalk_on_up" style="margin: 1px;" type="checkbox">Up</fieldset>
<fieldset><legend> Flap Detection </legend> <input
	name="flap_detection_enabled" value="1"
	<?php if ($th->flap_detection_enabled) { echo 'checked="checked"'; } ?>
	id="flap_detection_enabled" style="margin: 1px;" type="checkbox">Enabled
<input name="flap_detection_on_down" value="1"
<?php if ($th->flap_detection_on_down) { echo 'checked="checked"'; } ?>
	id="flap_detection_on_down" style="margin: 1px;" type="checkbox">Down <input
	name="flap_detection_on_unreachable" value="1"
	<?php if ($th->flap_detection_on_unreachable) { echo 'checked="checked"'; } ?>
	id="flap_detection_on_unreachable" style="margin: 1px;" type="checkbox">Unreachable
<input name="flap_detection_on_up" value="1"
<?php if ($th->flap_detection_on_up) { echo 'checked="checked"'; } ?>
	id="flap_detection_on_up" style="margin: 1px;" type="checkbox">Up</fieldset>
<fieldset><legend> Misc </legend> <label for="notes"> Notes </label>&nbsp;
<input name="notes" value="<?= $th->notes; ?>" id="notes"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text">&nbsp; <label
	for="notes_url"> Notes URL </label>&nbsp; <input name="notes_url"
	value="<?= $th->notes_url; ?>" id="notes_url" maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text">&nbsp;<br />
<label for="icon_image"> Icon Image </label>&nbsp; <input
	name="icon_image" value="<?= $th->icon_image; ?>" id="icon_image"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text">&nbsp; <label
	for="icon_image_alt"> Icon Image Alt </label>&nbsp; <input
	name="icon_image_alt" value="<?= $th->icon_image_alt; ?>"
	id="icon_image_alt" maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text">&nbsp;</fieldset>
</fieldset>
<?php
echo form_close();

?></div>
