<?php

class Tracking extends AppModel
{
	public $name = 'Tracking';

	public $useTable = 'tracking';

	public $hasMany = [
		'TrackingView'
	];

	/**
	 * Check if record exists if not create new one
	 *
	 * @param array $data
	 * @param string $lang
	 *
	 * @return array|bool|int|mixed|string
	 * @throws \Exception
	 */
	public function firstOrCreate(array $data, string $lang) {
		$data['lang'] = $lang;
		$img_alt = $data['img_alt'];
		unset($data['img_alt']);
		if (!$this->hasAny($data)) {
			$this->save($data);

			return $this->id;
		}

		$record = $this->find('first', [
			'conditions' => [$data],
			'fields' => ['id']
		]);

		$this->updateAll(
			['img_alt' => "'$img_alt'"],
			['Tracking.id' => $record['Tracking']['id']]
		);

		return $record['Tracking']['id'];
	}


	/**
	 * @param object $Controller
	 * @param int $limit
	 * @param array|null $search Search fields/values
	 * @param array $group Group By value
	 * @param bool $img
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20, array $search = null, array $group = ['Tracking.url'], bool $img = false) {
		$conditions = [];

		$start_date = $search['Tracking']['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
		$end_date = $search['Tracking']['end_date'] ?? date('Y-m-d');

		$conditions["TrackingViews.date >="] = $start_date;
		$conditions["TrackingViews.date <="] = $end_date;

		if ($img) {
			$conditions['Tracking.img !='] = '';
		}

		$conditions["Tracking.lang"] = $Controller->lang;

		$this->virtualFields['summedViews'] = 'SUM(TrackingViews.views)';
		$this->virtualFields['summedForms'] = 'SUM(TrackingViews.form_submit)';
		$this->virtualFields['summedPDF'] = 'SUM(TrackingViews.pdf_download)';

		$Controller->paginate = [
			'conditions' => $conditions,
			'joins' => [
				[
					'table' => 'tracking_views',
					'alias' => 'TrackingViews',
					'type' => 'LEFT',
					'conditions' => [
						'Tracking.id = TrackingViews.tracking_id',
					],
				],
			],
			'group' => $group,
			'limit' => $limit
		];

		return $Controller->paginate();
	}
}
