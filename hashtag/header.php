
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $page_title; ?> &raquo; <?php echo THIS_INSTALL_SET_TITLE; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo BASE_URI; ?>/favicon.ico" />
	<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/jquery-1.8.3.min.js"></script>

	<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>css/bootstrap.min.css" />
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>css/bootstrap-responsive.min.css" />
	<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/bootstrap/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>css/shared.css" />

	<link href='<?php echo PROTOCOL; ?>://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
	<link href='<?php echo PROTOCOL; ?>://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>

	<?php
		/**
		 * Load a different css file when called from the admin, or
		 * the default template.
		 */
		if (!isset($this_template_css)) {
			/** Back-end */
	?>
			<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>css/base.css" />
	<?php
		}
		else {
			/** Template */
	?>
			<link rel="stylesheet" media="all" type="text/css" href="<?php echo $this_template_css; ?>" />
	<?php
		}
	?>
	
	<script src="<?php echo BASE_URI; ?>includes/js/jquery.validations.js" type="text/javascript"></script>
	<script src="<?php echo BASE_URI; ?>includes/js/jquery.psendmodal.js" type="text/javascript"></script>

	<?php if (isset($datepicker)) { ?>
		<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>includes/js/datepicker/datepicker.css" />
		<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/datepicker/bootstrap-datepicker.js"></script>

		<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>includes/js/bootstrap-datepicker/css/datepicker.css" />
		<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<?php } ?>

	<?php if (isset($spinedit)) { ?>
		<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>includes/js/bootstrap-spinedit/bootstrap-spinedit.css" />
		<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/bootstrap-spinedit/bootstrap-spinedit.js"></script>
	<?php } ?>

	<?php if (isset($easytabs)) { ?>
		<script src="<?php echo BASE_URI; ?>includes/js/jquery.easytabs.min.js" type="text/javascript"></script>
	<?php } ?>

	<?php if (isset($tablesorter)) { ?>
		<script src="<?php echo BASE_URI; ?>includes/js/jquery.tablesorter.min.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URI; ?>includes/js/jquery.tablesorter.pager.js" type="text/javascript"></script>
	<?php } ?>

	<?php if (isset($textboxlist)) { ?>
		<script src="<?php echo BASE_URI; ?>includes/js/GrowingInput.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URI; ?>includes/js/TextboxList.js" type="text/javascript"></script>
	<?php } ?>
	
	<?php if (isset($multiselect)) { ?>
		<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>includes/js/chosen/chosen.min.css" />
		<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>includes/js/chosen/chosen.bootstrap.css" />
		<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/chosen/chosen.jquery.min.js"></script>
	<?php } ?>
	

	<?php if (isset($plupload)) { ?>
		<link rel="stylesheet" media="all" type="text/css" href="<?php echo BASE_URI; ?>includes/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" />
		<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/js/browserplus-min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/plupload/js/plupload.full.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URI; ?>includes/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	<?php } ?>

	<?php if (isset($flot)) { ?>
		<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo BASE_URI; ?>includes/flot/excanvas.js"></script><![endif]-->
		<script language="javascript" type="text/javascript" src="<?php echo BASE_URI; ?>includes/flot/jquery.flot.min.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo BASE_URI; ?>includes/flot/jquery.flot.resize.min.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo BASE_URI; ?>includes/flot/jquery.flot.time.min.js"></script>
	<?php } ?>
</head>

<body>

	<header>
		<div id="header">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span6">
						<h1><?php echo THIS_INSTALL_SET_TITLE; ?><img src="http://shpaste.elasticbeanstalk.com/img/custom/logo/shpaste_logo.gif" height = "42" width = "82" alt="<?php echo THIS_INSTALL_SET_TITLE; ?>" /></h1>
					</div>
					<div class="span6">
						<div id="account">
							
						
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<script type="text/javascript">
			$(document).ready(function() {
				$('.button').click(function() {
					$(this).blur();
				});
			});

			var dataExtraction = function(node) {
				if (node.childNodes.length > 1) {
					return node.childNodes[1].innerHTML;
				} else {
					return node.innerHTML;
				}
			}
		</script>

    <div class="navbar navbar-inverse">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
     
				<div class="nav-collapse collapse">
					<ul class="nav">
						<?php
							/**
							 * Show the HOME menu item only to
							 * system users.
							 */
							$groups_allowed = array(9,8,7);
							if (in_session_or_cookies($groups_allowed)) {
						?>
								<li <?php if (!empty($active_nav) && $active_nav == 'dashboard') { ?>class="active"<?php } ?>>
									<a href="<?php echo BASE_URI; ?>home.php"><?php _e('Dashboard', 'cftp_admin'); ?></a>
								</li>

								<li class="divider-vertical">

								<li class="dropdown <?php if (!empty($active_nav) && $active_nav == 'files') { ?>active<?php } ?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Files', 'cftp_admin'); ?> <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URI; ?>upload-from-computer.php"><?php _e('Upload', 'cftp_admin'); ?></a></li>
										<li class="divider"></li>
										<li><a href="<?php echo BASE_URI; ?>manage-files.php"><?php _e('Manage files', 'cftp_admin'); ?></a></li>
										<li><a href="<?php echo BASE_URI; ?>upload-import-orphans.php"><?php _e('Find orphan files', 'cftp_admin'); ?></a></li>
									</ul>
								</li>

								<li class="divider-vertical">

							<?php
								/**
								 * Show the CLIENTS menu only to
								 * System administrators and Account managers
								 */
								$clients_allowed = array(9,8);
								if (in_session_or_cookies($clients_allowed)) {
							?>
								<li class="dropdown <?php if (!empty($active_nav) && $active_nav == 'clients') { ?>active<?php } ?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<?php _e('Clients', 'cftp_admin'); ?>
										<?php
											$sql_inactive = $database->query("SELECT DISTINCT user FROM tbl_users WHERE active = '0' AND level = '0'");
											$count_inactive = mysql_num_rows($sql_inactive);
											if ($count_inactive > 0) {
										?>
												<span class="badge">
													<?php echo $count_inactive; ?>
												</span>
										<?php
											}
										?>
										<b class="caret"></b>
									</a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URI; ?>clients-add.php"><?php _e('Add new', 'cftp_admin'); ?></a></li>
										<li><a href="<?php echo BASE_URI; ?>clients.php"><?php _e('Manage clients', 'cftp_admin'); ?></a></li>
									</ul>
								</li>

								<li class="divider-vertical">

						<?php
								}
						?>
			
						<?php
							/**
							 * Show the GROUPS menu only to
							 * System administrators and Account managers
							 */
							$groups_allowed = array(9,8);
							if (in_session_or_cookies($groups_allowed)) {
						?>
								<li class="dropdown <?php if (!empty($active_nav) && $active_nav == 'groups') { ?>active<?php } ?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Clients groups', 'cftp_admin'); ?> <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URI; ?>groups-add.php"><?php _e('Add new', 'cftp_admin'); ?></a></li>
										<li><a href="<?php echo BASE_URI; ?>groups.php"><?php _e('Manage groups', 'cftp_admin'); ?></a></li>
									</ul>
								</li>
						<?php
								}
						?>

								<li class="divider-vertical">

						<?php
							/**
							 * Show the USERS menu only to
							 * System administrators
							 */
							$users_allowed = array(9);
							if (in_session_or_cookies($users_allowed)) {
						?>
								<li class="dropdown <?php if (!empty($active_nav) && $active_nav == 'users') { ?>active<?php } ?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<?php _e('System Users', 'cftp_admin'); ?>
										<?php
											$sql_inactive = $database->query("SELECT DISTINCT user FROM tbl_users WHERE active = '0' AND level != '0'");
											$count_inactive = mysql_num_rows($sql_inactive);
											if ($count_inactive > 0) {
										?>
												<span class="badge">
													<?php echo $count_inactive; ?>
												</span>
										<?php
											}
										?>
										<b class="caret"></b>
									</a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URI; ?>users-add.php"><?php _e('Add new', 'cftp_admin'); ?></a></li>
										<li><a href="<?php echo BASE_URI; ?>users.php"><?php _e('Manage system users', 'cftp_admin'); ?></a></li>
									</ul>
								</li>
						<?php
								}
						?>

								<li class="divider-vertical">

						<?php
							/**
							 * Show the OPTIONS menu only to
							 * System administrators
							 */
							$options_allowed = array(9);
							if (in_session_or_cookies($options_allowed)) {
						?>
								<li class="dropdown <?php if (!empty($active_nav) && $active_nav == 'options') { ?>active<?php } ?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Options', 'cftp_admin'); ?> <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URI; ?>options.php"><?php _e('General options', 'cftp_admin'); ?></a></li>
										<li class="divider"></li>
										<li><a href="<?php echo BASE_URI; ?>branding.php"><?php _e('Branding', 'cftp_admin'); ?></a></li>
										<li><a href="<?php echo BASE_URI; ?>email-templates.php"><?php _e('E-mail templates', 'cftp_admin'); ?></a></li>
									</ul>
								</li>
					<?php
							}
						}
						/** Generate the menu for clients */
						else {
							if (CLIENTS_CAN_UPLOAD == 1) {
					?>
								<li><a href="<?php echo BASE_URI; ?>upload-from-computer.php"><?php _e('Upload', 'cftp_admin'); ?></a></li>
					<?php
							}
					?>
							
							<li><a href="<?php echo BASE_URI.'my_files/'; ?>"><?php _e('Download', 'cftp_admin'); ?></a></li>
					<?php
						}
					?>
					</ul>
				</div>
     
			</div>
		</div>
    </div>

		<?php
			/**
			 * Gets the mark up abd values for the System Updated and
			 * errors messages.
			 */
			include(ROOT_DIR.'/includes/updates.messages.php');
		?>
	</header>

<?php
	/**
	 * Check if the current user has permission to view this page.
	 * If not, an error message is generated instead of the actual content.
	 * The allowed levels are defined on each individual page before the
	 * inclusion of this file.
	 */
	/*can_see_content($allowed_levels);*/
?>
