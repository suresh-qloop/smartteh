<?php

App::uses('Helper', 'View');

/**
 * Helper functions
 */
class AppHelper extends Helper
{

	public $helpers = ['Html'];

	/**
	 * Extend built-in url() by adding "lang" param and trailing slash.
	 *
	 * @param string|array $url
	 * @param bool $full
	 *
	 * @return string
	 */
	public function url($url = null, $full = false) {
		if (is_array($url) && !isset($url['lang']) && isset($this->request)) {
			if ($this->request->lang) {
				$url['lang'] = $this->request->lang;
			} elseif (!empty($this->request->named['lang'])) {
				$url['lang'] = $this->request->named['lang'];
			} else {
				$url['lang'] = Configure::read('Languages.default');
			}
		}

		return parent::url($url, $full);
	}

	/**
	 * @param string $text
	 *
	 * @return string
	 */
	public function preprocessText($text) {
		$text = $this->addRelNoFollowToExternalLinks($text);

		return $this->safeEmails($text);
	}

	/**
	 * @param string|array $url
	 *
	 * @return bool
	 */
	public function isUrlExternal($url) {
		if (!is_string($url) || !str_starts_with($url, 'http')) {
			return false;
		}

		$host = parse_url($url, PHP_URL_HOST);

		return $host && !str_contains($host, 'smartteh');
	}

	/**
	 * @param string $text
	 *
	 * @return string
	 */
	public function addRelNoFollowToExternalLinks($text) {
		$pattern = '/<a.*(href=(["\'])(http.*)\2).*>/Usi';

		preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

		foreach ($matches as $match) {
			$url = $match[3];

			if ($this->isUrlExternal($url)) {
				$quote = $match[2];

				$href_with_rel = $match[1].' ref='.$quote.'nofollow'.$quote;

				$link = str_replace($match[1], $href_with_rel, $match[0]);

				$text = str_replace($match[0], $link, $text);
			}
		}

		return $text;
	}

	/**
	 * Replace all emails (strings and links) to bot-protected version
	 *
	 * Email "@" signs will be replaced with "[at]" and whole email will be wrapped
	 * in span with class "email", which should be replaced to human readable form by
	 * javascript on page load
	 *
	 * @param string $text Input text
	 *
	 * @return string
	 */
	public function safeEmails($text) {
		// convert html email links (<a href="mailto:test@example.com">TITLE</a>). title will be dropped
		$pattern = '/<a\s+href=["\']mailto:.*\/a>/Ui';

		$text = preg_replace_callback($pattern, function ($matches) {
			$pattern = '/([\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+).*>(.*)<.*/i';
			preg_match($pattern, $matches[0], $matches2);
			if (count($matches2) == 3) {
				$email = explode('@', $matches2[1]);

				return '<span class="email">'.$email[0].'[at]'.$email[1].'</span>';
			} else {
				return $matches[0];
			}
		}, $text);

		// convert simple string emails (test@example.com)
		$email_pattern = '/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i';

		$text = preg_replace_callback($email_pattern, function ($matches) {
			$email = explode('@', $matches[0]);

			return '<span class="email">'.$email[0].'[at]'.$email[1].'</span>';
		}, $text);

		return $text;
	}

	/**
	 * Return human readable datetime string
	 *
	 * @param string $date Date
	 * @param boolean $time If true, time (H:i) will be added
	 *
	 * @return string
	 */
	public function readableDate($date = null, $time = false) {
		if (empty($date)) {
			return '';
		}

		if (!$date) {
			$ts = time();
		} elseif (is_string($date)) {
			$ts = strtotime($date);
		} else {
			$ts = $date;
		}

		$date_str = date('Y-m-d', $ts);

		if ($date_str == date('Y-m-d', strtotime('-1 day'))) {
			$dt = __d('admin', 'Yesterday', true);
		} else {
			if ($date_str == date('Y-m-d')) {
				$dt = __d('admin', 'Today', true);
			} else {
				if ($date_str == date('Y-m-d', strtotime('+1 day'))) {
					$dt = __d('admin', 'Tomorrow', true);
				} else {
					$dt = date('d.m.Y', $ts);
				}
			}
		}

		if ($time) {
			$dt = $dt.' '.date('H:i', $ts);
		}

		return $dt;
	}

	/**
	 * Create an array containing a range of elements
	 *
	 * Same as range(), but uses values as keys instead of indexes
	 *
	 * @param mixed $low Low value
	 * @param mixed $high High value
	 * @param int step Increase step
	 */
	public function rangeKeys($low, $high, $step = 1) {
		$range = [];

		foreach (range($low, $high, $step) as $v) {
			$range[$v.''] = $v;
		}

		return $range;
	}

	/**
	 *
	 *
	 * @param mixed $timestamp
	 *
	 * @return string
	 */
	public function timeAgo($timestamp) {
		if (!is_numeric($timestamp)) {
			$timestamp = strtotime($timestamp);
		}

		$difference = time() - $timestamp;

		if ($difference < 60) {
			return $difference.' seconds ago';
		} else {
			$difference = round($difference / 60);

			if ($difference < 60) {
				return $difference.' minutes ago';
			} else {
				$difference = round($difference / 60);

				if ($difference < 24) {
					return $difference.' hours ago';
				} else {
					$difference = round($difference / 24);

					if ($difference < 7) {
						return $difference.' days ago';
					} else {
						$difference = round($difference / 7);

						return $difference.' weeks ago';
					}
				}
			}
		}
	}

	/**
	 * Find any include(element) and include actual element
	 *
	 * @param object $view Current view
	 * @param string $code Input code
	 *
	 * @return string
	 */
	public function includeIncludes($view, $code, $cache = false) {
		if (Configure::read('debug') > 0) {
			$cache = false;
		}

		preg_match_all('/include\((.*)\)/i', $code, $matches, PREG_SET_ORDER);

		foreach ($matches as $v) {
			$parts = explode(' ', $v[1]);

			if (count($parts) > 1) {
				$element = $parts[0];
				$vars = ['args' => array_slice($parts, 1)];
			} else {
				$element = $v[1];
				$vars = [];
			}

			if ($cache) {
				$code = str_replace($v[0], $view->element($element, $vars, ['cache' => $cache]), $code);
			} else {
				$code = str_replace($v[0], $view->element($element, $vars), $code);
			}
		}

		return $code;
	}

	/**
	 * Converts @user to clickable twitter links
	 *
	 * @param string $s Input text
	 *
	 * @return string
	 */
	public function twitterLinks($s) {
		if (preg_match_all('/(^|[^@\w])@(\w{1,15})\b/', $s, $matches)) {
			foreach ($matches[2] as $user) {
				$s = str_replace('@'.$user, '<a href="https://twitter.com/'.$user.'">@'.$user.'</a>', $s);
			}
		}

		return $s;
	}

	/**
	 * Construct link with variable url (can be internal or external)
	 *
	 * Options:
	 * - url : if empty, make internal link
	 * - strid : required if link is internal
	 * - controller : optional. default: current
	 * - action : optional. default: view
	 * - new_window : optional
	 *
	 * @param string $title Link title
	 * @param array $options Link options
	 * @param array $params Additional link params/attributes
	 *
	 * @return string
	 */
	public function viewLink($title, $options, $params = []) {
		if (!empty($options['url'])) {
			$url = $options['url'];
		} else {
			if (empty($options['controller'])) {
				$options['controller'] = $this->request->controller;
			}

			if (empty($options['action'])) {
				$options['action'] = 'view';
			}

			$url = ['controller' => $options['controller'], 'action' => $options['action'], $options['strid']];
		}

		if (!empty($options['new_window'])) {
			$params['target'] = '_blank';
		}

		return $this->Html->link($title, $url, $params);
	}

	/**
	 * Creates a formatted IMG element.
	 *
	 * This is the same as default image() function, but $path is relative to /uploads/images/
	 * and not /images
	 *
	 * @param string $path Path to image relative to /uploads/images/
	 * @param array $options
	 *
	 * @return string
	 */
	public function uploadedImage($path, $options = []) {
		$path = '../uploads/images/'.ltrim($path, '/');

		return $this->Html->image($path, $options);
	}

	/**
	 * @return bool
	 */
	public function isTestSite(): bool {
		return explode('.', $_SERVER['HTTP_HOST'] ?? '')[0] === 'test';
	}
}
