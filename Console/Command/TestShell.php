<?php

/**
 * Various test functions
 */
class TestShell extends AppShell
{
	public $tasks = ['Email'];

	/**
	 * Import all models
	 */
	public function startup() {
		parent::startup();

		foreach (App::objects('model') as $model) {
			$this->loadModel($model);
		}
	}

	/**
	 * Landing function
	 */
	public function main() {
		$this->out('Where do you want to go today?');
	}

	/**
	 * Dummy test
	 */
	public function test() {
		$this->startTimer();

		$this->out('Let\'s sleep for 1 sec');
		sleep(1);

		$this->stopTimer();
	}

	/**
	 * Send test e-mail
	 *
	 * @param string $to
	 */
	public function email($to) {
		$r = $this->Email->send([
			'to' => $to,
			'subject' => 'Test email',
			'template' => 'test',
			'transactional' => true
		]);

		if ($r) {
			$this->formattedOut('E-mail sent to %s', $to);
		} else {
			$this->formattedErr('Failed to send e-mail to %s', $to);
		}
	}
}
