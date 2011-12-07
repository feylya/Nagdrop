<div><?php 
/**
 * File: service_popup_view.php
 *
 * View file for filling out the popup for modifying a service
 *
 * @var unknown_type
 */

$s = $service[0];
//$th = $thost[0];
$attributes = array('id'=>'serviceForm');
//The form URL doesn't matter (or exist). It's all called through the dialog javascript in core.js
echo form_open('popup/service/modify', $attributes);
?> <input type="hidden" value="<?= $s->service_id[1]; ?>"
	name="service_id" id="service_id">

<fieldset><label
	for="<?php if ($s->display_name[0] == "t") { echo 't_'; }?>display_name">
Display name </label> <input
	name="<?php if ($s->display_name[0]== "t") { echo 't_'; }?>display_name"
	value="<?= $s->display_name[1]; ?>"
	id="<?php if ($s->display_name[0] == "t") { echo 't_'; }?>display_name"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <br>
<?php
echo form_label('Template Name', 'tservice_id');
echo '&nbsp;&nbsp;';
echo form_dropdown('tservice_id', $serviceTemplates, $s->tservice_id[1]);
echo "<br />\n";

//Being really lazy here and using the Code Igniter Select Form Helper
if ($s->check_command_id[0]== 't') {
	$name = 't_check_command_id';
} else {
	$name = 'check_command_id';
}
echo form_label('Check Commands', $name);
echo '&nbsp;';
echo form_dropdown($name, $commands, $s->check_command_id[1]);
?> <label
	for="<?php if ($s->check_command_args[0] == "t") { echo 't_'; }?>check_command_args">
Check Command Arguments </label> <input
	name="<?php if ($s->check_command_args[0]== "t") { echo 't_'; }?>check_command_args"
	value="<?= $s->check_command_args[1]; ?>"
	id="<?php if ($s->check_command_args[0] == "t") { echo 't_'; }?>check_command_args"
	maxlength="200" size="50"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <br>
<fieldset><legend> Enable Checks: </legend> <input
	name="<?php if ($s->active_checks_enabled[0]== 't') { echo 't_'; }?>active_checks_enabled"
	value="1"
	<?php if ($s->active_checks_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->active_checks_enabled[0]== 't') { echo 't_'; }?>active_checks_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Active Checks <input
	name="<?php if ($s->passive_checks_enabled[0]== 't') { echo 't_'; }?>passive_checks_enabled"
	value="1"
	<?php if ($s->passive_checks_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->passive_checks_enabled[0]== 't') { echo 't_'; }?>passive_checks_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Passive Checks <input
	name="<?php if ($s->event_handler_enabled[0]== 't') { echo 't_'; }?>event_handler_enabled"
	value="1"
	<?php if ($s->event_handler_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->event_handler_enabled[0]== 't') { echo 't_'; }?>event_handler_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Event Handler <input
	name="<?php if ($s->notifications_enabled[0]== 't') { echo 't_'; }?>notifications_enabled"
	value="1"
	<?php if ($s->notifications_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->notifications_enabled[0]== 't') { echo 't_'; }?>notifications_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Notifications <input
	name="<?php if ($s->obsess_over_service[0]== 't') { echo 't_'; }?>obsess_over_service"
	value="1"
	<?php if ($s->obsess_over_service[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->obsess_over_service[0]== 't') { echo 't_'; }?>obsess_over_service"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Obsess</fieldset>
<fieldset><legend> Notify On: </legend> <input
	name="<?php if ($s->notify_on_warning[0]== 't') { echo 't_'; }?>notify_on_warning"
	value="1"
	<?php if ($s->notify_on_warning[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->notify_on_warning[0]== 't') { echo 't_'; }?>notify_on_warning"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="<?php if ($s->notify_on_unknown[0]== 't') { echo 't_'; }?>notify_on_unknown"
	value="1"
	<?php if ($s->notify_on_unknown[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->notify_on_unknown[0]== 't') { echo 't_'; }?>notify_on_unknown"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unkown <input
	name="<?php if ($s->notify_on_critical[0]== 't') { echo 't_'; }?>notify_on_critical"
	value="1"
	<?php if ($s->notify_on_critical[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->notify_on_critical[0]== 't') { echo 't_'; }?>notify_on_critical"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Critical <input
	name="<?php if ($s->notify_on_recovery[0]== 't') { echo 't_'; }?>notify_on_recovery"
	value="1"
	<?php if ($s->notify_on_recovery[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->notify_on_recovery[0]== 't') { echo 't_'; }?>notify_on_recovery"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Recovery <input
	name="<?php if ($s->notify_on_flapping[0]== 't') { echo 't_'; }?>notify_on_flapping"
	value="1"
	<?php if ($s->notify_on_flapping[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->notify_on_flapping[0]== 't') { echo 't_'; }?>notify_on_flapping"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Flapping <input
	name="<?php if ($s->notify_on_downtime[0]== 't') { echo 't_'; }?>notify_on_downtime"
	value="1"
	<?php if ($s->notify_on_downtime[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->notify_on_downtime[0]== 't') { echo 't_'; }?>notify_on_downtime"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Downtime</fieldset>
<fieldset><legend> Stalk: </legend> <input
	name="<?php if ($s->stalk_on_warning[0]== 't') { echo 't_'; }?>stalk_on_warning"
	value="1"
	<?php if ($s->stalk_on_warning[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->stalk_on_warning[0]== 't') { echo 't_'; }?>stalk_on_warning"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="<?php if ($s->stalk_on_unknown[0]== 't') { echo 't_'; }?>stalk_on_unknown"
	value="1"
	<?php if ($s->stalk_on_unknown[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->stalk_on_unknown[0]== 't') { echo 't_'; }?>stalk_on_unknown"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unreachable <input
	name="<?php if ($s->stalk_on_critical[0]== 't') { echo 't_'; }?>stalk_on_critical"
	value="1"
	<?php if ($s->stalk_on_critical[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->stalk_on_critical[0]== 't') { echo 't_'; }?>stalk_on_critical"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Up</fieldset>
<fieldset><legend> Flap Detection </legend> <input
	name="<?php if ($s->flap_detection_enabled[0]== 't') { echo 't_'; }?>flap_detection_enabled"
	value="1"
	<?php if ($s->flap_detection_enabled[1]) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->flap_detection_enabled[0]== 't') { echo 't_'; }?>flap_detection_enabled"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Enabled <input
	name="<?php if ($s->flap_detection_on_ok[0]== 't') { echo 't_'; }?>flap_detection_on_ok"
	value="1"
	<?php if ($s->flap_detection_on_ok) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->flap_detection_on_ok[0]== 't') { echo 't_'; }?>flap_detection_on_ok"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="<?php if ($s->flap_detection_on_warning[0]== 't') { echo 't_'; }?>flap_detection_on_warning"
	value="1"
	<?php if ($s->flap_detection_on_warning) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->flap_detection_on_warning[0]== 't') { echo 't_'; }?>flap_detection_on_warning"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Down <input
	name="<?php if ($s->flap_detection_on_unknown[0]== 't') { echo 't_'; }?>flap_detection_on_unknown"
	value="1"
	<?php if ($s->flap_detection_on_unknown) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->flap_detection_on_unknown[0]== 't') { echo 't_'; }?>flap_detection_on_unknown"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Unreachable <input
	name="<?php if ($s->flap_detection_on_critical[0]== 't') { echo 't_'; }?>flap_detection_on_critical"
	value="1"
	<?php if ($s->flap_detection_on_critical) { echo 'checked="checked"'; } ?>
	id="<?php if ($s->flap_detection_on_critical[0]== 't') { echo 't_'; }?>flap_detection_on_critical"
	style="margin: 1px;" type="checkbox"
	onChange="removeT($(this).attr('id'));">Up</fieldset>
<fieldset><legend> Misc </legend> <label
	for="<?php if ($s->notes[0]== 't') { echo 't_'; }?>notes"> Notes </label>&nbsp;
<input name="<?php if ($s->notes[0]== 't') { echo 't_'; }?>notes"
	value="<?= $s->notes[1]; ?>"
	id="<?php if ($s->notes[0]== 't') { echo 't_'; }?>notes"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <label
	for="<?php if ($s->notes_url[0]== 't') { echo 't_'; }?>notes_url">
Notes URL </label>&nbsp; <input
	name="<?php if ($s->notes_url[0]== 't') { echo 't_'; }?>notes_url"
	value="<?= $s->notes_url[1]; ?>"
	id="<?php if ($s->notes_url[0]== 't') { echo 't_'; }?>notes_url"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp;<br />
<label
	for="<?php if ($s->icon_image[0]== 't') { echo 't_'; }?>icon_image">
Icon Image </label>&nbsp; <input
	name="<?php if ($s->icon_image[0]== 't') { echo 't_'; }?>icon_image"
	value="<?= $s->icon_image[1]; ?>"
	id="<?php if ($s->icon_image[0]== 't') { echo 't_'; }?>icon_image"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp; <label
	for="<?php if ($s->icon_image_alt[0]== 't') { echo 't_'; }?>icon_image_alt">
Icon Image Alt </label>&nbsp; <input
	name="<?php if ($s->icon_image_alt[0]== 't') { echo 't_'; }?>icon_image_alt"
	value="<?= $s->icon_image_alt[1]; ?>"
	id="<?php if ($s->icon_image_alt[0]== 't') { echo 't_'; }?>icon_image_alt"
	maxlength="100" size="20"
	class="select ui-widget-content ui-corner-all" type="text"
	onChange="removeT($(this).attr('id'));">&nbsp;</fieldset>
</fieldset>
	<?php
	echo form_close();

	?></div>
