<?php

class ProductImage extends AppModel
{
	public $name = 'ProductImage';

	public $belongsTo = [
		'Product'
	];

	public $items = [[
		'output' => 'uploads/images/products/large/',
		'enlarge' => false,
		'quality' => 96,
		'height' => 1500,
		'width' => 1500,
		'mode' => 'fit'
	], [
		'output' => 'uploads/images/products/medium/',
		'enlarge' => false,
		'quality' => 96,
		'height' => 241,
		'width' => 241,
		'mode' => 'crop'
	], [
		'output' => 'uploads/images/products/small/',
		'enlarge' => false,
		'quality' => 96,
		'height' => 55,
		'width' => 55,
		'mode' => 'crop'
	], [
		'output' => 'uploads/images/products/preview/',
		'mode' => 'crop',
		'quality' => 92,
		'width' => 133,
		'height' => 90
	], [
		'output' => 'uploads/images/products/original/',
		'move' => true
	]
	];

	/**
	 * Delete physical files as well
	 */
	public function beforeDelete($cascade = true): bool {
		$data = $this->read();

		foreach ($this->items as $v) {
			Utils::deleteNode([
				APP.'webroot'.DS.$v['output'].$data['ProductImage']['filename']
			]);
		}

		return parent::beforeDelete($cascade);
	}

	/**
	 * Sort product items
	 *
	 * Sort items in exact order as passed ids
	 *
	 * @param array|string $ids Array or comma separated string of product item ids
	 *
	 * @return bool
	 */
	public function sortImages($ids): bool {
		if (is_string($ids)) {
			$ids = explode(',', $ids);
		}

		$weight = time() - count($ids);

		foreach ($ids as $k => $id) {
			$this->id = $id;
			if (!$this->saveField('weight', ($weight + $k))) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @param object $Controller
	 * @param int $limit
	 * @param mixed $search Search fields/values
	 *
	 * @return mixed
	 */
	public function adminList(object $Controller, int $limit = 20, $search = null) {
		$conditions = [];

		$conditions = array_merge($conditions, $this->searchConditions($search));

		$Controller->paginate = [
			'conditions' => $conditions,
			'order' => ['ProductImage.weight' => 'asc'],
			'limit' => $limit,
			'recursive' => -1
		];

		return $Controller->paginate();
	}

	/**
	 * Add new item
	 *
	 * Upload/resize and save file
	 *
	 * @param mixed $file Uploaded file object
	 * @param int $product_id Product ID
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function add($file, int $product_id): bool {
		if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
			return false;
		}

		$dir_path = APP.'webroot'.DS.current($this->items)['output'];
		$filename = Utils::safeFilename($file['name'], $dir_path);

		$saved_files = [];

		foreach ($this->items as $item) {
			$item['output'] = APP.'webroot'.DS.$item['output'].$filename;
			$item['input'] = $file['tmp_name'];

			$r = ImageTool::resize($item);

			if ($r) {
				$saved_files[] = $item['output'];
			} else {
				Utils::deleteNode($saved_files);

				return false;
			}
		}

		$r = $this->save([
			'id' => null,
			'product_id' => $product_id,
			'filename' => $filename
		]);

		if (!$r) {
			Utils::deleteNode($saved_files);

			return false;
		}

		return true;
	}
}
