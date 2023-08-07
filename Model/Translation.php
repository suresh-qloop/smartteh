<?php

/**
 * Localization
 *
 * This module doesn't have db table - all data is read from cake's locale directory
 */
class Translation extends AppModel
{
	public $name = 'Translation';

	public $useTable = false;

	public static function getAdminTabs(): array {
		return [[
			'title' => __d('admin', 'Translated'),
			'url' => ['controller' => 'translations', 'action' => 'view']
		], [
			'title' => __d('admin', 'Missing'),
			'url' => ['controller' => 'translations', 'action' => 'missing']
		]];
	}

	/**
	 * Get list of available locales
	 *
	 * @return array
	 */
	public function findLocales(): array {
		$locales = [];
		$files = scandir(APP.'Locale');

		if ($files) {
			foreach ($files as $file) {
				if (!str_starts_with($file, '.') && is_dir(APP.'Locale'.DS.$file)) {
					$locales[] = $file;
				}
			}
		}

		return $locales;
	}

	/**
	 * Return list for domain select
	 *
	 * @param string $locale
	 *
	 * @return array
	 */
	public function listDropdownDomains(string $locale): array {
		$domains = $this->findDomains($locale);

		$list = [];

		foreach ($domains as $k => $v) {
			$url = Router::url(['action' => 'set_domain', 'lang' => $this->lang, $k]);
			$list[$k] = ['name' => $v, 'value' => $k, 'data-redirect-url' => $url];
		}

		return $list;
	}

	/**
	 * Get list of available domains for specified locale
	 *
	 * @param string $locale
	 *
	 * @return array
	 */
	public function findDomains(string $locale): array {
		$domains = [];
		$files = glob(APP.'Locale'.DS.$locale.DS.'LC_MESSAGES'.DS.'*.po');

		if ($files) {
			foreach ($files as $file) {
				$domain = basename($file, '.po');

				switch ($domain) {
					case 'default':
						$title = __d('admin', 'Frontend');
						break;

					case 'admin':
						$title = __d('admin', 'Backend');
						break;

					default:
						$title = $domain;
				}

				$domains[$domain] = $title;
			}
		}

		// make sure that 'default' domain is always first
		foreach ($domains as $k => $v) {
			if ($k === 'default') {
				$tmp = $domains;
				unset($tmp['default']);
				$domains = am([$k => $v], $tmp);
			}
		}

		return $domains;
	}

	/**
	 * Save localization into file
	 *
	 * @param string $locale Locale name
	 * @param array $data Localization data
	 * @param boolean $overwrite Should data be overwritten or appended
	 * @param string $locale_file Locale file. Default is 'default.po'
	 *
	 * @return bool
	 */
	public function saveData(string $locale, array $data, bool $overwrite = true, string $locale_file = 'default.po'): bool {
		$file = APP.'Locale'.DS.$locale.DS.'LC_MESSAGES'.DS.$locale_file;

		if ($overwrite) {
			$mode = 'w';
		} else {
			$mode = 'a';
		}

		$h = fopen($file, $mode);

		if ($h) {
			foreach ($data as $v) {
				fwrite($h, "msgid \"".addslashes($v['msgid'])."\"\nmsgstr \"".addslashes($v['msgstr'])."\"\n\n");
			}

			fclose($h);

			// empty cache
			clearCache(null, 'persistent');

			return true;
		}

		return false;
	}

	/**
	 * Read data from specified locale's file
	 *
	 * @param string $locale Locale name
	 * @param string $domain Current domain
	 *
	 * @return array|false False if could not read file, array otherwise
	 */
	public function readLocaleFile(string $locale, string $domain = 'default') {
		$filename = APP.'Locale'.DS.$locale.DS.'LC_MESSAGES'.DS.$domain.'.po';

		if (!file_exists($filename)) {
			return false;
		}

		$data = [];

		$file_contents = file_get_contents($filename);

		preg_match_all('/msgid "(.*)"\nmsgstr "((?:\\\?+.)*)?"/U', $file_contents, $matches);

		foreach ($matches[1] as $k => $v) {
			$data[] = [
				'msgid' => stripslashes($v),
				'msgstr' => stripslashes($matches[2][$k])
			];
		}

		return $data;
	}

	/**
	 * List all files which should be searched for strings
	 *
	 * @return array
	 */
	public function listWorkingFiles(): array {
		$files = [
			APP.'Controller',
			APP.'Config/settings.php',
			APP.'Model',
			APP.'View'
		];

		$all_files = [];

		foreach ($files as $file) {
			if (is_dir($file)) {
				$this->findAllFiles($file, $all_files);
			} else {
				$chunks = explode('.', $file);
				if (in_array(end($chunks), ['php', 'ctp'])) {
					$all_files[] = $file;
				}
			}
		}

		return $all_files;
	}

	/**
	 * Return all msgids found in website
	 *
	 * @param string $domain Current domain
	 *
	 * @return array
	 */
	public function searchMsgids(string $domain): array {
		$all_files = $this->listWorkingFiles();

		$msgids = [];

		foreach ($all_files as $file) {
			$data = file_get_contents($file);
			$matches = $this->extractStrings($data, $domain);
			foreach ($matches as $v) {
				$v = stripslashes($v);
				if ($v !== '' && !in_array($v, $msgids, true)) {
					$msgids[] = $v;
				}
			}
		}

		return $msgids;
	}

	/**
	 * Recursively find all php and ctp files
	 *
	 * @param string $dir Parent directory path
	 * @param array $all_files Variable where found files are stored
	 *
	 * @return void
	 */
	public function findAllFiles(string $dir, array &$all_files): void {
		if (!is_dir($dir)) {
			return;
		}

		$files = scandir($dir);

		foreach ($files as $file) {
			if ($file === '.' || $file === '..') {
				continue;
			}

			if (is_dir($dir.DS.$file)) {
				$this->findAllFiles($dir.DS.$file, $all_files);
			} else {
				$tmp = explode('.', $file);
				if (in_array(end($tmp), ['php', 'ctp'])) {
					$all_files[] = $dir.DS.$file;
				}
			}
		}
	}

	/**
	 * Extract all localization strings from text
	 *
	 * @param string $text Text to extract strings from
	 * @param string|null $domain If specified, extract this domain (eg: __d(domain, Some text) ) instead of default (eg: __(Some text) )
	 *
	 * @return array
	 */
	public function extractStrings(string $text, string $domain = null): array {
		if ($domain && $domain !== 'default') {
			preg_match_all('/__d\([\'"]'.$domain.'[\'"], ?(["\'])((?:\\\?+.)*)?\1.*[,)]/Us', $text, $matches);
		} else {
			preg_match_all('/__\((["\'])((?:\\\?+.)*)?\1.*[,)]/Us', $text, $matches);

			preg_match_all('/__n\((["\'])(.*)\1\s*,.*\)/Us', $text, $matches1); // first param
			preg_match_all('/__n\(.*["\']\s*,\s*(["\'])(.*)\1\s*,.*\)/Us', $text, $matches2); // second param

			$matches[2] = array_merge($matches[2], $matches1[2]);
			$matches[2] = array_merge($matches[2], $matches2[2]);
		}

		return array_unique($matches[2]);
	}

	/**
	 * Get list of msgids with no translations or not in file
	 *
	 * @param string $locale Locale name
	 * @param string $domain Current domain
	 *
	 * @return array
	 */
	public function findMissing(string $locale, string $domain): array {
		$missing = [];

		$data1 = $this->readLocaleFile($locale, $domain);

		foreach ($data1 as $v) {
			if (trim($v['msgstr']) === '') {
				$missing[] = $v['msgid'];
			}
		}

		$data1 = Hash::extract($data1, '{n}.msgid');

		$data2 = $this->searchMsgids($domain);

		foreach ($data2 as $msgid) {
			if (!in_array($msgid, $data1, true) && !in_array($msgid, $missing, true)) {
				$missing[] = stripslashes($msgid);
			}
		}

		return $missing;
	}

	/**
	 * Get list of msgids which are in locale's file but not in code
	 *
	 * @param string $domain Current domain
	 * @param string $locale Locale name
	 *
	 * @return array
	 */
	public function findUnused(string $locale, string $domain): array {
		$data1 = Hash::extract($this->readLocaleFile($locale, $domain), '{n}.msgid');
		$data2 = $this->searchMsgids($domain);

		return array_diff($data1, $data2);
	}

	/**
	 * Remove all unused strings from locale's file
	 *
	 * @param string $domain Current domain
	 * @param string $locale Locale name
	 *
	 * @return bool
	 */
	public function removeUnused(string $locale, string $domain): bool {
		$unused = $this->findUnused($locale, $domain);

		if (empty($unused)) {
			return true;
		}

		$data = $this->readLocaleFile($locale, $domain);

		foreach ($unused as $msgid) {
			foreach ($data as $k => $v) {
				if ($v['msgid'] === $msgid) {
					unset($data[$k]);
				}
			}
		}

		return $this->saveData($locale, $data, true, $domain.'.po');
	}

	/**
	 * Merge 2 data arrays
	 *
	 * @param array $data
	 * @param array $updated
	 *
	 * @return array
	 */
	public function merge(array $data, array $updated): array {
		foreach ($updated as $v) {
			$found = false;
			foreach ($data as $k2 => $v2) {
				if ($v2['msgid'] === $v['msgid']) {
					$data[$k2]['msgstr'] = $v['msgstr'];
					$found = true;
					break;
				}
			}
			if (!$found) {
				$data[] = $v;
			}
		}

		return $data;
	}

	/**
	 * Beautfiy po file content
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public function beautify(string $content): string {
		$new_code = [];

		$lines = explode("\n", trim($content));

		foreach ($lines as $line) {
			$line = trim($line);

			if (str_starts_with($line, 'msgstr')) {
				$new_code[] = substr($line, 0, 6).' '.ltrim(substr($line, 6))."\n";
			} elseif (str_starts_with($line, 'msgid')) {
				$new_code[] = substr($line, 0, 5).' '.ltrim(substr($line, 5));
			}
		}

		return trim(implode("\n", $new_code));
	}
}
