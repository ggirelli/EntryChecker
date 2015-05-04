<?php
/**
 * Manages ticket entry
 */

// Requirements
require_once(dirname(dirname(__FILE__)) . '/include/db.class.php');

// Connect to database
$s = new C2MySQL(HOST, USER, PWD, DB_NAME);

$ticket = $s->escape_string($data->ticket);
$residency = $s->escape_string($data->residency);

$sql = "SELECT * FROM `tickets` WHERE `id`=$ticket AND `residency`=$residency";
$q = $s->query($sql);

if ( 0 == $q->size() ) {
	// Unknown ticket
	die('{"err":1, "size":0, "ticket":' . $ticket . '}');

} elseif ( 1 != $q->size() ) {
	// Ticket error
	die('{"err":2, "size":' . $q->size() . ', "ticket":' . $ticket . '}');

} else {
	// Fetch ticket information
	$r = $q->fetch();

	if ( '' == $r['name'] ) {
		// Unsold ticket
		die('{"err":0, "size":1, "sold":0, "ticket":' . $ticket . '}');

	} else {
		if ( '' == $r['when'] ) {
			// Still have to enter
			$sql = "UPDATE `tickets` SET `when`=CURRENT_TIMESTAMP WHERE `id`=$ticket";
			$q = $s->query($sql);

			if ( $s->isError() ) {
				die('{"err":-1}');
			}

			die('{"err":0, "size":1, "sold":1, "entered":0, "entering":1, "ticket":' . $ticket . '}');

		} else {
			// Already entered
			die('{"err":0, "size":1, "sold":1, "entered":1, "ticket":' . $ticket . '}');
		}
	}
}

?>