<?php
/**
 * Uploading files from computer, step 1
 * Shows the plupload form that handles the uploads and moves
 * them to a temporary folder. When the queue is empty, the user
 * is redirected to step 2, and prompted to enter the name,
 * description and client for each uploaded file.
 *
 * @package ProjectSend
 * @subpackage Upload
 */
$plupload = 1;
require_once('sys.includes.php');

$active_nav = 'files';

$page_title = __('Upload files', 'cftp_admin');

$allowed_levels = array(9,8,7);
if (CLIENTS_CAN_UPLOAD == 1) {
	$allowed_levels[] = 0;
}
include('hashtag/header.php');


$database->MySQLDB();
?>
<style>
#uploader {
     max-width: 600px;
  margin-left: auto ;
  margin-right: auto ;
}
</style>
<div id="main">
	
<div id="top">	
<?php    


if(isset($_POST['hashtag'])){ //check if form was submitted


if ($_POST['Submit'] == 'Download'){

	$f = 0;
	
	$files_query = "SELECT * FROM tbl_files WHERE uploader = '" . $_POST['hashtag'] . "'" ;


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

if ($added_files >= 2) {

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
}
else{

$current_level = get_current_user_level();

$work_folder = UPLOADED_FILES_FOLDER;





/** Coming from the web uploader */
if(isset($_POST['finished_files'])) {
	$uploaded_files = array_filter($_POST['finished_files']);

}


/**
 * A hidden field sends the list of failed files as a string,
 * where each filename is separated by a comma.
 * Here we change it into an array so we can list the files
 * on a separate table.
 */
if(isset($_POST['upload_failed'])) {
	$upload_failed_hidden_post = array_filter(explode(',',$_POST['upload_failed']));
}
/**
 * Files that failed are removed from the uploaded files list.
 */
if(isset($upload_failed_hidden_post) && count($upload_failed_hidden_post) > 0) {
	foreach ($upload_failed_hidden_post as $failed) {
		$delete_key = array_search($failed, $uploaded_files);					
		unset($uploaded_files[$delete_key]);
	}
}

/** Define the arrays */
$upload_failed = array();
$move_failed = array();
$upload_finish_orphans = array();

/**
 * $empty_fields counts the amount of "name" fields that
 * were not completed.
 */
$empty_fields = 0;



/** Fill the users array that will be used on the notifications process */
$users = array();
$cq = "SELECT id, name, level FROM tbl_users ORDER BY name ASC";
$sql = $database->query($cq);
while($row = mysql_fetch_array($sql)) {
	$users[$row["id"]] = $row["name"];
	if ($row["level"] == '0') {
		$clients[$row["id"]] = $row["name"];
	}
}
/** Fill the groups array that will be used on the form */
$groups = array();
$cq = "SELECT id, name FROM tbl_groups ORDER BY name ASC";
$sql = $database->query($cq);
	while($row = mysql_fetch_array($sql)) {
	$groups[$row["id"]] = $row["name"];
}

/**
 * Make an array of file urls that are on the DB already.
 */
$sql = $database->query("SELECT DISTINCT url FROM tbl_files");
$urls_db_files = array();

while($row = mysql_fetch_array($sql)) {
	$urls_db_files[] = $row["url"];
}


		
		$n = 0;
		$hashtag =  $_POST['hashtag'];//"hashtagtest";
	
		foreach ($_POST['finished_files'] as $file) {
			$n++;
				
			if(!empty($hashtag)) {
				/**
				* If the uploader is a client, set the "client" var to the current
				* uploader username, since the "client" field is not posted.
				*/
				
			
				
				$this_upload = new PSend_Upload_File();
				//need to do a better check to make sure file name is unique
				/*
					$temp_file = $file;
					while (   in_array($temp_file,$urls_db_files){
					$temp_file = 'a' . $file;
					}
					$file = $temp_file;
					*/
				
				if (!in_array($file,$urls_db_files)) {
					$file = $this_upload->safe_rename( $file);
				}
				
				
				//get a unique file name
				
				$location = $work_folder.$file;
				$second_location = $work_folder.$file;
				
				//if(file_exists($location)) {if it made it to the upload folder
				
					
				/**
					 * If the file isn't already on the database, rename/chmod.
					 */
					
					$second_location = $hashtag .'/'.$file;
					mkdir($work_folder. $hashtag. '/');
				
						$move_arguments = array(
												'uploaded_name' => $location,
												'filename' => $second_location
											);
						$new_filename = $this_upload->upload_move($move_arguments);
					
					
					
				
					if (!empty($new_filename)) {
						
						$delete_key = array_search($file, $uploaded_files);					
						unset($uploaded_files[$delete_key]);

						/**
						 * Unassigned files are kept as orphans and can be related
						 * to clients or groups later.
						 */

						/** Add to the database for each client / group selected */
						$add_arguments = array(
												'file' => $new_filename,
												'name' => $file,
												'description' => $file,
												'uploader' => $hashtag,
												'uploader_id' => $global_id
											);

						
						
						
						/*always act like admin */
							$add_arguments['uploader_type'] = 'user';
							if (!empty($file['expires'])) {
								$add_arguments['expires'] = '1';
								$add_arguments['expiry_date'] = $file['expiry_date'];
							}
							
								$add_arguments['public'] = '1';
							
						
						
						
						
							$add_arguments['add_to_db'] = true;
						

						/**
						 * 1- Add the file to the database
						 */
					
						$process_file = $this_upload->upload_add_to_database($add_arguments);
					}
			
				
				
				}
					
			else {
				$empty_fields++;
			}
		}
	}

}

?>
	
	
	<?php
		/** Count the clients to show an error or the form */
		$sql = $database->query("SELECT * FROM tbl_users WHERE level = '0'");
		$count = mysql_num_rows($sql);
		if (!$count) {
			/** Echo the no clients default message */
			message_no_clients();
		}
		else { 
	?>
	
			
		

			
<script type="text/javascript">
				$(document).ready(function() {
					setInterval(function(){
						// Send a keep alive action every 1 minute
						var timestamp = new Date().getTime()
						$.ajax({
							type:	'GET',
							cache:	false,
							url:	'includes/ajax-keep-alive.php',
							data:	'timestamp='+timestamp,
							success: function(result) {
								var dummy = result;
							}
						});
					},1000*60);
				});

					$(document).ready(function() {
						$('#hashtag2').bind('input propertychange', function() {
						//need this to hide the top part if hashtag is available or 
						

					if (document.getElementById('hashtag2').value == '') {
						document.getElementById("uploader").style.display = 'none';
						document.getElementById("btn-submit").style.display  = 'none';
						return false;
						}
						else{
					
						
							var url = "http://tagdat.net/process.php?do=domain&domain=" +  document.getElementById('hashtag2').value  ;
							var xmlHttp;
						
							
							if (window.XMLHttpRequest)
							  {// code for IE7+, Firefox, Chrome, Opera, Safari
							  xmlHttp=new XMLHttpRequest();
							  }
							else
							  {// code for IE6, IE5
							  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
							  }
							
							xmlHttp.onreadystatechange=function()
							  {
							  
							  if (xmlHttp.readyState==4 && xmlHttp.status==200)
								{
								
									var available =  xmlHttp.responseText;
								
									
									document.getElementById("btn-submit").style.display  = '';
								  if (available.trim() == "no"){
										document.getElementById("uploader").style.display = 'none';
										document.getElementById("btn-submit").value = 'Download';
									  return false;
								  }
								  else{
									document.getElementById("uploader").style.display = 'block';
									document.getElementById("btn-submit").value = 'Upload';
								  }
								}
								else
								{
								
								}
							  }
							xmlHttp.open( "GET", url, true );
							xmlHttp.send();
							
						
						}
						if (document.getElementById('hashtag2').value == '') {
						document.getElementById("uploader").style.display = 'none';
						document.getElementById("btn-submit").style.display  = 'none';
						return false;
						}
						
						
						
						
						});
					});
	
				
					
				
				$(function() {
					$("#uploader").pluploadQueue({
					
				
					
					
						runtimes : 'html5,flash,silverlight,html4',
						url : 'process-upload.php',
						max_file_size : '<?php echo MAX_FILESIZE; ?>mb',
						chunk_size : '1mb',
						multipart : true,
						filters : [
							{title : "Allowed files", extensions : "<?php echo $options_values['allowed_file_types']; ?>"}
						],
						flash_swf_url : 'includes/plupload/js/plupload.flash.swf',
						silverlight_xap_url : 'includes/plupload/js/plupload.silverlight.xap',
						preinit: {
							Init: function (up, info) {
								$('#uploader_container').removeAttr("title");
							}
						}
						/*
						, init : {
							QueueChanged: function(up) {
								var uploader = $('#uploader').pluploadQueue();
								uploader.start();
							}
						}
						*/
					});

					$('form').submit(function(e) {
				
					
						if (document.getElementById("btn-submit").value == 'Upload'){
						
					
						
						
						

							var uploader = $('#uploader').pluploadQueue();
		
							if (uploader.files.length > 0) {
								uploader.bind('StateChanged', function() {
									if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
										$('form')[0].submit();
									}
								});
									
								uploader.start();

								$("#btn-submit").hide();
								$(".message_uploading").fadeIn();
								
								uploader.bind('FileUploaded', function (up, file, info) {
									var obj = JSON.parse(info.response);
									var new_file_field = '<input type="hidden" name="finished_files[]" value="'+obj.NewFileName+'" />'
									$('form').append(new_file_field);
								});
			
								return false;
							} else {
								alert('<?php _e("You must select at least one file to upload.",'cftp_admin'); ?>');
							}
					
							return false;
					}
					else{
					
					}
						
					});
				});
			</script>
	
			</div>
			<form action="" name="upload_by_client" id="upload_by_client" method="post" enctype="multipart/form-data">
						<div style = "text-align: center">
						
						
						<img src="http://tagdat.net/img/custom/logo/test.jpg">
				<br>
				<br>
				<br>
				<br>
				
				<input type="text" name="hashtag" id="hashtag2" style="width:50%" value="" />
					<input type="button" id="help_btn" style="margin-bottom: 7px;" value = "?"/>
				</div>
					<script>
				$(function() {
					  $("#help_btn").click( function()
						   {
							 alert('Instructions: \n\n1. Type a \"tag\" into the search bar\n2. If the tag already exists, download the content!\n3. If the tag does not exist, upload your desired content to that tag\n4. Share your tag and content or retrieve it yourself from anywhere for up to 30 minutes for FREE!');
						   }
					  );
					});
					
					
					

			</script>
				<input type="hidden" name="uploaded_files" id="uploaded_files" value="" />
				<div id="uploader" style ="display:none">
					<div class="message message_error">
						<p><?php _e("Your browser doesn't support HTML5, Flash or Silverlight. Please update your browser or install Adobe Flash or Silverlight to continue.",'cftp_admin'); ?></p>
					</div>
				</div>
			
		
				<div class="after_form_buttons" style = "text-align:center">
					<!--<button type="submit" name="Submit" class="btn btn-wide btn-primary" id="btn-submit"><?php _e('Upload files','cftp_admin'); ?></button>-->
					<input  type="submit" name="Submit" class="btn btn-wide btn-primary" id="btn-submit" value="Download" style = "text-align:center; display:none">
				
				</div>
				
				
			
				<div class="message message_info message_uploading">
					<p><?php _e("Your files are being uploaded! Progress indicators may take a while to update, but work is still being done behind the scenes.",'cftp_admin'); ?></p>
				</div>
			</form>
		
	<?php
		/** End if for users count */
		}
	?>

</div>

<?php
	$database->Close();
	//include('footer.php');
?>
