<?php
/**
 * Common information used on all clients templates.
 * Avoids the need to define all of this when creating a new template.
 *
 * @package		ProjectSend
 * @subpackage	Templates
 */

/**
 * Since the header.php file is shared between the back-end and the
 * templates, it's necessary to define the allowed levels, or else
 * the files list will not be available.
 */


/**
 * Define a variable that will tell header.php if session_start()
 * needs to be called or not (since it is also called from
 * session_check.php
 */
$is_template = true;

/**
 * Loads a language file from the current template folder based on
 * the system options.
 */
$lang = SITE_LANG;
if(!isset($ld)) { $ld = 'cftp_admin'; }
require_once(ROOT_DIR.'/includes/classes/i18n.php');
//include(ROOT_DIR.'/process.php');




I18n::LoadDomain(ROOT_DIR."/templates/".TEMPLATE_USE."/lang/{$lang}.mo", $ld);

$this_template = BASE_URI.'templates/'.TEMPLATE_USE.'/';


/**
 * URI to the default template CSS file.
 */
$this_template_css = BASE_URI.'templates/'.TEMPLATE_USE.'/main.css';

$database->MySQLDB();

/**
 * Get all the client's information
 */



	$f = 0;
	
	$files_query = "SELECT * FROM tbl_files WHERE ";

	/** Add the search terms */	
	if(isset($_POST['search']) && !empty($_POST['search'])) {
	
		$search_terms		= $_POST['search'];
		$files_query		.=  "uploader =  '$search_terms'";
		$no_results_error	= 'search';
	}

	$sql_files = $database->query($files_query);
	while($data = mysql_fetch_array($sql_files)) {

		$add_file	= true;
		$expired	= false;

		/** Does it expire? */
		if ($data['expires'] == '1') {
			if (time() > strtotime($data['expiry_date'])) {
				if (EXPIRED_FILES_HIDE == '1') {
					$add_file = false;
				}
				$expired = true;
			}
		}

		/** Make the list of files */
		if ($add_file == true) {
		
			$my_files[$f] = array(
								//'origin'		=> $origin,
								'id'			=> $data['id'],
								'url'			=> $data['url'],
								'name'			=> $data['filename'],
								'description'	=> $data['description'],
								'timestamp'		=> $data['timestamp'],
								'expired'		=> $expired,
							);
			$f++;
		}
	}
	
	
	
	if (count($my_files) >= 2 ) {
	//can download in zipped folder
	/*
		$.get('<?php echo BASE_URI; ?>process.php', { do:"zip_download", client:"<?php echo CURRENT_USER_USERNAME; ?>", files:checkboxes },
							function(data) {
								$('.modal_content').append("<iframe src='<?php echo BASE_URI; ?>process-zip-download.php?file="+data+"'></iframe>");
								// Close the modal window
								//remove_modal();
							}
						);
	
	
	*/
	
	
	
	
	$zip_file = tempnam("tmp", "zip");
	$zip = new ZipArchive();
	$zip->open($zip_file, ZipArchive::OVERWRITE);

$files_to_zip = explode(',',substr($_GET['file'], 0, -1));//////////////////////////




$added_files = 0;

$current_level = get_current_user_level();
$current_username = get_current_user_username();





$allowed_to_zip = array_unique($allowed_to_zip);

/** Start adding the files to the zip */

foreach ($my_files as $file){

	$zip->addFile(UPLOADED_FILES_FOLDER.$file['url'],$file['url']);
	$added_files++;
}


$zip->close();

if ($added_files > 0) {

	/** Record the action log */
	$new_log_action = new LogActions();
	$log_action_args = array(
							'action' => 9,
							'owner_id' => $global_id,
							'affected_account_name' => $current_username
						);
	$new_record_action = $new_log_action->log_action_save($log_action_args);

	if (file_exists($zip_file)) {
		$zip_file_name = 'download_files_'.generateRandomString().'.zip';
		header('Content-Type: application/zip');
		header('Content-Length: ' . filesize($zip_file));
		header('Content-Disposition: attachment; filename="'.$zip_file_name.'"');
		ob_clean();
		flush();
		readfile($zip_file);
		unlink($zip_file);
	}
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}
	else if (count($my_files) >= 1 ){
	//download one file
	

	foreach ($my_files as $file){

	
	$path = UPLOADED_FILES_FOLDER. $file['url'];
		
		if (file_exists($path)) {
	
			while (ob_get_level()) ob_end_clean();
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($path));
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Cache-Control: private',false);
			header('Content-Length: ' . get_real_size($path));
			header('Connection: close');
			readfile($path);
		
		}
	
}
		
	
		
				
	

					
					
					
		
		
	
	
	

	
	//get link
	}
	else
	{
	//Nothing to see 
	//show alert?
	}
	
/* if multiple things are found then download a zip otherwise download just the file */



/** Get the url for the logo from "Branding" */
$logo_file_info = generate_logo_url();
?>