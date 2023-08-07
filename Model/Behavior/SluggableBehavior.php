<?php

/**
 * Model behavior to support generation of slugs for models.
 */
class SluggableBehavior extends ModelBehavior
{
	public $settings = [];

	public $defaults = [
		'overwrite' => false,
		'label' => 'title',
		'separator' => '-',
		'slug' => 'slug',
		'length' => 100,
		'l10n' => false
	];

	/**
	 * Initiate behavior for the model using specified settings. Available settings:
	 *
	 * - label (string): set to the field name that contains the string from where to generate the slug
	 * - slug (string): name of the field name that holds generated slugs
	 * - separator (string): separator character / string to use for replacing non alphabetic characters in generated slug
	 * - length (integer): maximum length the generated slug can have
	 * - overwrite (boolean): set to true if slugs should be re-generated when updating an existing record
	 * - l10n (boolean): set to true, to make slugs for each language. "_XX" will be appended to label/slug for each lang
	 *
	 * @param Model $model Model using the behaviour
	 * @param array $config Settings to override for model
	 */
	public function setup(Model $model, $config = []) {
		if (!is_array($config)) {
			$config = [];
		} else {
			if (!is_int(current(array_keys($config)))) {
				$config = [$config];
			}
		}

		$final_config = [];

		$langs = array_keys(Configure::read('Languages.all'));

		foreach ($config as $k => $settings) {
			$settings = array_merge($this->defaults, $settings);

			if ($settings['l10n']) {
				foreach ($langs as $lang) {
					$lang_settings = $settings;
					$lang_settings['label'] .= '_'.$lang;
					$lang_settings['slug'] .= '_'.$lang;
					$final_config[] = $lang_settings;
				}
			} else {
				$final_config[] = $settings;
			}
		}

		$this->settings[$model->alias] = $final_config;
	}

	/**
	 * Run before a model is saved, used to set up slug for model.
	 *
	 * @param Model $model Model using this behavior
	 * @param array $options Options passed from Model::save().
	 *
	 * @return mixed False if the operation should abort. Any other result will continue.
	 */
	public function beforeSave(Model $model, $options = []) {
		$return = parent::beforeSave($model);

		$model_data = $model->data[$model->alias];

		foreach ($this->settings[$model->alias] as $settings) {

			// See if we should be generating a slug
			if (!empty($model_data[$settings['slug']]) || ($model->id && !$settings['overwrite'])) {
				continue;
			}

			// Keep on going only if we've got something to slug
			if (empty($model_data[$settings['label']])) {
				continue;
			}

			$label = $model_data[$settings['label']];

			$slug = $this->__slug($label, $settings);

			// Look for slugs that start with the same slug we've just generated

			$conditions = [$model->alias.'.'.$settings['slug'].' LIKE' => $slug.'%'];
			if ($model->id) {
				$conditions['NOT'][$model->alias.'.'.$model->primaryKey] = $model->id;
			}

			$entries = $model->find('all', [
				'conditions' => $conditions,
				'fields' => [$model->primaryKey, $settings['slug']],
				'recursive' => -1
			]);

			if (!empty($entries)) {
				$same_slugs = Hash::extract($entries, '{n}.'.$model->alias.'.'.$settings['slug']);
				if ($same_slugs) {
					$index = 0;
					while (++$index) {
						if (!in_array($slug.$settings['separator'].$index, $same_slugs)) {
							$slug .= $settings['separator'].$index;
							break;
						}
					}
				}
			}

			// making sure that we are on the whitelist of fields to be saved
			if (!empty($model->whitelist) && !in_array($settings['slug'], $model->whitelist)) {
				$model->whitelist[] = $settings['slug'];
			}

			$model->data[$model->alias][$settings['slug']] = $slug;
		}

		return $return;
	}

	/**
	 * Generate a slug for the given string using specified settings.
	 *
	 * @param string $string String from where to generate slug
	 * @param array $settings Settings to use (looks for 'separator' and 'length')
	 *
	 * @return string Slug for given string
	 */
	function __slug($string, $settings) {
		$slug = strtolower(
			Inflector::slug($string, $settings['separator'])
		);

		if (strlen($slug) > $settings['length']) {
			$slug = substr($slug, 0, $settings['length']);
		}

		return $slug;
	}
}
