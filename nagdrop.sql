
CREATE TABLE IF NOT EXISTS `nagdrop_check_commands` (
  `command_id` int(11) NOT NULL AUTO_INCREMENT,
  `command_name` varchar(250) NOT NULL,
  `command_line` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`command_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Command definitions' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nagdrop_hostgroups` (
  `hostgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`hostgroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Hostgroup definitions' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_hostgroup_members` (
  `hostgroup_member_id` int(11) NOT NULL AUTO_INCREMENT,
  `hostgroup_id` int(11) NOT NULL DEFAULT '0',
  `host_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hostgroup_member_id`),
  UNIQUE KEY `instance_id` (`hostgroup_id`,`host_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Hostgroup members' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_hostgroup_services` (
  `hostgroup_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `hostgroup_id` int(11) NOT NULL,
  PRIMARY KEY (`hostgroup_service_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_hosts` (
  `host_id` int(11) NOT NULL AUTO_INCREMENT,
  `thost_id` int(11) NOT NULL,
  `host_name` varchar(64) NOT NULL,
  `alias` varchar(64) NOT NULL,
  `display_name` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL,
  `check_command_id` int(11) DEFAULT NULL,
  `check_command_args` varchar(255) DEFAULT NULL,
  `eventhandler_command_object_id` int(11) DEFAULT NULL,
  `eventhandler_command_args` varchar(255) DEFAULT NULL,
  `notification_timeperiod_object_id` int(11) DEFAULT NULL,
  `check_timeperiod_object_id` int(11) DEFAULT NULL,
  `check_interval` double DEFAULT NULL,
  `retry_interval` double DEFAULT NULL,
  `max_check_attempts` smallint(6) DEFAULT NULL,
  `first_notification_delay` double DEFAULT NULL,
  `notification_interval` double DEFAULT NULL,
  `notify_on_down` smallint(6) DEFAULT NULL,
  `notify_on_unreachable` smallint(6) DEFAULT NULL,
  `notify_on_recovery` smallint(6) DEFAULT NULL,
  `notify_on_flapping` smallint(6) DEFAULT NULL,
  `notify_on_downtime` smallint(6) DEFAULT NULL,
  `stalk_on_up` smallint(6) DEFAULT NULL,
  `stalk_on_down` smallint(6) DEFAULT NULL,
  `stalk_on_unreachable` smallint(6) DEFAULT NULL,
  `flap_detection_enabled` smallint(6) DEFAULT NULL,
  `flap_detection_on_up` smallint(6) DEFAULT NULL,
  `flap_detection_on_down` smallint(6) DEFAULT NULL,
  `flap_detection_on_unreachable` smallint(6) DEFAULT NULL,
  `low_flap_threshold` double DEFAULT NULL,
  `high_flap_threshold` double DEFAULT NULL,
  `process_performance_data` smallint(6) DEFAULT NULL,
  `freshness_checks_enabled` smallint(6) DEFAULT NULL,
  `freshness_threshold` smallint(6) DEFAULT NULL,
  `passive_checks_enabled` smallint(6) DEFAULT NULL,
  `event_handler_enabled` smallint(6) DEFAULT NULL,
  `active_checks_enabled` smallint(6) DEFAULT NULL,
  `retain_status_information` smallint(6) DEFAULT NULL,
  `retain_nonstatus_information` smallint(6) DEFAULT NULL,
  `notifications_enabled` smallint(6) DEFAULT NULL,
  `obsess_over_host` smallint(6) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `notes_url` varchar(255) DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `icon_image` varchar(255) DEFAULT NULL,
  `icon_image_alt` varchar(255) DEFAULT NULL,
  `vrml_image` varchar(255) DEFAULT NULL,
  `statusmap_image` varchar(255) DEFAULT NULL,
  `x_2d` smallint(6) DEFAULT NULL,
  `y_2d` smallint(6) DEFAULT NULL,
  `x_3d` double DEFAULT NULL,
  `y_3d` double DEFAULT NULL,
  `z_3d` double DEFAULT NULL,
  PRIMARY KEY (`host_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Host definitions' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_host_contacts` (
  `host_contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `instance_id` smallint(6) NOT NULL DEFAULT '0',
  `host_id` int(11) NOT NULL DEFAULT '0',
  `contact_object_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`host_contact_id`),
  UNIQUE KEY `instance_id` (`instance_id`,`host_id`,`contact_object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_host_parenthosts` (
  `host_parenthost_id` int(11) NOT NULL AUTO_INCREMENT,
  `host_id` int(11) NOT NULL DEFAULT '0',
  `parent_host_object_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`host_parenthost_id`),
  UNIQUE KEY `instance_id` (`host_id`,`parent_host_object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Parent hosts' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nagdrop_servicegroups` (
  `servicegroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`servicegroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Servicegroup definitions' AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `nagdrop_servicegroup_members` (
  `servicegroup_member_id` int(11) NOT NULL AUTO_INCREMENT,
  `servicegroup_id` int(11) NOT NULL DEFAULT '0',
  `service_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`servicegroup_member_id`),
  UNIQUE KEY `instance_id` (`servicegroup_id`,`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Servicegroup members' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `tservice_id` int(11) DEFAULT NULL,
  `check_command_id` int(11) NOT NULL DEFAULT '-1',
  `display_name` varchar(64) NOT NULL,
  `check_command_args` varchar(255) DEFAULT NULL,
  `eventhandler_command_object_id` int(11) DEFAULT NULL,
  `eventhandler_command_args` varchar(255) DEFAULT NULL,
  `notification_timeperiod_object_id` int(11) NOT NULL DEFAULT '-1',
  `check_timeperiod_object_id` int(11) NOT NULL DEFAULT '-1',
  `failure_prediction_options` varchar(64) DEFAULT NULL,
  `check_interval` double NOT NULL DEFAULT '-1',
  `retry_interval` double NOT NULL DEFAULT '-1',
  `max_check_attempts` smallint(6) NOT NULL DEFAULT '-1',
  `first_notification_delay` double DEFAULT NULL,
  `notification_interval` double DEFAULT NULL,
  `notify_on_warning` smallint(6) DEFAULT NULL,
  `notify_on_unknown` smallint(6) DEFAULT NULL,
  `notify_on_critical` smallint(6) DEFAULT NULL,
  `notify_on_recovery` smallint(6) DEFAULT NULL,
  `notify_on_flapping` smallint(6) DEFAULT NULL,
  `notify_on_downtime` smallint(6) DEFAULT NULL,
  `stalk_on_ok` smallint(6) DEFAULT NULL,
  `stalk_on_warning` smallint(6) DEFAULT NULL,
  `stalk_on_unknown` smallint(6) DEFAULT NULL,
  `stalk_on_critical` smallint(6) DEFAULT NULL,
  `is_volatile` smallint(6) DEFAULT NULL,
  `flap_detection_enabled` smallint(6) DEFAULT NULL,
  `flap_detection_on_ok` smallint(6) DEFAULT NULL,
  `flap_detection_on_warning` smallint(6) DEFAULT NULL,
  `flap_detection_on_unknown` smallint(6) DEFAULT NULL,
  `flap_detection_on_critical` smallint(6) DEFAULT NULL,
  `low_flap_threshold` double DEFAULT NULL,
  `high_flap_threshold` double DEFAULT NULL,
  `process_performance_data` smallint(6) DEFAULT NULL,
  `freshness_checks_enabled` smallint(6) DEFAULT NULL,
  `freshness_threshold` smallint(6) DEFAULT NULL,
  `passive_checks_enabled` smallint(6) DEFAULT NULL,
  `event_handler_enabled` smallint(6) DEFAULT NULL,
  `active_checks_enabled` smallint(6) DEFAULT NULL,
  `retain_status_information` smallint(6) DEFAULT NULL,
  `retain_nonstatus_information` smallint(6) DEFAULT NULL,
  `notifications_enabled` smallint(6) DEFAULT NULL,
  `obsess_over_service` smallint(6) DEFAULT NULL,
  `failure_prediction_enabled` smallint(6) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `notes_url` varchar(255) DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `icon_image` varchar(255) DEFAULT NULL,
  `icon_image_alt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Service definitions' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_services_hosts` (
  `service_host_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `host_id` int(11) NOT NULL,
  PRIMARY KEY (`service_host_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nagdrop_thosts` (
  `thost_id` int(11) NOT NULL AUTO_INCREMENT,
  `thost_name` varchar(150) NOT NULL,
  `check_command_id` int(11) NOT NULL DEFAULT '0',
  `check_command_args` varchar(255) NOT NULL DEFAULT '',
  `eventhandler_command_object_id` int(11) NOT NULL DEFAULT '0',
  `eventhandler_command_args` varchar(255) NOT NULL DEFAULT '',
  `notification_timeperiod_object_id` int(11) NOT NULL DEFAULT '2',
  `check_timeperiod_object_id` int(11) NOT NULL DEFAULT '2',
  `check_interval` double NOT NULL DEFAULT '5',
  `retry_interval` double NOT NULL DEFAULT '1',
  `max_check_attempts` smallint(6) NOT NULL DEFAULT '10',
  `first_notification_delay` double NOT NULL DEFAULT '0',
  `notification_interval` double NOT NULL DEFAULT '120',
  `notify_on_down` smallint(6) NOT NULL DEFAULT '0',
  `notify_on_unreachable` smallint(6) NOT NULL DEFAULT '0',
  `notify_on_recovery` smallint(6) NOT NULL DEFAULT '0',
  `notify_on_flapping` smallint(6) NOT NULL DEFAULT '0',
  `notify_on_downtime` smallint(6) NOT NULL DEFAULT '0',
  `stalk_on_up` smallint(6) NOT NULL DEFAULT '0',
  `stalk_on_down` smallint(6) NOT NULL DEFAULT '0',
  `stalk_on_unreachable` smallint(6) NOT NULL DEFAULT '0',
  `flap_detection_enabled` smallint(6) NOT NULL DEFAULT '0',
  `flap_detection_on_up` smallint(6) NOT NULL DEFAULT '0',
  `flap_detection_on_down` smallint(6) NOT NULL DEFAULT '0',
  `flap_detection_on_unreachable` smallint(6) NOT NULL DEFAULT '0',
  `low_flap_threshold` double NOT NULL DEFAULT '0',
  `high_flap_threshold` double NOT NULL DEFAULT '0',
  `process_performance_data` smallint(6) NOT NULL DEFAULT '0',
  `freshness_checks_enabled` smallint(6) NOT NULL DEFAULT '0',
  `freshness_threshold` smallint(6) NOT NULL DEFAULT '0',
  `passive_checks_enabled` smallint(6) NOT NULL DEFAULT '0',
  `event_handler_enabled` smallint(6) NOT NULL DEFAULT '0',
  `active_checks_enabled` smallint(6) NOT NULL DEFAULT '0',
  `retain_status_information` smallint(6) NOT NULL DEFAULT '0',
  `retain_nonstatus_information` smallint(6) NOT NULL DEFAULT '0',
  `notifications_enabled` smallint(6) NOT NULL DEFAULT '0',
  `obsess_over_host` smallint(6) NOT NULL DEFAULT '0',
  `failure_prediction_enabled` smallint(6) NOT NULL DEFAULT '0',
  `notes` varchar(255) NOT NULL DEFAULT '',
  `notes_url` varchar(255) NOT NULL DEFAULT '',
  `action_url` varchar(255) NOT NULL DEFAULT '',
  `icon_image` varchar(255) NOT NULL DEFAULT '',
  `icon_image_alt` varchar(255) NOT NULL DEFAULT '',
  `vrml_image` varchar(255) NOT NULL DEFAULT '',
  `statusmap_image` varchar(255) NOT NULL DEFAULT '',
  `have_2d_coords` smallint(6) NOT NULL DEFAULT '0',
  `x_2d` smallint(6) NOT NULL DEFAULT '0',
  `y_2d` smallint(6) NOT NULL DEFAULT '0',
  `have_3d_coords` smallint(6) NOT NULL DEFAULT '0',
  `x_3d` double NOT NULL DEFAULT '0',
  `y_3d` double NOT NULL DEFAULT '0',
  `z_3d` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`thost_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Host definitions' AUTO_INCREMENT=1 ;


INSERT INTO `nagdrop_thosts` (`thost_id`, `thost_name`, `check_command_id`, `check_command_args`, `eventhandler_command_object_id`, `eventhandler_command_args`, `notification_timeperiod_object_id`, `check_timeperiod_object_id`, `check_interval`, `retry_interval`, `max_check_attempts`, `first_notification_delay`, `notification_interval`, `notify_on_down`, `notify_on_unreachable`, `notify_on_recovery`, `notify_on_flapping`, `notify_on_downtime`, `stalk_on_up`, `stalk_on_down`, `stalk_on_unreachable`, `flap_detection_enabled`, `flap_detection_on_up`, `flap_detection_on_down`, `flap_detection_on_unreachable`, `low_flap_threshold`, `high_flap_threshold`, `process_performance_data`, `freshness_checks_enabled`, `freshness_threshold`, `passive_checks_enabled`, `event_handler_enabled`, `active_checks_enabled`, `retain_status_information`, `retain_nonstatus_information`, `notifications_enabled`, `obsess_over_host`, `failure_prediction_enabled`, `notes`, `notes_url`, `action_url`, `icon_image`, `icon_image_alt`, `vrml_image`, `statusmap_image`, `have_2d_coords`, `x_2d`, `y_2d`, `have_3d_coords`, `x_3d`, `y_3d`, `z_3d`) VALUES
(0, '', 12, '', 0, '', 41, 2, 5, 1, 10, 0, 30, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, '', '', '', '', '', '', '', 0, -1, 0, 0, 0, 0, 0);



CREATE TABLE IF NOT EXISTS `nagdrop_timeperiods` (
  `timeperiod_id` int(11) NOT NULL AUTO_INCREMENT,
  `timeperiod_object_id` int(11) NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`timeperiod_id`),
  UNIQUE KEY `instance_id` (`timeperiod_object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Timeperiod definitions' AUTO_INCREMENT=10 ;


INSERT INTO `nagdrop_timeperiods` (`timeperiod_id`, `timeperiod_object_id`, `alias`) VALUES
(7, 2, '24 Hours A Day, 7 Days A Week'),
(8, 40, 'No Time Is A Good Time'),
(9, 41, 'Normal Work Hours');



CREATE TABLE IF NOT EXISTS `nagdrop_timeperiod_timeranges` (
  `timeperiod_timerange_id` int(11) NOT NULL AUTO_INCREMENT,
  `timeperiod_id` int(11) NOT NULL DEFAULT '0',
  `day` smallint(6) NOT NULL DEFAULT '0',
  `start_sec` int(11) NOT NULL DEFAULT '0',
  `end_sec` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`timeperiod_timerange_id`),
  UNIQUE KEY `instance_id` (`timeperiod_id`,`day`,`start_sec`,`end_sec`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Timeperiod definitions' AUTO_INCREMENT=37 ;


INSERT INTO `nagdrop_timeperiod_timeranges` (`timeperiod_timerange_id`, `timeperiod_id`, `day`, `start_sec`, `end_sec`) VALUES
(25, 7, 0, 0, 86400),
(26, 7, 1, 0, 86400),
(27, 7, 2, 0, 86400),
(28, 7, 3, 0, 86400),
(29, 7, 4, 0, 86400),
(30, 7, 5, 0, 86400),
(31, 7, 6, 0, 86400),
(32, 9, 1, 32400, 61200),
(33, 9, 2, 32400, 61200),
(34, 9, 3, 32400, 61200),
(35, 9, 4, 32400, 61200),
(36, 9, 5, 32400, 61200);



CREATE TABLE IF NOT EXISTS `nagdrop_tservices` (
  `tservice_id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(64) NOT NULL,
  `check_command_id` int(11) NOT NULL DEFAULT '0',
  `check_command_args` varchar(255) NOT NULL DEFAULT '',
  `eventhandler_command_object_id` int(11) NOT NULL,
  `eventhandler_command_args` varchar(255) NOT NULL DEFAULT '',
  `notification_timeperiod_object_id` int(11) NOT NULL,
  `check_timeperiod_object_id` int(11) NOT NULL,
  `failure_prediction_options` varchar(64) NOT NULL DEFAULT '',
  `check_interval` double NOT NULL,
  `retry_interval` double NOT NULL,
  `max_check_attempts` smallint(6) NOT NULL,
  `first_notification_delay` double NOT NULL,
  `notification_interval` double NOT NULL,
  `notify_on_warning` smallint(6) NOT NULL,
  `notify_on_unknown` smallint(6) NOT NULL,
  `notify_on_critical` smallint(6) NOT NULL,
  `notify_on_recovery` smallint(6) NOT NULL,
  `notify_on_flapping` smallint(6) NOT NULL,
  `notify_on_downtime` smallint(6) NOT NULL,
  `stalk_on_ok` smallint(6) NOT NULL,
  `stalk_on_warning` smallint(6) NOT NULL,
  `stalk_on_unknown` smallint(6) NOT NULL,
  `stalk_on_critical` smallint(6) NOT NULL,
  `is_volatile` smallint(6) NOT NULL,
  `flap_detection_enabled` smallint(6) NOT NULL,
  `flap_detection_on_ok` smallint(6) NOT NULL,
  `flap_detection_on_warning` smallint(6) NOT NULL,
  `flap_detection_on_unknown` smallint(6) NOT NULL,
  `flap_detection_on_critical` smallint(6) NOT NULL,
  `low_flap_threshold` double NOT NULL,
  `high_flap_threshold` double NOT NULL,
  `process_performance_data` smallint(6) NOT NULL,
  `freshness_checks_enabled` smallint(6) NOT NULL,
  `freshness_threshold` smallint(6) NOT NULL,
  `passive_checks_enabled` smallint(6) NOT NULL,
  `event_handler_enabled` smallint(6) NOT NULL,
  `active_checks_enabled` smallint(6) NOT NULL,
  `retain_status_information` smallint(6) NOT NULL,
  `retain_nonstatus_information` smallint(6) NOT NULL,
  `notifications_enabled` smallint(6) NOT NULL,
  `obsess_over_service` smallint(6) NOT NULL,
  `failure_prediction_enabled` smallint(6) NOT NULL,
  `notes` varchar(255) NOT NULL DEFAULT '',
  `notes_url` varchar(255) NOT NULL DEFAULT '',
  `action_url` varchar(255) NOT NULL DEFAULT '',
  `icon_image` varchar(255) NOT NULL DEFAULT '',
  `icon_image_alt` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`tservice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Service definitions' AUTO_INCREMENT=3 ;


INSERT INTO `nagdrop_tservices` (`tservice_id`, `display_name`, `check_command_id`, `check_command_args`, `eventhandler_command_object_id`, `eventhandler_command_args`, `notification_timeperiod_object_id`, `check_timeperiod_object_id`, `failure_prediction_options`, `check_interval`, `retry_interval`, `max_check_attempts`, `first_notification_delay`, `notification_interval`, `notify_on_warning`, `notify_on_unknown`, `notify_on_critical`, `notify_on_recovery`, `notify_on_flapping`, `notify_on_downtime`, `stalk_on_ok`, `stalk_on_warning`, `stalk_on_unknown`, `stalk_on_critical`, `is_volatile`, `flap_detection_enabled`, `flap_detection_on_ok`, `flap_detection_on_warning`, `flap_detection_on_unknown`, `flap_detection_on_critical`, `low_flap_threshold`, `high_flap_threshold`, `process_performance_data`, `freshness_checks_enabled`, `freshness_threshold`, `passive_checks_enabled`, `event_handler_enabled`, `active_checks_enabled`, `retain_status_information`, `retain_nonstatus_information`, `notifications_enabled`, `obsess_over_service`, `failure_prediction_enabled`, `notes`, `notes_url`, `action_url`, `icon_image`, `icon_image_alt`) VALUES
(0, '', 0, '', 0, '', 2, 2, '', 10, 2, 3, 0, 60, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, '', '', '', '', ''),
(1, 'Something', 0, '', 0, '', 2, 2, '', 10, 2, 3, 0, 60, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, '', '', '', '', ''),
(2, 'Alert onffds', 0, '', 0, '', 2, 2, '', 10, 2, 3, 0, 60, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, '', '', '', '', '');
