<?php

App::uses('AppController', 'Controller');
App::uses('Translation', 'Model');

/**
 * Localization
 */
class TranslationsController extends AppController
{
	public $name = 'Translations';

	public $uses = ['Translation'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$this->admin_missing();
		$this->request->action = 'admin_missing';
		$this->render('admin_missing');
	}

	/**
	 * @return void
	 */
	public function admin_view(): void {
		$locale = $this->getCurrentLocale();

		$locales = $this->Translation->findLocales();

		if (!in_array($locale, $locales, true)) {
			$this->Flash->error(__d('admin', 'Specified locale was not found'));
			$this->redirect($this->referer());
		}

		$domain = $this->getCurrentDomain($locale);

		$data = $this->Translation->readLocaleFile($locale, $domain);

		$writable = is_writable(APP.'Locale'.DS.$locale.DS.'LC_MESSAGES'.DS.$domain.'.po');

		if (!$writable) {
			$this->Flash->error(__d('admin', 'Locale file is not writable'));
		}

		$info = $this->L10n->catalog($this->lang);

		$this->request->data['domain'] = $domain;
		$list_domains = $this->Translation->listDropdownDomains($locale);

		$this->set(compact('data', 'info', 'locale', 'locales', 'writable', 'list_domains'));
	}

	/**
	 * @return void
	 */
	public function admin_update(): void {
		$locale = $this->getCurrentLocale();

		if ($this->request->is(['post', 'put'])) {

			$locales = $this->Translation->findLocales();

			if (empty($locale) || !in_array($locale, $locales, true)) {
				$this->Flash->error(__d('admin', 'Specified locale was not found'));
				$this->redirect($this->referer());
			}

			$domain = $this->getCurrentDomain($locale);

			if ($this->Translation->saveData($locale, $this->request->data['Translation'], true, $domain.'.po')) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$this->redirect(['action' => 'view', $locale]);
		}

		$this->redirect($this->referer());
	}

	/**
	 * @return void
	 */
	public function admin_missing(): void {
		$locale = $this->getCurrentLocale();

		if ($this->request->is('post')) {

			$locales = $this->Translation->findLocales();

			if (empty($locale) || !in_array($locale, $locales, true)) {
				$this->Flash->error(__d('admin', 'Specified locale was not found'));
				$this->redirect($this->referer());
			}

			$domain = $this->getCurrentDomain($locale);

			$data = $this->Translation->readLocaleFile($locale, $domain);

			$data = $this->Translation->merge($data, $this->request->data['Translation']);

			if ($this->Translation->saveData($locale, $data, true, $domain.'.po')) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$this->redirect($this->referer());
		} else {
			$locales = $this->Translation->findLocales();

			if (!in_array($locale, $locales, true)) {
				$this->Flash->error(__d('admin', 'Specified locale was not found'));
				$this->redirect($this->referer());
			}

			$domain = $this->getCurrentDomain($locale);

			$data = $this->Translation->findMissing($locale, $domain);

			sort($data);

			$writable = is_writable(APP.'Locale'.DS.$locale.DS.'LC_MESSAGES'.DS.$domain.'.po');

			if (!$writable) {
				$this->Flash->error(__d('admin', 'Locale file is not writable'));
			}

			$info = $this->L10n->catalog($this->lang);

			$this->set(compact('data', 'locale', 'locales', 'writable', 'info'));
		}

		$this->request->data['domain'] = $domain;
		$this->set('list_domains', $this->Translation->listDropdownDomains($locale));
	}

	/**
	 * @param string $domain
	 */
	public function admin_set_domain(string $domain): void {
		$this->Session->write('CMS.domain', $domain);
		$this->redirect($this->referer());
	}

	/**
	 * Get current domain
	 *
	 * @param string $locale
	 *
	 * @return string
	 */
	public function getCurrentDomain(string $locale): string {
		$domains = $this->Translation->findDomains($locale);
		$domain = $this->Session->read('CMS.domain');

		if (!$domain || !isset($domains[$domain])) {
			$domain = current(array_keys($domains));
		}

		return $domain;
	}

	/**
	 * @return void
	 */
	public function admin_cleanup(): void {
		$locales = $this->Translation->findLocales();

		$cleaned = [];

		foreach ($locales as $locale) {
			$domain = $this->getCurrentDomain($locale);
			if ($this->Translation->removeUnused($locale, $domain)) {
				$cleaned[] = $locale;
			}
		}

		if ($cleaned) {
			$this->Flash->success(__d('admin', 'Cleaned locales: %s', implode(', ', $cleaned)));
		} else {
			$this->Flash->error(__d('admin', 'No locales were cleaned'));
		}

		$this->redirect(['action' => 'missing']);
	}

	/**
	 * @return void
	 */
	public function admin_beautify(): void {
		if ($this->request->is('post')) {
			$this->request->data['Translation']['code'] = $this->Translation->beautify(
				$this->request->data('Translation.code')
			);
		}
	}

	/**
	 * @return string Current locale (3 character string)
	 */
	private function getCurrentLocale(): string {
		$locale = $this->L10n->catalog($this->lang);
		if (!empty($locale)) {
			return $locale['locale'];
		}

		return '';
	}
}
