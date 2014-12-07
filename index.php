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

<div id="main">
	<h2><?php echo $page_title; ?></h2>
	
<?php    







					
					
					
				
	


if(isset($_POST['hashtag'])){ //check if form was submitted





//print_r($_POST);




/**
 * Get the user level to determine if the uploader is a
 * system user or a client.
 */
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

/**
 * A posted form will include information of the uploaded files
 * (name, description and client).
 */


	
	
		/**
		 * Get the ID of the current client that is uploading files.
		
		if ($current_level == 0) {
			$client_my_info = get_client_by_username($global_user);
			$client_my_id = $client_my_info["id"];
		}
		
		 */
		
		$n = 0;
		$hashtag =  $_POST['hashtag'];//"hashtagtest";
		print_r($_POST);
		foreach ($_POST['finished_files'] as $file) {
			$n++;
				echo 'sorry';
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
				
				echo 'location: ' . $location;
				//if(file_exists($location)) {if it made it to the upload folder
				
					
				/**
					 * If the file isn't already on the database, rename/chmod.
					 */
					
					
					@mkdir(work_folder. $hashtag. '/';
					if (!in_array($file,$urls_db_files)) {
						$move_arguments = array(
												'uploaded_name' => $location,
												'filename' => 'hashtag/'.$file
											);
						//$new_filename = $this_upload->upload_move($move_arguments);
					}
					else {
						$new_filename = $file;
					}
					
					echo 'filename: ' . $new_filename;
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
						echo 'add to database';
						$process_file = $this_upload->upload_add_to_database($add_arguments);
					}
			
				
				
				}
					
			else {
				$empty_fields++;
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
			<p>
				<?php
					_e('Click on Add files to select all the files that you want to upload, and then click Upload Files.  Remember that the maximum allowed file size (in mb.) is ','cftp_admin');
					echo '<strong>'.MAX_FILESIZE.'</strong>.';
				?>
			</p>
			

			
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
					
						
					});
				});
			</script>
	
			
			<form action="" name="upload_by_client" id="upload_by_client" method="post" enctype="multipart/form-data">
				<input type="hidden" name="uploaded_files" id="uploaded_files" value="" />
				<div id="uploader">
					<div class="message message_error">
						<p><?php _e("Your browser doesn't support HTML5, Flash or Silverlight. Please update your browser or install Adobe Flash or Silverlight to continue.",'cftp_admin'); ?></p>
					</div>
				</div>
					<div style = "text-align: center">
						<h3>Hashtag</h3>
				<input type="text" name="hashtag" id="hashtag2"  value="" />
				</div>
				<div class="after_form_buttons">
					<button type="submit" name="Submit" class="btn btn-wide btn-primary" id="btn-submit"><?php _e('Upload files','cftp_admin'); ?></button>
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
	include('footer.php');
?>
