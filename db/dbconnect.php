<?php
require_once "db_config.php";

$host='localhost';
$db = 'connect4';
$user=$DB_USER;
$pass=$DB_PASS;
global $mysqli;
$mysqli = new mysqli($host, $user, $pass, $db);

if(gethostname()=='users.iee.ihu.gr') {
	$mysqli = new mysqli($host, $user, $pass, $db,null,'/home/student/it/2015/it154603/mysql/run/mysql.sock');
} else {
        $mysqli = new mysqli($host, $user, $pass, $db);
}
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" .
    $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>
