<?php
/**
 * Lucy Error Handler
 *
 * Author:  Bogdan Preda -- bogdan@opendevelopers.ro
 * Date:    28.07.0217
 *
 * @since   1.0.0
 * @package luvy.io
 */

/**
 * Class ErrorHandler
 *
 * @since   1.0.0
 * @package lucy\error
 */
class ErrorHandler
{
	/**
	 * Debug mode.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     bool $debug True to show full PHP error, false to show prettier error text.
	 */
	private $debug = false;

	private $errors = array();

	/**
	 * ErrorHandler constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @param   bool $debug True to show full PHP error, false to show prettier error text. (Default false)
	 * @param   bool $mute  Set to true to hide all errors, false for default error class action. (Default false)
	 */
	public function __construct( $debug = false )
	{
		set_error_handler( array( $this, "handleError" ) );
		set_exception_handler( array( $this, "handleException" ) );
		register_shutdown_function( array( $this, "displayError" ) );
	}

	public function displayError() {
        $time_exec = number_format( microtime( true ) - LUCY_INIT, 4 );
        $total_exec_class = 'pass';
        if( $time_exec > 0.001 && $time_exec < 0.002 ) {
            $total_exec_class = 'warning';
        } else if ( $time_exec > 0.002 ) {
            $total_exec_class = 'danger';
        }
	    ob_start();
	    include ( __DIR__ . '/../partials/error-dash-tpl.php');
	    $output = ob_get_clean();
        echo $output;
		//var_dump( $this->errors );
	}

	public function handleException( Exception $exception ) {
		$displayErrors = ini_get("display_errors");
		$displayErrors = strtolower($displayErrors);
		if (error_reporting() === 0 || $displayErrors === "on") {
			return false;
		}
		$code = $exception->getCode();
		list( $error, $log)  = $this->mapErrorCode( $code );
		$data = array(
			'level' => $log,
			'code' => $code,
			'error' => $error,
			'description' => $exception->getMessage(),
			'file' => $exception->getFile(),
			'line' => $exception->getLine(),
			'stack' => $exception->getTrace(),
			'stackString' => $exception->getTraceAsString(),
			'path' => $exception->getFile(),
			'message' => $error . ' (' . $code . '): ' . $exception->getMessage() . ' in [' . $exception->getFile() . ', line ' . $exception->getLine() . ']'
		);
		$this->errors[$error][] = $data;
	}

	public function handleError( $code, $description, $file = null, $line = null ) {
		if( ! is_numeric( $code ) ) {
			$code = 255;
			if( ! isset( $description ) && $description == '' ) {
                $description = 'FATAL';
            }
		}
		$this->handleException( new ErrorException( $description, $code, 0, $file, $line ) );
	}

	private function mapErrorCode($code) {
		$error = $log = null;
		switch ($code) {
			case E_PARSE:
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				$error = 'Fatal';
				$log = LOG_ERR;
				break;
			case E_WARNING:
			case E_USER_WARNING:
			case E_COMPILE_WARNING:
			case E_RECOVERABLE_ERROR:
				$error = 'Warning';
				$log = LOG_WARNING;
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$error = 'Notice';
				$log = LOG_NOTICE;
				break;
			case E_STRICT:
				$error = 'Strict';
				$log = LOG_NOTICE;
				break;
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
				$error = 'Deprecated';
				$log = LOG_NOTICE;
				break;
			default :
                $error = 'Fatal';
                $log = LOG_ERR;
				break;
		}
		return array($error, $log);
	}
}
