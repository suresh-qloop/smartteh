<?php

App::uses('ConnectionManager', 'Model');

/**
 * Various development functions
 */
class DevelopmentShell extends AppShell
{
	/**
	 * Landing function
	 */
	public function main() {
		$this->out('Where do you want to go today?');
	}
}
