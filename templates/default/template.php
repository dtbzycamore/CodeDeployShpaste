<?php
/*
Template name:
Default
*/

$ld = 'cftp_template'; // specify the language domain for this template
include_once(ROOT_DIR.'/templates/common.php'); // include the required functions for every template

$window_title = __('File downloads','cftp_template');

$tablesorter = 1;


include_once(ROOT_DIR.'/hashtag/header.php'); // include the required functions for every template
$count = count($my_files);



?>

	<div id="wrapper">
	
	
		<div id="right_column">
	
			<div class="form_actions_left" style= "text-align:center">
				<div class="form_actions_limit_results" ">
					<form action="" name="files_search" method="post" class="form-inline">
					<h3>Hashtag</h3>
						<input type="text" name="search" id="search" value="<?php if(isset($_POST['search']) && !empty($_POST['search'])) { echo $_POST['search']; } ?>" class="txtfield form_actions_search_box" />
						<button type="submit" id="btn_proceed_search" class="btn btn-small">Download</button>
					</form>
				</div>
			</div>
		
			
		
			
	
		</div> <!-- right_column -->
	
	
	</div> <!-- wrapper -->
	
	<?php default_footer_info(); ?>

	<script type="text/javascript">
		$(document).ready(function() {
			

			

			$("#do_action").click(function() {
				var checks = $("td>input:checkbox").serializeArray(); 
				if (checks.length == 0) { 
					alert('<?php _e('Please select at least one file to proceed.','cftp_admin'); ?>');
					return false; 
				} 
				else {
					var action = $('#files_actions').val();
					if (action == 'zip') {

						var checkboxes = $.map($('input:checkbox:checked'), function(e,i) {
							if (e.value != '0') {
								return +e.value;
							}
						});
						alert(checkboxes);
						$(document).psendmodal();
						$('.modal_content').html('<p class="loading-img"><img src="<?php echo BASE_URI; ?>img/ajax-loader.gif" alt="Loading" /></p>'+
													'<p class="lead text-center text-info"><?php _e('Please wait while your download is prepared.','cftp_admin'); ?></p>'+
													'<p class="text-center text-info"><?php _e('This operation could take a few minutes, depending on the size of the files.','cftp_admin'); ?></p>'
												);
						
						$.get('<?php echo BASE_URI; ?>process.php', { do:"zip_download", client:"<?php echo CURRENT_USER_USERNAME; ?>", files:checkboxes },
							function(data) {
								$('.modal_content').append("<iframe src='<?php echo BASE_URI; ?>process-zip-download.php?file="+data+"'></iframe>");
								// Close the modal window
								//remove_modal();
							}
						);
					}
				return false;
				}
			});

		});
	</script>

</body>
</html>
<?php $database->Close(); ?>