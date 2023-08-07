<?php
/**
 * AppShell file
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     CakePHP(tm) v 2.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Shell', 'Console');
App::uses('L10n', 'I18n');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package app.Console.Command
 */
class AppShell extends Shell
{

	/**
	 * Start timer.
	 * Use this at the start of function
	 */
	public function startTimer() {
		$this->t = microtime(true);
	}

	/**
	 * Stop timer and output elapsed time.
	 * Use this at the end of function
	 */
	public function stopTimer() {
		$secods = microtime(true) - $this->t;
		$this->t = null;
		$min = floor($secods / 60);
		$sec = round($secods - ($min * 60));
		$time = $min.'m '.$sec.'s';
		$this->out('Completed in '.$time);
	}

	/**
	 * Output message passed through sprintf f-ion
	 *
	 * F-ion takes in arbitrary number of arguments.
	 */
	public function formattedOut() {
		if (func_num_args() === 0) {
			return $this->out();
		}

		$this->out(call_user_func_array('sprintf', func_get_args()));
	}

	/**
	 * Output error passed through sprintf f-ion
	 *
	 * F-ion takes in arbitrary number of arguments.
	 */
	public function formattedErr() {
		if (func_num_args() === 0) {
			return $this->err();
		}

		$this->err(call_user_func_array('sprintf', func_get_args()));
	}

	/**
	 * Darbojas kā out, tikai teksts tiek izdrukāts iepriekšējās rindiņas vietā
	 *
	 * Tas tiek panākts, rindiņas drukājot bez newline beigās un pirms teksta pievienojot backspace
	 * simbolus, kas izdzēš iepriekšējo tekstu. Te gan ir catch - teksts reāli netiek izdzēsts, bet
	 * tiek tikai pārvietots kursors, tāpēc pārējo daļus aizpildam ar atstarpēm.. Teksta garumam līdz
	 * ar to ir limits 50 (paņemts no gaisa) simboli.
	 */
	public function sameOut($message = null, $newlines = 0) {
		$this->out(str_repeat(chr(8), 50).$message.str_repeat(' ', 50 - mb_strlen($message, 'utf-8')), $newlines);
	}

	/**
	 * Return rendered element
	 *
	 * @param string $file File name (without extension, must be in Elements directory)
	 * @param mixed $data Optional data to pass to view
	 *
	 * @return string Rendered html
	 */
	public function getRenderedElement($file, $data = []) {
		$view = new View();
		foreach ($data as $k => $v) {
			$view->set($k, $v);
		}
		$view->viewPath = 'Elements';

		return $view->render($file, 'ajax');
	}

	/**
	 * Set language
	 * Set language before sending e-mail
	 *
	 * @param string $lang
	 */
	public function setLanguage($lang) {
		$this->L10n = new L10n();
		$this->L10n->get($lang);
		Configure::write('Config.language', $lang);
	}
}
