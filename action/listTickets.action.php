<?php
/**
 * Manages ticket entry
 */

// Requirements
require_once(dirname(dirname(__FILE__)) . '/include/db.class.php');

// Connect to database
$s = new C2MySQL(HOST, USER, PWD, DB_NAME);

$sql = "SELECT * FROM `tickets`";
$q = $s->query($sql);

$a = '[';
for ($i = 1; $i <= $q->size(); $i++) { 
	$r = $q->fetch();
	$a .= '{"id":"' . $r['id'] . '", "name":"' . $r['name'] . '", "residency":' . $r['residency'] . ', "when":"' . $r['when'] . '"}';
	if ( $i != $q->size() ) $a .= ',';
}
$a .= ']';

echo $a;
?>