<?php
/**
 * Contains the queries that will be used to create the database structure
 * when installing the system.
 *
 * @package		ProjectSend
 * @subpackage	Install
 */
if (defined('TRY_INSTALL')) {
	$timestamp = time();
	$current_version = substr(CURRENT_VERSION, 1);
	$now = date('d-m-Y');
	
	$install_queries = array(
	
	'0' => '
	CREATE TABLE IF NOT EXISTS `tbl_files` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `url` text NOT NULL,
	  `filename` text NOT NULL,
	  `description` text NOT NULL,
	  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	  `uploader` varchar('.MAX_USER_CHARS.') NOT NULL,
	  `expires` INT(1) NOT NULL default \'0\',
	  `expiry_date` TIMESTAMP NOT NULL,
	  `public_allow` INT(1) NOT NULL default \'0\',
	  `public_token` varchar(32) NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
	'

	
	
	

	);
}
?>