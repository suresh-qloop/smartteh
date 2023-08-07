<?php

App::uses('ConnectionManager', 'Model');

/**
 * Various database functions
 */
class DbShell extends AppShell
{
	/**
	 * Landing function
	 */
	public function main() {
		$this->out('Where do you want to go today?');
	}

	/**
	 * Dump current database schema
	 */
	public function dump_schema() {

		$this->startTimer();

		if (!empty($this->args[0])) {
			$output_file = $this->args[0];
		} else {
			$output_file = APP.'Config'.DS.'Schema'.DS.'project.sql';
		}

		if (!is_writable($output_file)) {
			$this->formattedErr('%s is not writeable', $output_file);

			return;
		}

		$mysqldump = env('MYSQLDUMP_PATH');

		if (!$mysqldump) {
			$this->formattedErr('Path to mysqldump is not defined');

			return;
		}

		$dbconf = ConnectionManager::getDataSource('default')->config;

		$cmd = $mysqldump.' --no-data -u '.$dbconf['login'].' -p'.$dbconf['password'].' '.$dbconf['database'];

		$data = shell_exec(escapeshellcmd($cmd));

		if (!$data) {
			$this->formattedErr('mysqldump returned empty result');

			return;
		}

		// remove mysql comments
		$data = preg_replace('/\/\*\!.*\*\/\;\n/', '', $data);

		// remove auto increment
		$data = preg_replace('/ AUTO_INCREMENT=[0-9]*/', '', $data);

		if (!file_put_contents($output_file, $data)) {
			$this->formattedErr('Could not save %s', $output_file);

			return;
		}

		$this->stopTimer();
	}
}
