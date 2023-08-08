<?php

App::uses('Model', 'Model');

class AppModel extends Model
{
	public $recursive = -1;

	public $actsAs = [
		'Containable'
	];

	/**
	 * If neccessary, do the following:
	 * - fill in weight field
	 * - fill in lang field
	 * - add http:// to url
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	public function beforeSave($options = []): bool {
		// create
		if (!$this->id) {
			if (empty($this->data[$this->name]['weight']) && $this->hasField('weight')) {
				if (!empty($this->reversedWeight)) {
					$this->data[$this->name]['weight'] = $this->firstWeight();
				} else {
					$this->data[$this->name]['weight'] = $this->lastWeight();
				}
			}

			if (empty($this->data[$this->name]['lang']) && $this->hasField('lang')) {
				$this->data[$this->name]['lang'] = $this->lang;
			}
		}

		if (isset($this->data[$this->name])) {
			foreach ($this->data[$this->name] as $k => $url) {

				if (!empty($url) && ($k === 'website' || $k === 'url' || str_starts_with($k, 'url_') || substr($k, -4, 4) === '_url') && !str_starts_with($url, 'http') && !str_starts_with($url, '#') && !str_starts_with($url, '/')) {
					$this->data[$this->name][$k] = 'http://'.$url;
				}
			}
		}

		if (isset($this->data[$this->name]['translated'])) {
			$this->data[$this->name]['translated'] = json_encode($this->data[$this->name]['translated']);
		}

		return true;
	}

	/**
	 * @param mixed $results
	 * @param bool $primary
	 *
	 * @return mixed
	 */
	public function afterFind($results, $primary = false) {
		if (isset($results[$this->name]['translated'])) {
			$results[$this->name]['translated'] = json_decode($results[$this->name]['translated'], true);
		} else {
			foreach ($results as $k => $v) {
				if (isset($v[$this->name]['translated'])) {
					$results[$k][$this->name]['translated'] = json_decode($v[$this->name]['translated'], true);
				}
			}
		}

		return parent::afterFind($results, $primary);
	}

	/**
	 * Generate random but unique value for specified field
	 *
	 * @param string|null $fieldName Field name
	 * @param int $length Code length (w/o prefix/postfix). Default = 6
	 * @param string|null $prefix String to prepend genereated string (before comparison)
	 * @param string|null $postfix String to append genereated string (before comparison)
	 * @param string|null $charset Chars to use in generation
	 *
	 * @return false|string String on success, false if could not obtain unique string in 1000 steps
	 */
	public function uniqueEntry(string $fieldName = null, int $length = 6, string $prefix = null, string $postfix = null, string $charset = null) {
		if (empty($fieldName) || empty($length)) {
			return false;
		}

		$counter = 0;

		while (true) {
			$value = $prefix.Utils::randomString($length, $charset).$postfix;

			if (!$this->hasAny([$fieldName => $value])) {
				return $value;
			}

			if (++$counter > 1000) {
				$this->log('Could not find free random string in model '.$this->name, LOG_DEBUG);

				return false;
			}
		}
	}

	/**
	 * Check if given field is unique
	 *
	 * @param mixed $data Submitted data
	 * @param mixed $field
	 *
	 * @return bool
	 */
	public function uniqueField($data, $field = null): bool {
		if (empty($field) || !is_string($field)) {
			$field = current(array_keys($data));
		}

		if ($this->hasField($field)) {
			return $this->isUnique([$field => current($data)]);
		}

		return false;
	}

	/**
	 * Enable/disable entry
	 *
	 * If entry is being disabled and it has children, (recursively) disable those as well
	 *
	 * @param int|null $id
	 * @param mixed $enabled Enabled/Disabled. If null, toggle state
	 * @param string fieldName Field name. Default = enabled
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function active(int $id = null, bool $enabled = null, string $fieldName = 'enabled'): bool {
		if (!$this->exists($id)) {
			return false;
		}

		if ($enabled === null) {
			$enabled = !$this->field($fieldName, [$this->primaryKey => $id]);
		}

		$r = (bool)$this->update($id, [$fieldName => $enabled]);

		if ($r && !$enabled && $this->hasField('parent_id')) {
			$children_ids = $this->findList($this->primaryKey, false, ['parent_id' => $id]);

			foreach ($children_ids as $child_id) {
				$this->active($child_id, $enabled, $fieldName);
			}
		}

		return $r;
	}

	/**
	 * Alias for active() for enabling entry
	 *
	 * @param int|null $id
	 * @param string fieldName Field name. Default = enabled
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function enable(int $id = null, string $fieldName = 'enabled'): bool {
		return $this->active($id, 1, $fieldName);
	}

	/**
	 * Alias for active() for disabling entry
	 *
	 * @param int|null $id
	 * @param string fieldName Field name. Default = enabled
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function disable(int $id = null, string $fieldName = 'enabled'): bool {
		return $this->active($id, 0, $fieldName);
	}

	/**
	 * Get specific field from table entry
	 *
	 * @param int|string|null $id
	 * @param string|null $field_name
	 *
	 * @return string|null
	 */
	public function getValue($id = null, string $field_name = null) {
		$id = $id ?? $this->id;

		$value = $this->field($field_name, [$this->primaryKey => $id]);

		if ($value === false) {
			return null;
		}

		return $value;
	}

	/**
	 * Find entry ID (primary key) by field's value
	 *
	 * @param string $field Fielname
	 * @param string $value Value
	 *
	 * @return int|boolean
	 */
	public function getIdByValue(string $field, string $value) {
		$data = $this->find('first', [
			'conditions' => [$field => $value],
			'fields' => $this->primaryKey
		]);

		if ($data) {
			return $data[$this->name][$this->primaryKey];
		}

		return false;
	}

	/**
	 * Increase/decrease specific field by specified amount
	 *
	 * @param int $id
	 * @param string $fieldName Field name to increase
	 * @param int $incAmount Increase/decrease amount (can be negative)
	 *
	 * @return bool
	 */
	public function incFieldValue(int $id, string $fieldName, int $incAmount = 1): bool {
		$data = $this->getValue($id, $fieldName);

		if ($data === false) {
			return false;
		}

		$this->id = $id;

		return (bool)$this->saveField($fieldName, $data + $incAmount);
	}

	/**
	 * Move entry to first place
	 *
	 * @param int|null $id
	 * @param mixed $fields Additional fields
	 *
	 * @return bool
	 */
	public function movefirst(int $id = null, array $fields = []): bool {
		$data = $this->find('first', [
			'conditions' => ['id' => $id]
		]);

		$conditions = [];

		foreach ($fields as $v) {
			$conditions[$v] = $data[$this->name][$v];
		}

		$data = $this->find('first', [
			'conditions' => $conditions,
			'fields' => ['MIN(weight) AS weight']
		]);

		$this->id = $id;
		$r = $this->saveField('weight', $data[0]['weight'] - 1);

		return (bool)$r;
	}

	/**
	 * Move entry one level up (if possible)
	 *
	 * @param int $id
	 * @param array $fields Additional fields
	 * @param string $fieldName (optional) Weight field name. Default = weight
	 *
	 * @return bool
	 */
	public function moveup(int $id, array $fields = [], string $fieldName = 'weight'): bool {
		$data = $this->find('first', [
			'conditions' => ['id' => $id]
		]);

		$weight = $data[$this->name][$fieldName];

		$conditions = [$fieldName.' <' => $weight];

		foreach ($fields as $v) {
			$conditions[$v] = $data[$this->name][$v];
		}

		$data = $this->find('first', [
			'conditions' => $conditions,
			'order' => [$fieldName => 'desc']
		]);

		if ($data) {
			$this->id = $id;
			$this->saveField($fieldName, $data[$this->name][$fieldName]);

			$this->id = $data[$this->name]['id'];
			$this->saveField($fieldName, $weight);
		}

		return true;
	}

	/**
	 * Move entry one level down (if possible)
	 *
	 * @param int $id
	 * @param array $fields Additional fields
	 * @param string $fieldName (optional) Weight field name. Default = weight
	 *
	 * @return bool
	 */
	public function movedown(int $id, array $fields = [], string $fieldName = 'weight'): bool {
		$data = $this->find('first', [
			'conditions' => ['id' => $id]
		]);

		$weight = $data[$this->name][$fieldName];

		$conditions = [$fieldName.' >' => $weight];

		foreach ($fields as $v) {
			$conditions[$v] = $data[$this->name][$v];
		}

		$data = $this->find('first', [
			'conditions' => $conditions,
			'order' => [$fieldName => 'asc']
		]);

		if ($data) {
			$this->id = $id;
			$this->saveField($fieldName, $data[$this->name][$fieldName]);

			$this->id = $data[$this->name]['id'];
			$this->saveField($fieldName, $weight);
		}

		return true;
	}

	/**
	 * Move entry to last place
	 *
	 * @param int $id
	 * @param mixed $fields Additional fields
	 *
	 * @return bool
	 */
	public function movelast(int $id, array $fields = []): bool {
		$data = $this->find('first', [
			'conditions' => ['id' => $id]
		]);

		$conditions = [];

		foreach ($fields as $v) {
			$conditions[$v] = $data[$this->name][$v];
		}

		$data = $this->find('first', [
			'conditions' => $conditions,
			'fields' => ['MAX(weight) AS weight']
		]);

		$this->id = $id;
		$r = $this->saveField('weight', $data[0]['weight'] + 1);

		return (bool)$r;
	}

	/**
	 * Same as deleteAll(true, false, false) but is faster and stronger (performs real truncate
	 * which starts ids from 1)
	 *
	 * @return void
	 */
	public function truncate(): void {
		$this->query('TRUNCATE TABLE `'.$this->tablePrefix.$this->useTable.'`');
	}

	/**
	 * Unbinds validation rules and optionally sets the remaining rules to required.
	 *
	 * @param string $type
	 * - 'Remove' = removes $fields from $this->validate
	 * - 'Keep' = removes everything EXCEPT $fields from $this->validate
	 * @param array $fields
	 * @param bool $require Whether to set 'required' =>true on remaining fields after unbind
	 *
	 * @return void
	 */
	public function unbindValidation(string $type, array $fields, bool $require = false): void {
		if ($type === 'remove') {
			$this->validate = array_diff_key($this->validate, array_flip($fields));
		} elseif ($type === 'keep') {
			$this->validate = array_intersect_key($this->validate, array_flip($fields));
		}

		if ($require === true) {
			foreach ($this->validate as $field => $rules) {
				if (is_array($rules)) {
					$rule = key($rules);
					$this->validate[$field][$rule]['required'] = true;
				} else {
					$ruleName = (ctype_alpha($rules)) ? $rules : 'required';
					$this->validate[$field] = [$ruleName => ['rule' => $rules, 'required' => true]];
				}
			}
		}
	}

	/**
	 * Set $fieldName value to maximum of that column + $incAmount
	 *
	 * @param int $id Primary key
	 * @param string $fieldName Field name
	 * @param float $incAmount Increase/decrease amount (can be negative)
	 *
	 * @return bool
	 */
	public function maxValue(int $id, string $fieldName, float $incAmount = 1): bool {
		$data = $this->find('first', [
			'fields' => 'MAX('.$fieldName.') AS val'
		]);

		$this->id = $id;

		return (bool)$this->saveField($fieldName, $data[0]['val'] + $incAmount);
	}

	/**
	 * Check if uploaded file is among allowed mimetypes.
	 *
	 * @param array $data _FILES array
	 * @param string|array $filetypes Allowed mime types
	 *
	 * @return bool
	 */
	public function validFiletype(array $data, $filetypes): bool {
		$file = current($data);

		// We only check filetype and if file is not uploaded, return true.
		if ($file['error'] !== 0) {
			return true;
		}

		if (!is_array($filetypes)) {
			$filetypes = [$filetypes];
		}

		return in_array($file['type'], $filetypes, true);
	}

	/**
	 * Pārbaudam vai fails ir veiksmīgi ielādējies
	 *
	 * @param array $data _FILES array
	 * @param int|bool $allow_empty If true, allow empty uploads, If 3, require on insert
	 *
	 * @return bool
	 */
	public function isUploaded(array $data, $allow_empty = false): bool {
		$file = current($data);
		if (!$file) {
			return false;
		}

		if ($allow_empty === 3 && isset($this->data)) {
			$allow_empty = !(empty($this->id) && empty($this->data[$this->name]['id']));
		}

		if ($allow_empty && $file['error'] === 4) {
			return true;
		}

		return ($file['error'] === 0);
	}

	/**
	 * Find threaded list of sections
	 *
	 * @param array|null $conditions Conditions
	 * @param string $title Title field
	 *
	 * @return array
	 */
	public function findThreadedList(array $conditions = null, string $title = 'title'): array {
		$data = $this->find('threaded', [
			'conditions' => $conditions,
			'fields' => ['id', 'parent_id', $title],
			'order' => ['weight' => 'asc']
		]);

		$list = [];

		$this->threadedListHelper($data, $list, 0, $title);

		return $list;
	}

	/**
	 * Helper f-ion for findThreadedList
	 *
	 * @param array $data Multidimensional array of data
	 * @param array $list Array where generated list is stored
	 * @param int $level Current depth level used internally
	 * @param string $title Title field
	 *
	 * @return void
	 */
	public function threadedListHelper(array $data, array &$list, int $level = 0, string $title = 'title'): void {
		foreach ($data as $v) {
			$padding = str_repeat('—', $level * 1);

			if ($level > 0) {
				$padding .= ' ';
			}

			$list[$v[$this->name]['id']] = $padding.$v[$this->name][$title];

			if (!empty($v['children'])) {
				$this->threadedListHelper($v['children'], $list, $level + 1, $title);
			}
		}
	}

	/**
	 * Delete specified section and all its children
	 *
	 * @param int $id Parent section's id
	 *
	 * @return void
	 */
	public function deleteThreaded(int $id): void {
		$this->delete($id);
		$this->deleteThreadedHelper($id);
	}

	/**
	 * Helper f-ion for threaded deletion of children
	 *
	 * There is some strange behavior regarding soft-deleting: If callbacks are set
	 * to true when executing deleteAll, then not all entries are marked as deleted.
	 * If callbacks are left as false, parent is soft-deleted, all other entries
	 * are hard-deleted (current behavior)
	 *
	 * @param int|array $parent_id All entries whos parent is $parent_id will be deleted
	 *
	 * @return void
	 */
	public function deleteThreadedHelper($parent_id): void {
		$ids = $this->find('list', [
			'conditions' => ['parent_id' => $parent_id],
			'fields' => 'id'
		]);

		if ($ids) {
			$this->deleteAll([$this->name.'.id' => $ids]);
			$this->deleteThreadedHelper($ids);
		}
	}

	/**
	 * Get entry by ID (w/o associated models by default)
	 *
	 * @param int|null $id
	 * @param mixed $contain Contain data
	 *
	 * @return mixed
	 */
	public function getOrFail(int $id = null, $contain = false) {
		$data = $this->get($id, $contain);

		if (!$data) {
			throw new NotFoundException();
		}

		return $data;
	}

	/**
	 * Get entry by ID (w/o associated models by default)
	 *
	 * @param int|null $id
	 * @param mixed $contain Contain data
	 *
	 * @return array|int|null
	 */
	public function get(int $id = null, $contain = false) {
		return $this->find('first', [
			'conditions' => [$this->name.'.id' => ($id ?? $this->id)],
			'contain' => $contain
		]);
	}

	/**
	 * Get all entries (w/o associated models by default)
	 *
	 * @param mixed $conditions Conditions
	 * @param mixed $contain Contain data
	 *
	 * @return array|int|null
	 */
	public function getAll($conditions = null, $contain = false) {
		return $this->find('all', [
			'conditions' => $conditions,
			'contain' => $contain
		]);
	}

	/**
	 * Return next smallest weight
	 * If there are no entries, return timestamp
	 *
	 * @param mixed $conditions Additional conditions
	 * @param string $field Field name
	 *
	 * @return int
	 */
	public function firstWeight($conditions = false, string $field = 'weight'): int {
		$data = $this->find('first', [
			'conditions' => am([$field.' >' => 0], $conditions),
			'fields' => ['MIN('.$field.') AS weight']
		]);

		if (!$data || $data[0]['weight'] === 0) {
			return time();
		}

		return ($data[0]['weight'] - 1);
	}

	/**
	 * Return next biggest weight
	 * If there are no entries, return timestamp
	 *
	 * @param mixed $conditions Additional conditions
	 * @param string $field Field name
	 *
	 * @return int
	 */
	public function lastWeight($conditions = false, string $field = 'weight'): int {
		$data = $this->find('first', [
			'conditions' => am([$field.' >' => 0], $conditions),
			'fields' => ['MAX('.$field.') AS weight']
		]);

		if (!$data || $data[0]['weight'] === 0) {
			return time();
		}

		return ($data[0]['weight'] + 1);
	}

	/**
	 * Get all column names
	 *
	 * @return array
	 */
	public function getColumns(): array {
		return array_keys($this->getColumnTypes());
	}

	/**
	 * Get next autoincrement ID
	 *
	 * @return int
	 */
	public function getNextAutoIncrement(): int {
		$table = $this->tablePrefix.$this->useTable;

		$data = $this->query('SHOW TABLE STATUS LIKE \''.$table.'\'');

		if ($data) {
			return $data[0]['TABLES']['Auto_increment'];
		}

		return 0;
	}

	/**
	 * Return list of entries
	 *
	 * @param mixed $fields Fields
	 * @param mixed $order Order param. If null, order by display field
	 * @param array|null $conditions
	 *
	 * @return array|int|null
	 */
	public function findList($fields = ['id', 'title'], $order = null, array $conditions = null) {
		if ($order === null) {
			if (is_string($fields)) {
				$order = [$fields => 'asc'];
			} else {
				$order = [end($fields) => 'asc'];
			}
		}

		return $this->find('list', [
			'conditions' => $conditions,
			'fields' => $fields,
			'order' => $order
		]);
	}

	/**
	 * Check if two fields are equal
	 *
	 * @param array $data _POST data
	 * @param string $field1 Name of 1st field
	 * @param string $field2 Name of 2nd field
	 *
	 * @return bool
	 */
	public function isEqual(array $data, string $field1, string $field2): bool {
		return ($this->data[$this->name][$field1] === $this->data[$this->name][$field2]);
	}

	/**
	 * Unbind all models
	 *
	 * This is equivalent to setting recursive = -1 (or contain = false for Containable), but
	 * sometimes life is not that easy. If you need threaded find then recursive MUST be set
	 * to at least 0. This fixes the issue
	 *
	 * @param boolean $reset Set to false to make the unbinding permanent
	 *
	 * @return void
	 */
	public function unbindAll(bool $reset = true): void {
		foreach ([
			'hasOne' => array_keys($this->hasOne),
			'hasMany' => array_keys($this->hasMany),
			'belongsTo' => array_keys($this->belongsTo),
			'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany)
		] as $relation => $model) {
			$this->unbindModel([$relation => $model], $reset);
		}
	}

	/**
	 * Construct search conditions
	 *
	 * Return conditions array from passed post data
	 * Search data must be 2 level deep array (Model => fields)
	 *
	 * @param mixed $data Passed search data
	 * @param array $precise Which fields (Model.field) should be matched precisely (not using LIKE '%example%')
	 *
	 * @return array
	 */
	public function searchConditions($data, array $precise = []): array {
		$conditions = [];

		if (!empty($data)) {
			foreach ($data as $model => $fields) {
				foreach ($fields as $k => $v) {
					if ($v !== '') {
						if ($k === 'created' || $k === 'updated' || str_contains($k, 'date')) {
							$v = date('Y-m-d', strtotime($v));
						}

						if (is_array($v) || in_array($model.'.'.$k, $precise, true) || substr($k, -3, 3) === '_id' || in_array($k, ['id', 'date'])) {
							$conditions[$model.'.'.$k] = $v;
						} elseif (in_array($k[strlen($k) - 1], ['=', '<', '>'])) {
							$conditions[$model.'.'.$k] = $v;
						} elseif ($k === 'updated' || $k === 'created' || str_contains($k, 'date')) {
							$conditions[$model.'.'.$k.' LIKE'] = $v.'%';
						} else {
							$conditions[$model.'.'.$k.' LIKE'] = '%'.$v.'%';
						}
					}
				}
			}
		}

		return $conditions;
	}

	/**
	 * Replace existing file (if any) with new one
	 *
	 * New file must be already saved on filesystem. Function just deletes old one (if any)
	 * and write new one's info to db
	 *
	 * @param int $id
	 * @param string $filename New filename
	 * @param string $field Field name in db
	 * @param mixed $paths Directory/-ies where files are stored on filesystem
	 *
	 * @return bool
	 */
	public function replaceFile(int $id, string $filename, string $field, $paths): bool {
		$old_filename = $this->getValue($id, $field);

		if ($filename === $old_filename) {
			return true;
		}

		if (!empty($old_filename)) {
			if (is_string($paths)) {
				$paths = [$paths];
			}

			foreach ($paths as $path) {
				if ($path[strlen($path) - 1] !== DIRECTORY_SEPARATOR) {
					$path .= DIRECTORY_SEPARATOR;
				}

				Utils::deleteNode($path.$old_filename);
			}
		}

		$this->id = $id;

		return (bool)$this->saveField($field, $filename);
	}

	/**
	 * Get executed queries
	 *
	 * @return array
	 */
	public function getQueries(): array {
		return $this->getDataSource()->getLog(false, false);
	}

	/**
	 * Get full table name
	 *
	 * @return string
	 */
	public function tableName(): string {
		return $this->tablePrefix.$this->useTable;
	}

	/**
	 * Check if supplied youtube url is valid
	 *
	 * @param mixed $data _POST data
	 *
	 * @return bool
	 */
	public function isValidYoutubeUrl($data): bool {
		$url = trim(current($data));

		if (empty($url)) {
			return true;
		}

		$url = trim($url, '/');

		if (preg_match('/youtu\.be\/(.*)/', $url)) {
			return true;
		}

		if (!str_contains($url, 'youtube')) {
			return false;
		}

		parse_str(parse_url($url, PHP_URL_QUERY), $params);

		return isset($params['v']);
	}

	/**
	 * Update entry
	 *
	 * @param int $id
	 * @param array $data Data to update
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function update(int $id, array $data) {
		$this->id = $id;

		return $this->save($data);
	}

	/**
	 * Convert threaded data array to flat
	 *
	 * New "_level" key will be added
	 *
	 * @param mixed $data
	 *
	 * @return array
	 */
	public function threadedToFlat($data): array {
		$flattened = [];

		$this->threadedToFlatHelper($data, $flattened);

		return $flattened;
	}

	/**
	 * Helper f-ion for threadedToFlat
	 *
	 * @param array $data Multidimensional array of data
	 * @param array $flattened Array where newly generated data is stored
	 * @param int $level Current depth level (used internally)
	 *
	 * @return void
	 */
	public function threadedToFlatHelper(array $data, array &$flattened, int $level = 0): void {
		foreach ($data as $v) {
			$new_item = $v;
			$new_item[$this->name]['_level'] = $level;
			unset($new_item['children']);

			$flattened[] = $new_item;

			if (!empty($v['children'])) {
				$this->threadedToFlatHelper($v['children'], $flattened, $level + 1);
			}
		}
	}

	/**
	 * Save all entries in one go
	 *
	 * @param mixed $data Data to save
	 * @param mixed $chunked (int|false) If specified, split queries into chunks
	 *
	 * @return bool
	 */
	public function bulkSave(array $data, $chunked = 1000): bool {
		if (empty($data)) {
			return false;
		}

		$values = [];

		$table = $this->tablePrefix.$this->useTable;
		$fields = array_keys($data[0]);

		$qstrs = [];

		foreach ($data as $v) {
			$quoted_values = [];

			foreach ($v as $value) {
				if ($value === null) {
					$quoted_values[] = 'NULL';
				} else {
					$quoted_values[] = "'".$value."'";
				}
			}

			$values[] = "(".implode(',', $quoted_values).")";

			if ($chunked && count($values) >= $chunked) {
				$qstrs[] = 'INSERT INTO '.$table.' ('.implode(', ', $fields).') VALUES '.implode(',', $values);
				$values = [];
			}
		}

		if ($values) {
			$qstrs[] = 'INSERT INTO '.$table.' ('.implode(', ', $fields).') VALUES '.implode(',', $values);
		}

		foreach ($qstrs as $qstr) {
			$this->query($qstr);
		}

		return true;
	}

	/**
	 * Get minimum value of $fieldName column
	 *
	 * @param string $fieldName Field name
	 *
	 * @return mixed
	 */
	public function getMin(string $fieldName) {
		$data = $this->find('first', [
			'fields' => 'MIN('.$fieldName.') AS val'
		]);

		if (!$data) {
			return false;
		}

		return $data[0]['val'];
	}

	/**
	 * Get maximumum value of $fieldName column
	 *
	 * @param string $fieldName Field name
	 *
	 * @return mixed
	 */
	public function getMax(string $fieldName) {
		$data = $this->find('first', [
			'fields' => 'MAX('.$fieldName.') AS val'
		]);

		if (!$data) {
			return false;
		}

		return $data[0]['val'];
	}

	/**
	 * @return void
	 */
	public function fillTitlesAndSlugsOnCreate(): void {
		$title = $this->data[$this->name]['title_'.$this->lang];
		$strid = $this->data[$this->name]['strid_'.$this->lang];
		foreach (array_keys(Configure::read('Languages.all')) as $lang) {
			if (empty($this->data[$this->name]['title_'.$lang])) {
				$this->data[$this->name]['title_'.$lang] = $title;
				$this->data[$this->name]['strid_'.$lang] = $strid;
			}
		}
	}
}
