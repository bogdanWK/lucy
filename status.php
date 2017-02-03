<?php
$mysqli = new mysqli("localhost", "root", "asdQWE123");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$mysql_status = $mysqli->stat();
$query = $mysqli->query( "SHOW GLOBAL STATUS LIKE 'Uptime';" );
$result = $query->fetch_assoc();
var_dump( $result['Value'] );
var_dump( $mysql_status );

$mysqli->close();
?>