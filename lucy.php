<?php

require 'core/error/class-error-handler.php';
$errorHandler = new ErrorHandler(true, false);
//$errorHandler->triggerError('Blah blah!', 'FATAL');
//trigger_error('Fatal error', E_USER_ERROR);
//trigger_error('Fatal error', E_USER_ERROR);
echo 'Hello!' . (7/0);
echo 'Hello!' . (7/0);
echo 'Hello!' . (7/0);
echo 'Hello!' . (7/0);
echo 'Hello!' . (7/0);

throw new Exception("Uncaught Exception");