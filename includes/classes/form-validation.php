<?php
/**
 * Class that handles all the server-side form validations.
 *
 * Every generated error is added as an element to a list that will be returned
 * if any error was found.
 *
 * @package		ProjectSend
 * @subpackage	Classes
 */

/**
 * Prepare the error message mark up and content
 */
$validation_errors_title = __('The following errors were found','cftp_admin');
$before_error = '<div class="alert alert-error alert-block"><a href="#" class="close" data-dismiss="alert">&times;</a><p class="alert-title">'.$validation_errors_title.':</p><ol>';
$after_error = '</ol></div>';

class Validate_Form
{

	var $error_msg;
	var $error_complete;
	var $return_val = true;

	/** Check if the field is complete */
	private function is_complete($field, $err)
	{
		if (strlen(trim($field)) == 0) {
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/** Check if the field value is a valid e-mail address */
	private function is_email($field, $err)
	{
		if(!preg_match("/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", $field)) {
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/** Check if the field value is alphanumeric */
	private function is_alpha($field, $err)
	{
		if(preg_match('/[^0-9A-Za-z]/', $field)) {
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/** Check if the password field value contains invalid characters */
	private function is_password($field, $err)
	{
		$allowed_numbers = array('0','1','2','3','4','5','6','7','8','9');
		$allowed_lower = range('a','z');
		$allowed_upper = range('A','Z');
		$allowed_symbols = array('`','!','"','?','$','%','^','&','*','(',')','_','-','+','=','{','[','}',']',':',';','@','~','#','|','<',',','>','.',"'","/",'\\');
		$allowed_characters = array_merge($allowed_numbers,$allowed_lower,$allowed_upper,$allowed_symbols);

		$passw = str_split($field);
		$char_errors = 0;
		foreach ($passw as $p) {
			if(!in_array($p,$allowed_characters, TRUE)) {
				$char_errors++;
			}
		}
		if($char_errors > 0) {
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/** Check if the character count is within range */
	private function is_length($field, $err, $min, $max)
	{
		if(strlen($field) < $min || strlen($field) > $max){
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/** Check if both password fields match */
	function is_pass_match($err, $pass1, $pass2)
	{
		if($pass1 != $pass2) {
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/**
	 * Check if the supplied username already exists on either a client or
	 * a system user.
	 */
	private function is_user_exists($field, $err)
	{
		if (mysql_num_rows(mysql_query("SELECT * FROM tbl_users WHERE user = '$field'"))){
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/**
	 * Check if the supplied e-mail address already is already assigned to 
	 * either a client or a system user.
	 */
	private function is_email_exists($field, $err, $current_id)
	{
		$this->sql_users = "SELECT * FROM tbl_users WHERE email = '$field'";
		/**
		 * If the ID parameter is set, the validation is used when editing
		 * a client or user, and prevents an error if the current user is
		 * the owner of that e-mail address.
		 */
		if (!empty($current_id)) {
			$this->sql_not_this = " AND id != $current_id";
			$this->sql_clients .= $this->sql_not_this;
			$this->sql_users .= $this->sql_not_this;
		}

		if (mysql_num_rows(mysql_query($this->sql_users))){
			$this->error_msg .= '<li>'.$err.'</li>';
			$this->return_val = false;
		}
	}

	/** Call the requested method and pass the corresponding values */
	function validate($val_type, $field, $err='', $min='', $max='', $pass1='', $pass2='', $row='', $current_id='')
	{
		switch($val_type) {
			case 'completed':
				$this->is_complete($field, $err);
			break;
			case 'email':
				$this->is_email($field, $err);
			break;
			case 'alpha':
				$this->is_alpha($field, $err);
			break;
			case 'password':
				$this->is_password($field, $err);
			break;
			case 'length':
				$this->is_length($field, $err, $min, $max);
			break;
			case 'pass_match':
				$this->is_pass_match($err, $pass1, $pass2);
			break;
			case 'user_exists':
				$this->is_user_exists($field, $err);
			break;
			case 'email_exists':
				$this->is_email_exists($field, $err, $current_id);
			break;
		}
	}

	/**
	 * If errors were found, concatenate the container div (defined above) and the
	 * returned errors.
	 */
	function list_errors()
	{
		if (!empty($this->error_msg)) {
			/** Create the message to be returned */
			$this->error_msg = $GLOBALS['before_error'].$this->error_msg.$GLOBALS['after_error'];
			echo $this->error_msg;
			$this->return_val = false;
			/** Reset the errors list */
			$this->error_msg = '';
		}
		else {
			$this->return_val = true;
		}
	}
	
}

$valid_me = new Validate_Form();
?>