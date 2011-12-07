<?php
/**
 * HS_menu.php
 * Host and Service menu that fits on the top of the screen
 * */
$this->load->view('part/header');
?>

<div id="mainBody">
<div id="bodyTop">
<div id="topMenu">
<div id="topMenuImage"><a href="<?= base_url(); ?>index.php/home/"><img
	src="<?= base_url();?>images/logofullsizei.png" height="40" border="0"
	alt="Nagios" title="Nagios"></a></div>
<div id="topMenuMiddle">
<div id="topMenuMiddleContent">
<ul class="topMenu">
	<li><a href="<?= base_url(); ?>index.php/home/hosts" title="Hosts">Hosts</a>
	<a href="<?= base_url(); ?>index.php/home/thosts"
		title="Host Templates">(T)</a></li>
	<li><a href="<?= base_url(); ?>index.php/home/services"
		title="Services">Services</a> <a
		href="<?= base_url(); ?>index.php/home/tservices"
		title="Service Templates">(T)</a></li>
	<li><a href="<?= base_url(); ?>index.php/home/hostgroups"
		title="Hostgroups">Hostgroups</a></li>
	<!--
                <li>
                    <a href="<?= base_url(); ?>index.php/home/servicegroups">Service Groups</a>
                </li>
				        <li>
                    <a href="<?= base_url(); ?>index.php/home/contacts">Contacts</a>
                </li>
				        <li>
                    <a href="<?= base_url(); ?>index.php/home/timeperiods">Time Periods</a>
                </li>-->
</ul>
</div>
</div>
</div>

<div id="topMenuLowerBar">
<div id="topMenuLowerText"></div>
<div id="topMenuLowerRight"><!--<div class="ui-state-default">
		<span id="config_arrow" class="ui-icon ui-icon-circle-triangle-n"></span>
		Config
		</div>--></div>
</div>

<div id="dialogHost" title="Modify Host"></div>
<div id="dialogHostTemplate" title="Modify Host Template"></div>
<div id="dialogHostgroup" title="Modify Hostgroup"></div>
<div id="dialogService" title="Modify Service"></div>
<div id="dialogServiceTemplate" title="Modify Service Template"></div>
<div id="outerHolder" class="outerHolder">
<div id="holder" class="holder ui-corner-tl ui-corner-bl"></div>
<?php //$this->load->view('menu/service_view', $menuServices); ?> <?php //$this->load->view('menu/host_view', $menuHosts); ?>
<?php //$this->load->view('menu/hostgroup_view', $menuHostgroups); ?></div>
</div>
<div id="groups">