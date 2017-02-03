<?php
require_once 'shell-class.php';

$shell = new Shell();

$cmd = "salt 'opendev' cmd.run '/etc/init.d/httpd status' --out=json";
$result = $shell->do_shell_cmd( $cmd );
var_dump( $result );

?>