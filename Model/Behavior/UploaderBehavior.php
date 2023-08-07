<?php

/**
 * Manage model's images
 */
class UploaderBehavior extends ModelBehavior
{

	private $defaultOptions = [
		'fields' => []
	];

	private $options = [];

	public function setup(Model $model, $config = []) {
		$this->options[$model->alias] = array_merge($this->defaultOptions, $config);
	}

	/**
	 * CakePHP Model Functions
	 */
	public function afterSave(Model $model, $created, $options = []) {
		$data = $model->data;

		foreach ($this->options[$model->alias]['fields'] as $field => $variations) {
			$present = isset($data[$model->alias][$field.'_file']);
			$whitelisted = !$model->whitelist || empty($model->whitelist) || in_array($field, $model->whitelist);

			if (!$present || !$whitelisted) {
				continue;
			}

			$file = $data[$model->alias][$field.'_file'];

			if (!is_numeric(array_keys($variations)[0])) {
				$variations = [$variations];
			}

			switch ($file['error']) {
				case UPLOAD_ERR_OK:
					$dir_paths = [];
					$save = true;
					foreach ($variations as $params) {
						$dir_path = WWW_ROOT.$params['output'].DS;
						$dir_paths[] = $dir_path;
						$filename = Utils::safeFilename($file['name'], $dir_path);

						$params['input'] = $file['tmp_name'];
						$params['output'] = $dir_path.$filename;

						if (!empty($params['move'])) {
							$save = $save && copy($params['input'], $params['output']);
						} else {
							$save = $save && ImageTool::resize($params);
						}
					}

					if ($save) {
						$model->replaceFile($model->id, $filename, $field, $dir_paths);
					}
					break;

				case UPLOAD_ERR_NO_FILE:
					if (!empty($data[$model->alias]['delete_'.$field])) {
						$dir_paths = [];
						foreach ($variations as $params) {
							$dir_paths[] = WWW_ROOT.$params['output'].DS;
						}

						$model->replaceFile($model->id, '', $field, $dir_paths);
					}
					break;
			}
		}
	}

	/**
	 * Delete uploaded files
	 *
	 * @param Model $model
	 * @param boolean $cascade
	 *
	 * @return bool
	 */
	public function beforeDelete(Model $model, $cascade = true) {
		$data = $model->read();

		foreach ($this->options[$model->alias]['fields'] as $field => $variations) {
			$filename = $data[$model->alias][$field];

			if (!$filename) {
				continue;
			}

			if (!is_numeric(array_keys($variations)[0])) {
				$variations = [$variations];
			}

			foreach ($variations as $params) {
				Utils::deleteNode([
					WWW_ROOT.$params['output'].DS.$filename
				]);
			}
		}

		return true;
	}
}
