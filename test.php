<?php
require_once 'shell-class.php';

$shell = new Shell();

$cmd = 'curl -o bootstrap-salt.sh -L https://bootstrap.saltstack.com';
$result = $shell->do_shell_cmd( $cmd );
var_dump( $result );

$cmd = 'sh bootstrap-salt.sh -M -P -i skywalker git develop';
$result = $shell->do_shell_cmd( $cmd );
var_dump( $result );

?>