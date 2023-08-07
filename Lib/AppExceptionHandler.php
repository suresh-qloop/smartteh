<?php

class AppExceptionHandler extends ErrorHandler
{
	protected static $ignore = [
		NotFoundException::class,
		MissingControllerException::class,
		MissingPluginException::class
	];

	/**
	 * Log request uri and execute default error handling
	 *
	 * @param int $code Code of error
	 * @param string $description Error description
	 * @param string $file File on which error occurred
	 * @param int $line Line that triggered the error
	 * @param array $context Context
	 *
	 * @return bool
	 */
	public static function handleError($code, $description, $file = null, $line = null, $context = null) {
		[$error, $log] = self::mapErrorCode($code);

		CakeLog::write($log, 'Request URI: '.env('REQUEST_URI'));

		return parent::handleError($code, $description, $file, $line, $context);
	}

	/**
	 * @param Exception|ParseError $exception
	 *
	 * @return void
	 */
	public static function handleException($exception): void {
		$ignore = self::shouldIgnore($exception);

		if (!$ignore && env('SENTRY_DSN')) {
			Sentry\init(['environment' => env('APP_ENV')]);
			Sentry\captureException($exception);
		}

		if ($ignore) {
			Configure::write('Exception.log', false);
		}

		parent::handleException($exception);
	}

	public static function shouldIgnore($exception): bool {
		foreach (self::$ignore as $e) {
			if ($exception instanceof $e) {
				return true;
			}
		}

		return false;
	}
}
