<?php
/**
 * Manages ticket entry
 */

// Requirements
require_once(dirname(dirname(__FILE__)) . '/include/db.class.php');

// Connect to database
$s = new C2MySQL(HOST, USER, PWD, DB_NAME);

$string = file_get_contents(dirname(dirname(__FILE__)) . "/input/input.csv");

$rows = explode("\n", $string);

foreach ($rows as $row) {
	if ( "" == $row ) {
		continue;
	}

	$e = explode("\t", $row);

	$ticket = $e[0];
	$name = implode("_",explode("'",$e[1]));
	if ( "" == $name ) {
		$name = 'NULL';
	} else {
		$name = "'" . $name . "'";
	}
	$residency = 0;
	if ( "R" == $ticket[0] ) {
		$residency = 1;
	}

	$sql = "INSERT INTO `tickets` (`id`,`name`,`residency`) VALUES ('" . $ticket . "', " . $name . ", " . $residency . ")";
	$q = $s->query($sql);
}

die('{"err":0}');

?>