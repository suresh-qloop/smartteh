<?php

class TrackingUser extends AppModel
{
	public $name = 'TrackingUser';

	public $belongsTo = [
		'TrackingView' => [
			'foreignKey' => 'views_id'
		],
	];
}
