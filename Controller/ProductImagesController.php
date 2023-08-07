<?php

App::uses('AppController', 'Controller');
App::uses('Product', 'Model');

/**
 * Product images
 */
class ProductImagesController extends AppController
{
	public $name = 'ProductImages';

	public $uses = ['ProductImage'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		if (empty($this->request->named['product_id'])) {
			throw new BadRequestException();
		}

		$product_id = $this->request->named['product_id'];

		$search = ['ProductImage' => ['product_id' => $product_id]];
		$data = $this->ProductImage->adminList($this, 1000, $search);

		$this->set(compact('data', 'product_id'));
	}

	/**
	 * @return void
	 */
	public function admin_thumbs(): void {
		if (empty($this->request->named['product_id'])) {
			throw new BadRequestException();
		}

		$product_id = $this->request->named['product_id'];

		$search = ['ProductImage' => ['product_id' => $product_id]];
		$data = $this->ProductImage->adminList($this, 1000, $search);

		$this->set(compact('data', 'product_id'));
	}

	/**
	 * @param string|array $ids
	 *
	 * @return void
	 */
	public function admin_sort_images($ids): void {
		if ($this->ProductImage->sortImages($ids)) {
			die('OK');
		}

		die('ERR');
	}

	/**
	 * @return void
	 */
	public function admin_upload(): void {
		if (!$this->request->params['form']['Filedata']) {
			throw new BadRequestException();
		}

		$file = $this->request->params['form']['Filedata'];

		if (!$this->ProductImage->add($file, $this->request->data('product_id'))) {
			throw new InternalErrorException();
		}

		$data = $this->ProductImage->get($this->ProductImage->id);

		$response = $this->request->data('response');

		$this->set(compact('data', 'response'));

		$this->render('admin_uploaded', 'ajax');
	}

	/**
	 * @return void
	 */
	public function admin_update(): void {
		if ($this->request->is(['post', 'put'])) {
			foreach ($this->request->data('ProductImage') as $id => $data) {
				$this->ProductImage->update($id, $data);
			}

			$this->Flash->success(__d('admin', 'MSG_OK'));
		}

		$this->redirect($this->referer());
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_moveup(int $id): void {
		$success = $this->ProductImage->moveup($id, ['product_id']);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_movedown(int $id): void {
		$success = $this->ProductImage->movedown($id, ['product_id']);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		if (!empty($this->request->data['id'])) {
			foreach ($this->request->data['id'] as $k_id => $checked) {
				if ($checked) {
					$this->ProductImage->delete($k_id);
				}
			}
		} else {
			$this->ProductImage->delete($id);
		}

		$success = true;
		$this->actionResponse($success);
	}
}
