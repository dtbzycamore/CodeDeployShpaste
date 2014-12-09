
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

 
		
	</header>


