<div><?php 
$h = $host[0];
//$th = $thost[0];
$attributes = array('id'=>'hostForm');
//The form URL doesn't matter (or exist). It's all called through the dialog javascript in core.js
echo form_open('popup/host/modify', $attributes);
?> <input type="hidden" value="<?= $h->host_id[1]; ?>" name="host_id"
	id="host_id"> <!--<input type="hidden" value="<?= $h->thost_id[1]; ?>" name="thost_id" id="thost_id">-->

<fieldset><label
	for="<?php if ($h->display_name[0] == "t") { echo 't_'; }?>display_name">
Display name </label> <input
	name="<?php if ($h->display_name[0]== "t") { echo 't_'; }?>display_name"
	value="<?= $h->display_name[1]; ?>"
	id="<?php if ($h->display_name[0] == "t") { echo 't_'; }?>display_name"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <label
	for="<?php if ($h->alias[0]== "t") { echo 't_'; }?>alias"> Alias </label>
<input name="<?php if ($h->alias[0]== "t") { echo 't_'; }?>alias"
	value="<?= $h->alias[1]; ?>"
	id="<?php if ($h->alias[0]== "t") { echo 't_'; }?>alias"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <label
	for="<?php if ($h->address[0]== "t") { echo 't_'; }?>address"> Address
</label> <input
	name="<?php if ($h->address[0]== "t") { echo 't_'; }?>address"
	value="<?= $h->address[1]; ?>"
	id="<?php if ($h->address[0]== "t") { echo 't_'; }?>address"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <br>
<?php
echo form_label('Template Name', 'thost_id');
echo '&nbsp;&nbsp;';
echo form_dropdown('thost_id', $hostTemplates, $h->thost_id[1]);
echo "<br />\n";

//Being really lazy here and using the Code Igniter Select Form Helper
if ($h->check_command_id[0]== 't') {
	$name =  't_check_command_id';
} else {
	$name = 'check_command_id';
}
echo form_label('Check Commands', $name);
echo '&nbsp;';

echo form_dropdown($name, $commands, $h->check_command_id[1]);
?>
<fieldset><legend> Enable Checks: </legend> <input
	name="<?php if ($h->active_checks_enabled[0]== 't') { echo 't_'; }?>active_checks_enabled"
	value="1"
	<?php if ($h->active_checks_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->active_checks_enabled[0]== 't') { echo 't_'; }?>active_checks_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Active Checks <input
	name="<?php if ($h->passive_checks_enabled[0]== 't') { echo 't_'; }?>passive_checks_enabled"
	value="1"
	<?php if ($h->passive_checks_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->passive_checks_enabled[0]== 't') { echo 't_'; }?>passive_checks_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Passive Checks <input
	name="<?php if ($h->event_handler_enabled[0]== 't') { echo 't_'; }?>event_handler_enabled"
	value="1"
	<?php if ($h->event_handler_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->event_handler_enabled[0]== 't') { echo 't_'; }?>event_handler_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Event Handler <input
	name="<?php if ($h->notifications_enabled[0]== 't') { echo 't_'; }?>notifications_enabled"
	value="1"
	<?php if ($h->notifications_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->notifications_enabled[0]== 't') { echo 't_'; }?>notifications_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Notifications <input
	name="<?php if ($h->obsess_over_host[0]== 't') { echo 't_'; }?>obsess_over_host"
	value="1"
	<?php if ($h->obsess_over_host[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->obsess_over_host[0]== 't') { echo 't_'; }?>obsess_over_host"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Obsess</fieldset>
<fieldset><legend> Notify On: </legend> <input
	name="<?php if ($h->notify_on_down[0]== 't') { echo 't_'; }?>notify_on_down"
	value="1"
	<?php if ($h->notify_on_down[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->notify_on_down[0]== 't') { echo 't_'; }?>notify_on_down"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="<?php if ($h->notify_on_unreachable[0]== 't') { echo 't_'; }?>notify_on_unreachable"
	value="1"
	<?php if ($h->notify_on_unreachable[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->notify_on_unreachable[0]== 't') { echo 't_'; }?>notify_on_unreachable"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unreachable <input
	name="<?php if ($h->notify_on_recovery[0]== 't') { echo 't_'; }?>notify_on_recovery"
	value="1"
	<?php if ($h->notify_on_recovery[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->notify_on_recovery[0]== 't') { echo 't_'; }?>notify_on_recovery"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Recovery <input
	name="<?php if ($h->notify_on_flapping[0]== 't') { echo 't_'; }?>notify_on_flapping"
	value="1"
	<?php if ($h->notify_on_flapping[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->notify_on_flapping[0]== 't') { echo 't_'; }?>notify_on_flapping"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Flapping <input
	name="<?php if ($h->notify_on_downtime[0]== 't') { echo 't_'; }?>notify_on_downtime"
	value="1"
	<?php if ($h->notify_on_downtime[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->notify_on_downtime[0]== 't') { echo 't_'; }?>notify_on_downtime"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Downtime</fieldset>
<fieldset><legend> Stalk: </legend> <input
	name="<?php if ($h->stalk_on_down[0]== 't') { echo 't_'; }?>stalk_on_down"
	value="1"
	<?php if ($h->stalk_on_down[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->stalk_on_down[0]== 't') { echo 't_'; }?>stalk_on_down"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="<?php if ($h->stalk_on_unreachable[0]== 't') { echo 't_'; }?>stalk_on_unreachable"
	value="1"
	<?php if ($h->stalk_on_unreachable[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->stalk_on_unreachable[0]== 't') { echo 't_'; }?>stalk_on_unreachable"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unreachable <input
	name="<?php if ($h->stalk_on_up[0]== 't') { echo 't_'; }?>stalk_on_up"
	value="1"
	<?php if ($h->stalk_on_up[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->stalk_on_up[0]== 't') { echo 't_'; }?>stalk_on_up"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Up</fieldset>
<fieldset><legend> Flap Detection </legend> <input
	name="<?php if ($h->flap_detection_enabled[0]== 't') { echo 't_'; }?>flap_detection_enabled"
	value="1"
	<?php if ($h->flap_detection_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->flap_detection_enabled[0]== 't') { echo 't_'; }?>flap_detection_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Enabled <input
	name="<?php if ($h->flap_detection_on_down[0]== 't') { echo 't_'; }?>flap_detection_on_down"
	value="1"
	<?php if ($h->flap_detection_on_down) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->flap_detection_on_down[0]== 't') { echo 't_'; }?>flap_detection_on_down"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="<?php if ($h->flap_detection_on_unreachable[0]== 't') { echo 't_'; }?>flap_detection_on_unreachable"
	value="1"
	<?php if ($h->flap_detection_on_unreachable) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->flap_detection_on_unreachable[0]== 't') { echo 't_'; }?>flap_detection_on_unreachable"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unreachable <input
	name="<?php if ($h->flap_detection_on_up[0]== 't') { echo 't_'; }?>flap_detection_on_up"
	value="1"
	<?php if ($h->flap_detection_on_up) { echo 'checked="checked"'; } ?>
	id="<?php if ($h->flap_detection_on_up[0]== 't') { echo 't_'; }?>flap_detection_on_up"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Up</fieldset>
<fieldset><legend> Misc </legend> <label
	for="<?php if ($h->notes[0]== 't') { echo 't_'; }?>notes"> Notes </label>&nbsp;
<input name="<?php if ($h->notes[0]== 't') { echo 't_'; }?>notes"
	value="<?= $h->notes[1]; ?>"
	id="<?php if ($h->notes[0]== 't') { echo 't_'; }?>notes"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onKeyDown="removeT($(this).attr('id'));">&nbsp; <label
	for="<?php if ($h->notes_url[0]== 't') { echo 't_'; }?>notes_url">
Notes URL </label>&nbsp; <input
	name="<?php if ($h->notes_url[0]== 't') { echo 't_'; }?>notes_url"
	value="<?= $h->notes_url[1]; ?>"
	id="<?php if ($h->notes_url[0]== 't') { echo 't_'; }?>notes_url"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onKeyDown="removeT($(this).attr('id'));">&nbsp;<br />
<label
	for="<?php if ($h->icon_image[0]== 't') { echo 't_'; }?>icon_image">
Icon Image </label>&nbsp; <input
	name="<?php if ($h->icon_image[0]== 't') { echo 't_'; }?>icon_image"
	value="<?= $h->icon_image[1]; ?>"
	id="<?php if ($h->icon_image[0]== 't') { echo 't_'; }?>icon_image"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onKeyDown="removeT($(this).attr('id'));">&nbsp; <label
	for="<?php if ($h->icon_image_alt[0]== 't') { echo 't_'; }?>icon_image_alt">
Icon Image Alt </label>&nbsp; <input
	name="<?php if ($h->icon_image_alt[0]== 't') { echo 't_'; }?>icon_image_alt"
	value="<?= $h->icon_image_alt[1]; ?>"
	id="<?php if ($h->icon_image_alt[0]== 't') { echo 't_'; }?>icon_image_alt"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onKeyDown="removeT($(this).attr('id'));">&nbsp;</fieldset>
</fieldset>
	<?php
	echo form_close();

	?></div>
