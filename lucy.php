<?php
spl_autoload_register( function( $class_name ) {
    $class_file_name = strtolower( str_replace( '_', '-', $class_name ) ) . '-class';
    include 'lib/' . $class_file_name . '.php';
} );

$salt = new Salt();

$res = $salt->exec_salt_cmd( '/etc/init.d/httpd status' );
print_r( $res );

$res = $salt->exec_salt_cmd( '/etc/init.d/mysqld status' );
print_r( $res );

?>