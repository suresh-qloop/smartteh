<?php

/**
 * Duplicate value from one field to the same field in all languages
 */
class L10nPlaceholderBehavior extends ModelBehavior
{
	public $settings = [];

	public $defaults = [
		'fields' => ['title'],
		'update' => false,
		'langs' => null
	];

	/**
	 * Initiate behavior for the model using specified settings
	 *
	 * @param Model $model Model using the behaviour
	 * @param array $config Settings to override for model
	 */
	public function setup(Model $model, $config = []) {
		if (!is_array($config)) {
			$config = [];
		}

		$config = array_merge($this->defaults, $config);

		if (!$config['langs']) {
			$config['langs'] = array_keys(Configure::read('Languages.all'));
		}

		$this->settings[$model->alias] = $config;
	}

	/**
	 * Run before a model is saved
	 *
	 * @param Model $model Model using this behavior
	 * @param array $options Options passed from Model::save().
	 *
	 * @return mixed False if the operation should abort. Any other result will continue.
	 */
	public function beforeSave(Model $model, $options = []) {
		$return = parent::beforeSave($model);

		$settings = $this->settings[$model->alias];

		if ($model->id && !$settings['update']) {
			return $return;
		}

		$fields = (array)$settings['fields'];

		foreach ($fields as $field) {
			foreach ($settings['langs'] as $lang1) {
				if (!empty($model->data[$model->alias][$field.'_'.$lang1])) {
					foreach ($settings['langs'] as $lang2) {
						if ($lang1 != $lang2 && empty($model->data[$model->alias][$field.'_'.$lang2])) {
							$model->data[$model->alias][$field.'_'.$lang2] = $model->data[$model->alias][$field.'_'.$lang1];
						}
					}
					break;
				}
			}
		}

		return $return;
	}
}
