<?php

App::uses('HtmlHelper', 'View/Helper');

class CustomHtmlHelper extends HtmlHelper
{
	/**
	 * Creates an HTML link (extended).
	 *
	 * - add rel="nofollow" attribute for external links
	 *
	 * If the $url is empty, $title is used instead.
	 *
	 * See built-in link() for params and return info.
	 *
	 * @param string $title
	 * @param string|array
	 * @param array $options
	 * @param string|bool $confirmMessage
	 *
	 * @return string
	 */
	public function link($title, $url = null, $options = [], $confirmMessage = false) {
		$href = $url ?: $title;

		if ($this->isUrlExternal($href)) {
			$options['rel'] = 'nofollow';
		}

		return parent::link($title, $url, $options, $confirmMessage);
	}
}
