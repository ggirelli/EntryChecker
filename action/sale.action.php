<?php
/**
 * Manages ticket entry
 */

// Requirements
require_once(dirname(dirname(__FILE__)) . '/include/db.class.php');

// Connect to database
$s = new C2MySQL(HOST, USER, PWD, DB_NAME);

$pwd = $s->escape_string($data->pwd);
if ( SU_PWD != $data->pwd ) {
	die('{"err":-1}');
}

$ticket = $s->escape_string($data->ticket);
$name = $s->escape_string($data->name);
$residency = 0;
if ( "R" == $ticket[0] ) {
	$residency = 1;
}

$sql = "SELECT * FROM `tickets` WHERE `id`='$ticket' AND `residency`=$residency";
$q = $s->query($sql);

if ( 0 == $q->size() ) {
	// Unknown ticket
	die('{"err":1}');
} else if ( 1 < $q->size() ) {
	// Ticket error
	die('{"err":2}');
} else {
	$r = $q->fetch();
	if ( "" != $r['name'] ) {
		// Already sold
		die('{"err":3}');
	} else {
		$sql = "UPDATE `tickets` SET `name`='" . $name . "' WHERE `id`='$ticket' AND `residency`=$residency";
		$q = $s->query($sql);

		if ( $s->isError() ) {
			// Could not reach the db
			die('{"err":4}');
		} else {
			// Sold
			die('{"err":0}');
		}
	}
}

?>