<?php

class TrackingView extends AppModel
{
	public $name = 'TrackingView';

	public $belongsTo = [
		'Tracking',
	];

	public $hasMany = [
		'TrackingUser' => [
			'foreignKey' => 'views_id'
		],
	];

	/**
	 * @param int $tracking_id
	 *
	 * @return $this|array|int|null
	 *
	 * @throws Exception
	 */
	public function firstOrCreate(int $tracking_id) {
		$data['tracking_id'] = $tracking_id;
		$data['date'] = date('Y-m-d');

		if (!$this->hasAny($data)) {
			$this->save($data);

			return (array)$this;
		}

		$record = $this->find('first', [
			'conditions' => [$data],
			'fields' => ['id', 'views', 'form_submit', 'pdf_download']
		]);

		return $record['TrackingView'];
	}

	public function previousViews(int $id, array $search = null) {
		$conditions = [];
		$conditions['TrackingView.tracking_id'] = $id;

		$start_date = $search['Tracking']['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
		$end_date = $search['Tracking']['end_date'] ?? date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
		$end_date = date('Y-m-d', strtotime('-1 day', strtotime($end_date)));
		$diff = date_diff(date_create($end_date), date_create($start_date));

		$conditions['TrackingView.date >='] = date('Y-m-d', strtotime($diff->format('%R%a days'), strtotime($start_date)));
		$conditions['TrackingView.date <='] = date('Y-m-d', strtotime($diff->format('%R%a days'), strtotime($end_date)));

		$this->virtualFields['previous_views'] = 'SUM(TrackingView.views)';

		return $this->find('all', [
			'fields' => ['previous_views'],
			'conditions' => $conditions,
		]);
	}
}
