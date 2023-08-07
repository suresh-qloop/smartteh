<?php

class CacheShell extends AppShell
{
	public function main() {
		$this->out('Where do you want to go today?');
	}

	/**
	 * Delete all files in:
	 * - /tmp/cache/persistent
	 * - /tmp/cache/models
	 * - /tmp/cache/views
	 */
	public function clear() {
		$this->startTimer();

		clearCache(null, 'persistent', '');
		clearCache(null, 'models', '');
		clearCache(null, 'views', '.php');

		$files = glob(CACHE.'cake_*');
		if ($files) {
			Utils::deleteNode($files);
		}

		$this->stopTimer();
	}
}
