<?php
/**
 * Show the list of current clients.
 *
 * @package		ProjectSend
 * @subpackage	Clients
 *
 */
$tablesorter = 1;
$allowed_levels = array(9,8);
require_once('sys.includes.php');

$active_nav = 'clients';

$page_title = __('Clients Administration','cftp_admin');
include('header.php');
?>

<script type="text/javascript">
$(document).ready(function() {
	$("#clients_tbl").tablesorter( {
		sortList: [[1,0]],
		widgets: ['zebra'], headers: {
			0: { sorter: false },
			13: { sorter: false }
		},
		textExtraction: dataExtraction
	})
	.tablesorterPager({container: $("#pager")})

	$("#select_all").click(function(){
		var status = $(this).prop("checked");
		$("td>input:checkbox").prop("checked",status);
	});
	
	$("#view_reduced").click(function(){
		$(this).addClass('active_view_button');
		$("#view_full").removeClass('active_view_button');
		$(".extra").hide();
	});
	$("#view_full").click(function(){
		$(this).addClass('active_view_button');
		$("#view_reduced").removeClass('active_view_button');
		$(".extra").show();
	});
	
	$("#do_action").click(function() {
		var checks = $("td>input:checkbox").serializeArray(); 
		if (checks.length == 0) { 
			alert('<?php _e('Please select at least one client to proceed.','cftp_admin'); ?>');
			return false; 
		} 
		else {
			var action = $('#clients_actions').val();
			if (action == 'delete') {
				var msg_1 = '<?php _e("You are about to delete",'cftp_admin'); ?>';
				var msg_2 = '<?php _e("clients and all of the assigned files. Are you sure you want to continue?",'cftp_admin'); ?>';
				if (confirm(msg_1+' '+checks.length+' '+msg_2)) {
					return true;
				} else {
					return false;
				}
			}
		}
	});
});
</script>

<div id="main">
	<h2><?php echo $page_title; ?></h2>
	
<?php
	/**
	 * Apply the corresponding action to the selected clients.
	 */
	if(isset($_POST['clients_actions'])) {
		/** Continue only if 1 or more clients were selected. */
		if(!empty($_POST['selected_clients'])) {
			$selected_clients = $_POST['selected_clients'];
			$clients_to_get = implode(',',array_unique($selected_clients));

			/**
			 * Make a list of users to avoid individual queries.
			 */
			$sql_user = $database->query("SELECT id, name FROM tbl_users WHERE id IN ($clients_to_get)");
			while($data_user = mysql_fetch_array($sql_user)) {
				$all_users[$data_user['id']] = $data_user['name'];
			}

			switch($_POST['clients_actions']) {
				case 'activate':
					/**
					 * Changes the value on the "active" column value on the database.
					 * Inactive clients are not allowed to log in.
					 */
					foreach ($selected_clients as $work_client) {
						$this_client = new ClientActions();
						$hide_client = $this_client->change_client_active_status($work_client,'1');
					}
					$msg = __('The selected clients were marked as active.','cftp_admin');
					echo system_message('ok',$msg);
					$log_action_number = 19;
					break;

				case 'deactivate':
					/**
					 * Reverse of the previous action. Setting the value to 0 means
					 * that the client is inactive.
					 */
					foreach ($selected_clients as $work_client) {
						$this_client = new ClientActions();
						$hide_client = $this_client->change_client_active_status($work_client,'0');
					}
					$msg = __('The selected clients were marked as inactive.','cftp_admin');
					echo system_message('ok',$msg);
					$log_action_number = 20;
					break;

				case 'delete':
					foreach ($selected_clients as $client) {
						$this_client = new ClientActions();
						$delete_client = $this_client->delete_client($client);
					}
					
					$msg = __('The selected clients were deleted.','cftp_admin');
					echo system_message('ok',$msg);
					$log_action_number = 17;
					break;
			}

			/** Record the action log */
			foreach ($selected_clients as $client) {
				$new_log_action = new LogActions();
				$log_action_args = array(
										'action' => $log_action_number,
										'owner_id' => $global_id,
										'affected_account_name' => $all_users[$client]
									);
				$new_record_action = $new_log_action->log_action_save($log_action_args);
			}
		}
		else {
			$msg = __('Please select at least one client.','cftp_admin');
			echo system_message('error',$msg);
		}
	}

	/** Query the clients */
	$database->MySQLDB();
	$cq = "SELECT * FROM tbl_users WHERE level='0'";

	/** Add the search terms */	
	if(isset($_POST['search']) && !empty($_POST['search'])) {
		$search_terms = $_POST['search'];
		$cq .= " AND (name LIKE '%$search_terms%' OR user LIKE '%$search_terms%' OR address LIKE '%$search_terms%' OR phone LIKE '%$search_terms%' OR email LIKE '%$search_terms%' OR contact LIKE '%$search_terms%')";
		$no_results_error = 'search';
	}

	/** Add the status filter */	
	if(isset($_POST['status']) && $_POST['status'] != 'all') {
		$status_filter = $_POST['status'];
		$cq .= " AND active='$status_filter'";
		$no_results_error = 'filter';
	}
	
	$cq .= " ORDER BY name ASC";

	$sql = $database->query($cq);
	$count = mysql_num_rows($sql);
?>
		<div class="form_actions_left">
			<div class="form_actions_limit_results">
				<form action="clients.php" name="clients_search" method="post" class="form-inline">
					<input type="text" name="search" id="search" value="<?php if(isset($_POST['search']) && !empty($_POST['search'])) { echo $_POST['search']; } ?>" class="txtfield form_actions_search_box" />
					<button type="submit" id="btn_proceed_search" class="btn btn-small"><?php _e('Search','cftp_admin'); ?></button>
				</form>

				<form action="clients.php" name="clients_filters" method="post" class="form-inline">
					<select name="status" id="status" class="txtfield">
						<option value="all"><?php _e('All statuses','cftp_admin'); ?></option>
						<option value="1"><?php _e('Active','cftp_admin'); ?></option>
						<option value="0"><?php _e('Inactive','cftp_admin'); ?></option>
					</select>
					<button type="submit" id="btn_proceed_filter_clients" class="btn btn-small"><?php _e('Filter','cftp_admin'); ?></button>
				</form>
			</div>
		</div>

		<form action="clients.php" name="clients_list" method="post" class="form-inline">
			<div class="form_actions_right">
				<div class="form_actions">
					<div class="form_actions_submit">
						<label><?php _e('Selected clients actions','cftp_admin'); ?>:</label>
						<select name="clients_actions" id="clients_actions" class="txtfield">
							<option value="activate"><?php _e('Activate','cftp_admin'); ?></option>
							<option value="deactivate"><?php _e('Deactivate','cftp_admin'); ?></option>
							<option value="delete"><?php _e('Delete','cftp_admin'); ?></option>
						</select>
						<button type="submit" id="do_action" name="proceed" class="btn btn-small"><?php _e('Proceed','cftp_admin'); ?></button>
					</div>
				</div>
			</div>
			<div class="clear"></div>

			<div class="form_actions_count">
				<p class="form_count_total"><?php _e('Showing','cftp_admin'); ?>: <span><?php echo $count; ?> <?php _e('clients','cftp_admin'); ?></span></p>
				<ul id="table_view_modes">
					<li><a href="#" id="view_reduced" class="active_view_button"><?php _e('View reduced table','cftp_admin'); ?></a></li><li>
						<a href="#" id="view_full"><?php _e('View full table','cftp_admin'); ?></a></li>
				</ul>
			</div>

			<div class="clear"></div>

			<?php
				if (!$count) {
					if (isset($no_results_error)) {
						switch ($no_results_error) {
							case 'search':
								$no_results_message = __('Your search keywords returned no results.','cftp_admin');;
								break;
							case 'filter':
								$no_results_message = __('The filters you selected returned no results.','cftp_admin');;
								break;
						}
					}
					else {
						$no_results_message = __('There are no clients at the moment','cftp_admin');;
					}
					echo system_message('error',$no_results_message);
				}
			?>

			<table id="clients_tbl" class="tablesorter vertical_middle extra_columns_table">
				<thead>
					<tr>
						<th class="td_checkbox">
							<input type="checkbox" name="select_all" id="select_all" value="0" />
						</th>
						<th><?php _e('Full name','cftp_admin'); ?></th>
						<th><?php _e('Log in username','cftp_admin'); ?></th>
						<th><?php _e('E-mail','cftp_admin'); ?></th>
						<th><?php _e('Files: Own','cftp_admin'); ?></th>
						<th><?php _e('Files: Groups','cftp_admin'); ?></th>
						<th><?php _e('Status','cftp_admin'); ?></th>
						<th><?php _e('Groups on','cftp_admin'); ?></th>
						<th class="extra"><?php _e('Notify','cftp_admin'); ?></th>
						<th class="extra"><?php _e('Added on','cftp_admin'); ?></th>
						<th class="extra"><?php _e('Address','cftp_admin'); ?></th>
						<th class="extra"><?php _e('Telephone','cftp_admin'); ?></th>
						<th class="extra"><?php _e('Internal contact','cftp_admin'); ?></th>
						<th><?php _e('Actions','cftp_admin'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if ($count > 0) {
							while($row = mysql_fetch_array($sql)) {
								$found_groups = '';
								$client_user = $row["user"];
								$client_id = $row["id"];
								$sql_groups = $database->query("SELECT DISTINCT group_id FROM tbl_members WHERE client_id='$client_id'");
								$count_groups = mysql_num_rows($sql_groups);
								if ($count_groups > 0) {
									while($row_groups = mysql_fetch_array($sql_groups)) {
										$groups_ids[] = $row_groups["group_id"];
									}
									$found_groups = implode(',',$groups_ids);
								}
								$date = date(TIMEFORMAT_USE,strtotime($row['timestamp']));
					?>
								<tr>
									<td><input type="checkbox" name="selected_clients[]" value="<?php echo $row["id"]; ?>" /></td>
									<td><?php echo html_entity_decode($row["name"]); ?></td>
									<td><?php echo html_entity_decode($row["user"]); ?></td>
									<td><?php echo html_entity_decode($row["email"]); ?></td>
									<td>
										<?php
											$own_files = 0;
											$groups_files = 0;

											$fq = "SELECT DISTINCT id, file_id, client_id, group_id FROM tbl_files_relations WHERE client_id='$client_id'";
											if (!empty($found_groups)) {
												$fq .= " OR group_id IN ($found_groups)";
											}
											$sql_files = $database->query($fq);
											$count_files = mysql_num_rows($sql_files);
											while($row_files = mysql_fetch_array($sql_files)) {
												if (!is_null($row_files['client_id'])) {
													$own_files++;
												}
												else {
													$groups_files++;
												}
											}
											
											echo $own_files;
										?>
									</td>
									<td><?php echo $groups_files; ?>
									</td>
									<td>
										<?php
											$status_hidden	= __('Inactive','cftp_admin');
											$status_visible	= __('Active','cftp_admin');
											$label			= ($row['active'] === '0') ? $status_hidden : $status_visible;
											$class			= ($row['active'] === '0') ? 'important' : 'success';
										?>
										<span class="label label-<?php echo $class; ?>">
											<?php echo $label; ?>
										</span>
									</td>
									<td><?php echo $count_groups; ?></td>
									<td class="extra"><?php if ($row["notify"] == '1') { _e('Yes','cftp_admin'); } else { _e('No','cftp_admin'); }?></td>
									<td class="extra">
										<span class="hidden"><?php echo strtotime($row['timestamp']); ?></span>
										<?php echo $date; ?>
									</td>
									<td class="extra"><?php echo html_entity_decode($row["address"]); ?></td>
									<td class="extra"><?php echo html_entity_decode($row["phone"]); ?></td>
									<td class="extra"><?php echo html_entity_decode($row["contact"]); ?></td>
									<td>
										<?php
											if ($own_files + $groups_files > 0) {
												$files_link = 'manage-files.php?client_id='.$row["id"];
												$files_button = 'btn-primary';
											}
											else {
												$files_link = '#';
												$files_button = 'disabled';
											}

											if ($count_groups > 0) {
												$groups_link = 'groups.php?member='.$row["id"];
												$groups_button = 'btn-primary';
											}
											else {
												$groups_link = '#';
												$groups_button = 'disabled';
											}
										?>
										<a href="<?php echo $files_link; ?>" class="btn btn-small <?php echo $files_button; ?>"><?php _e('Manage files','cftp_admin'); ?></a>
										<a href="<?php echo $groups_link; ?>" class="btn btn-small <?php echo $groups_button; ?>"><?php _e('View groups','cftp_admin'); ?></a>
										<a href="my_files/?client=<?php echo $row["user"]; ?>" class="btn btn-primary btn-small" target="_blank"><?php _e('View as client','cftp_admin'); ?></a>
										<a href="clients-edit.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary btn-small"><?php _e('Edit','cftp_admin'); ?></a>
									</td>
								</tr>
					<?php
							}
							$database->Close();
						}
					?>
				</tbody>
			</table>
		</form>

		<?php if ($count > 10) { ?>
			<div id="pager" class="pager">
				<form>
					<input type="button" class="first pag_btn" value="<?php _e('First','cftp_admin'); ?>" />
					<input type="button" class="prev pag_btn" value="<?php _e('Prev.','cftp_admin'); ?>" />
					<span><strong><?php _e('Page','cftp_admin'); ?></strong>:</span>
					<input type="text" class="pagedisplay" disabled="disabled" />
					<input type="button" class="next pag_btn" value="<?php _e('Next','cftp_admin'); ?>" />
					<input type="button" class="last pag_btn" value="<?php _e('Last','cftp_admin'); ?>" />
					<span><strong><?php _e('Show','cftp_admin'); ?></strong>:</span>
					<select class="pagesize">
						<option selected="selected" value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="40">40</option>
					</select>
				</form>
			</div>
		<?php } else { ?>
			<div id="pager">
				<form>
					<input type="hidden" value="<?php echo $count; ?>" class="pagesize" />
				</form>
			</div>
		<?php } ?>

	</div>

</div>

<?php include('footer.php'); ?>