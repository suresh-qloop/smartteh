<?php

App::uses('ErrorHandler', 'Error');
App::uses('ConsoleOutput', 'Console');
App::uses('CakeLog', 'Log');

class ConsoleExceptionHandler extends ConsoleErrorHandler
{
	/**
	 * Standard error stream.
	 *
	 * @var ConsoleOutput
	 */
	public static $stderr;

	/**
	 * Get the stderr object for the console error handling.
	 *
	 * @return ConsoleOutput
	 */
	public static function getStderr() {
		if (empty(static::$stderr)) {
			static::$stderr = new ConsoleOutput('php://stderr');
		}

		return static::$stderr;
	}

	/**
	 * Handle an exception in the console environment. Prints a message to stderr.
	 *
	 * @param Exception|ParserError $exception The exception to handle
	 *
	 * @return void
	 */
	public static function customHandleException($exception) {
		$stderr = static::getStderr();
		$stderr->write(__d('cake_console', "<error>Error:</error> %s\n%s",
			$exception->getMessage(),
			$exception->getTraceAsString()
		));

		$code = $exception->getCode();
		$code = ($code && is_int($code)) ? $code : 1;

		if (env('SENTRY_DSN')) {
			Sentry\init(['environment' => env('APP_ENV')]);
			Sentry\captureException($exception);
		}

		exit($code);
	}

	/**
	 * Handle errors in the console environment. Writes errors to stderr,
	 * and logs messages if Configure::read('debug') is 0.
	 *
	 * @param int $code Error code
	 * @param string $description Description of the error.
	 * @param string $file The file the error occurred in.
	 * @param int $line The line the error occurred on.
	 * @param array $context The backtrace of the error.
	 *
	 * @return void
	 */
	public function handleError($code, $description, $file = null, $line = null, $context = null) {
		if (error_reporting() === 0) {
			return;
		}
		$stderr = static::getStderr();
		[$name, $log] = ErrorHandler::mapErrorCode($code);
		$message = __d('cake_console', '%s in [%s, line %s]', $description, $file, $line);
		$stderr->write(__d('cake_console', "<error>%s Error:</error> %s\n", $name, $message));

		if (!Configure::read('debug')) {
			CakeLog::write($log, $message);
		}

		if ($log === LOG_ERR) {
			exit(1);
		}
	}
}
