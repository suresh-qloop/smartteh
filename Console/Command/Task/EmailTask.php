<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Email sending task. Can be used to simplify sending emails.
 */
class EmailTask extends Shell
{
	/**
	 * Generic email sending function
	 *
	 * @param array $settings E-mail settings. Required params: to, template
	 * @param mixed $view_vars Variables to pass to view
	 *
	 * @return bool
	 */
	public function send(array $settings = [], array $view_vars = null): bool {
		$email = new CakeEmail('default');

		$this->log('Skipping (not in whitelist)', 'emails');

		$settings = am([
			'layout' => 'default',
			'subject' => '',
			'text' => null
		], $settings);

		if (empty($settings['to']) || (empty($settings['template'])) && empty($settings['text'])) {
			return false;
		}

		if (!empty($settings['template'])) {
			$email->template($settings['template'], $settings['layout']);
		} else {
			if (!empty($settings['text'])) {
				$email->template('raw_text', $settings['layout']);

				if ($view_vars === null) {
					$view_vars = [];
				}

				$view_vars['content_for_view'] = $settings['text'];
			}
		}

		$email->subject($settings['subject']);

		$email->to(Utils::extractEmails($settings['to']));

		if (!empty($settings['from'])) {
			$email->from(Utils::extractEmails($settings['from']));
		}

		if (!empty($settings['cc'])) {
			$email->cc(Utils::extractEmails($settings['cc']));
		}

		if (!empty($settings['bcc'])) {
			$email->bcc(Utils::extractEmails($settings['bcc']));
		}

		if (!empty($settings['replyTo'])) {
			$email->replyTo($settings['replyTo']);
		}

		if (!empty($settings['transactional'])) {
			$email->addHeaders([
				'X-MSYS-API' => json_encode([
					'options' => [
						'transactional' => true
					]
				])
			]);
		}

		$email->viewVars($view_vars);

		$email->helpers(['Html', 'EmailProcessing', 'AssetCompress.AssetCompress']);

		if (!empty($settings['attachments'])) {
			$email->attachments($settings['attachments']);
		}

		try {
			return (bool)$email->send();
		} catch (Exception $e) {
			$this->log('Email to "'.$settings['to'].'" not sent: '.$e->getMessage(), 'emails');

			return false;
		}
	}

	/**
	 * Remove all e-mails not in whitelist from to, cc and bcc fields
	 *
	 * @param array $whitelist
	 * @param array $email_settings
	 *
	 * @return array Return modified (if needed) email settings
	 */
	function whitelistEmails(array $whitelist, array $email_settings = []): array {
		$keys = ['to', 'cc', 'bcc'];

		$skipped = [];

		foreach ($keys as $key) {
			if (empty($email_settings[$key])) {
				continue;
			}

			$emails = $email_settings[$key];

			if (is_string($emails)) {
				$found = false;
				foreach ($whitelist as $email_pattern) {
					if (preg_match('/'.$email_pattern.'/Ui', $emails)) {
						$found = true;
					}
				}
				if (!$found) {
					$email_settings[$key] = '';
					$skipped[] = $emails;
				}
			} elseif (is_array($emails)) {
				foreach ($emails as $k => $v) {
					$found = false;
					foreach ($whitelist as $email_pattern) {
						if (preg_match('/'.$email_pattern.'/Ui', $v)) {
							$found = true;
							break;
						}
					}
					if (!$found) {
						unset($emails[$k]);
						$skipped[] = $v;
					}
				}
				$email_settings[$key] = $emails;
			}
		}

		if ($skipped) {
			$this->log('Skipping (not in whitelist): '.implode(', ', $skipped), 'emails');
		}

		return $email_settings;
	}
}
