<?php
/**
 * Manages ticket entry
 */

// Requirements
require_once(dirname(dirname(__FILE__)) . '/include/db.class.php');

// Connect to database
$s = new C2MySQL(HOST, USER, PWD, DB_NAME);

$sql = "SELECT id FROM `tickets` WHERE `when` IS NOT NULL";
$q = $s->query($sql);

die('{"err":0, "number":' . $q->size() . '}');

?>