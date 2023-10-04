<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Callbacks extends AppModel
{
	public $name = 'Callbacks';

	public $belongsTo = [
		'Product'
	];

	// do not remove or set to null
	public $validate = [];

	/**
	 * Set validation rules. Why here? So we can apply localization. If you want to skip validation,
	 * unset $this->validate variable before validation/save
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	public function beforeValidate($options = []): bool {
		if (!isset($this->validate)) {
			return true;
		}

		$this->validate = [
			'name' => [
				'rule' => ['minLength', 1],
				'message' => __('Lūdzu, ievadiet vārdu')
			],
			'phone' => [
				'rule' => ['minLength', 8],
				'message' => __('Lūdzu, ievadiet korektu telefonu')
			],
			'question' => [
				'rule1' => [
					'rule' => ['minLength', 1],
					'message' => __('Lūdzu, ievadiet jautājuma tekstu')
				],
				'rule2' => [
					'rule' => ['validateNoLinks'],
					'allowEmpty' => false,
					'message' => __('Linki nav atļauti')
				]
			],
			'comment' => [
				// antispam measure - field must exist and must be empty
				'rule' => ['lengthBetween', 0, 0],
				'message' => __('Spams!'),
				'required' => true
			]
		];

		return parent::beforeValidate($options);
	}

	/**
	 * Get all items for admin panel
	 *
	 * Results will be paginated
	 *
	 * @param object $Controller
	 * @param int $limit
	 * @param mixed $search Search fields/values
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20, $search = null) {
		$conditions = $this->searchConditions($search);

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['Callbacks.created' => 'desc'],
			'contain' => ['Product'],
			'limit' => $limit
		];

		return $Controller->paginate();
	}

	/**
	 * Check if validation field contains html links and return false if so
	 *
	 * @param mixed $data
	 *
	 * @return bool
	 */
	public function validateNoLinks($data): bool {
		return !(str_contains(current($data), '</a>'));
	}

	/**
	 * @param int $id
	 *
	 * @throws GuzzleException
	 * @throws \Exception
	 */
	public function sendToAmoCrm(int $id): void {
		if (!env('AMOCRM_HOST') || !env('AMOCRM_LOGIN') || !env('AMOCRM_API_KEY')) {
			if (env('APP_ENV') !== 'production') {
				return;
			}

			throw new Exception('Some of the AMOCRM variables are not defined');
		}

		$data = $this->getOrFail($id);

		$client = new Client(['verify' => !env('APP_DEBUG')]);

		$payload = $this->generateAmoCrmPayload($data['Callbacks']);

		$url = rtrim(env('AMOCRM_HOST'), '/').'/api/v2/incoming_leads/form';
		$url .= '?login='.env('AMOCRM_LOGIN').'&api_key='.env('AMOCRM_API_KEY');

		$res = $client->request('POST', $url, [
			'form_params' => $payload,
			'headers' => [
				'User-Agent' => 'amoCRM-API-client/1.0',
				'Accept' => 'application/json',
			]
		]);

		$contents = json_decode($res->getBody()->getContents(), true);

		if ($contents['status'] !== 'success') {
			throw new Exception(json_encode($contents));
		}
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function generateAmoCrmPayload(array $data): array {
		$form_id = '405307';
		$email_field_id = '1322565';
		$text_field_id = '1322567';

		return [
			'add' =>
				[
					0 =>
						[
							'source_name' => 'SmartTEH website',
							'source_uid' => md5(time()),
							'created_at' => strtotime($data['created']),
							'incoming_entities' =>
								[
									'leads' =>
										[
											0 =>
												[
													'name' => $data['name'],
													'custom_fields' =>
														[
															0 =>
																[
																	'id' => $email_field_id,
																	'values' =>
																		[
																			0 =>
																				[
																					'value' => $data['email'],
																				],
																		],
																],
															1 =>
																[
																	'id' => $text_field_id,
																	'values' =>
																		[
																			0 =>
																				[
																					'value' => $data['text'],
																				],
																		],
																],
														],
												],
										],
								],
							'incoming_lead_info' =>
								[
									'form_id' => $form_id,
									'form_page' => 'smartteh.eu',
									'ip' => $_SERVER['REMOTE_ADDR'],
								],
						],
				],
		];
	}

	/**
	 * @param int $id
	 *
	 * @return bool
	 */
	public function finished(int $id): bool {
		$data = $this->find('first', [
			'conditions' => ['id' => $id]
		]);

		if ($data) {
			$this->id = $id;
			$this->saveField('finished', 1);
		}

		return true;
	}
}
