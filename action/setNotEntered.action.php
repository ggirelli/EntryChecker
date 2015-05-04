<?php
/**
 * Manages ticket entry
 */

// Requirements
require_once(dirname(dirname(__FILE__)) . '/include/db.class.php');

// Connect to database
$s = new C2MySQL(HOST, USER, PWD, DB_NAME);

$ticket = $s->escape_string($data->ticket);

$sql = "SELECT * FROM `tickets` WHERE `id`=$ticket";
$q = $s->query($sql);

if ( SU_PWD != $data->pwd ) {
	die('{"err":-2}');
}

if ( 1 != $q->size() ) {
	die('{"err":1}');
} else {
	$sql = "UPDATE `tickets` SET `when`=NULL WHERE `id`=$ticket";
	$q = $s->query($sql);

	if ( $s->isError() ) {
		die('{"err":-1}');
	} else {
		die('{"err":0,"id":' . $ticket . '}');
	}
}

?>