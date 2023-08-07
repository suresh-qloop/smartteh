<?php

/**
 * Various functions that should be executed periodically
 */
class CronShell extends AppShell
{
	/**
	 * Landing f-ion if no params are specified.
	 * Does nothing, but show message
	 */
	public function main(): void {
		$this->out('Where do you want to go today?');
	}

	/**
	 * Executed hourly
	 */
	public function hourly(): void {
	}

	/**
	 * Executed daily
	 */
	public function daily(): void {
		$this->cleanupMetatags();
	}

	/**
	 * Executed weekly
	 */
	public function weekly(): void {
	}

	/**
	 * Executed monthly
	 */
	public function monthly(): void {
	}

	public function cleanupMetatags(): void {
		$model = ClassRegistry::init('Product');
		$model->query('DELETE FROM `metatags` WHERE `controller` = "portfolio" AND `pid` NOT IN (SELECT `id` FROM `portfolio`)');
		$model->query('DELETE FROM `metatags` WHERE `controller` = "articles" AND `pid` NOT IN (SELECT `id` FROM `articles`)');
		$model->query('DELETE FROM `metatags` WHERE `controller` = "industries" AND `pid` NOT IN (SELECT `id` FROM `industries`)');
		$model->query('DELETE FROM `metatags` WHERE `controller` = "products" AND `pid` NOT IN (SELECT `id` FROM `products`)');
		$model->query('DELETE FROM `metatags` WHERE `controller` = "sections" AND `pid` NOT IN (SELECT `id` FROM `sections`)');
		$model->query('DELETE FROM `metatags` WHERE `controller` = "services" AND `pid` NOT IN (SELECT `id` FROM `services`)');
		$model->query('DELETE FROM `metatags` WHERE `controller` = "categories" AND `pid` NOT IN (SELECT `id` FROM `categories`)');
	}
}
