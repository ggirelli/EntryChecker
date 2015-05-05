<?php
/**
 * Connects user and server sides.
 */

// Requirements
require_once('settings.php');
require_once('include/db.class.php');

if( isset($_POST['action']) ) {

	// Move POST essentials to $data
	$data = new stdClass;
	$data->action = $_POST['action'];

} else {

	// Read POST JSON data
	$data = json_decode(file_get_contents("php://input"));
	
}

if( isset($data->action) ) {

	if( '' != $data->action ) {

		switch($data->action) {

			case 'entry':
			case 'howManyInside':
			case 'listTickets':
			case 'sale':
			case 'setNotEntered':

			{
				require_once('action/' . $data->action . '.action.php');
				break;
			}

			default: die('{"err":-1,"a":"' . $data->action . '"}');

		}

	} else {
		die('{"err":2}');
	}

} else {
	die('{"err":1}');
}

?>
