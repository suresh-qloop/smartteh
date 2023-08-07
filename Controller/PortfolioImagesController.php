<?php

App::uses('AppController', 'Controller');
App::uses('Portfolio', 'Model');

/**
 * Portfolio images
 */
class PortfolioImagesController extends AppController
{
	public $name = 'PortfolioImages';

	public $uses = ['PortfolioImage'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		if (empty($this->request->named['portfolio_id'])) {
			throw new BadRequestException();
		}

		$portfolio_id = $this->request->named['portfolio_id'];

		$search = ['PortfolioImage' => ['portfolio_id' => $portfolio_id]];
		$data = $this->PortfolioImage->adminList($this, 1000, $search);

		$this->set(compact('data', 'portfolio_id'));
	}

	/**
	 * @return void
	 */
	public function admin_thumbs(): void {
		if (empty($this->request->named['portfolio_id'])) {
			throw new BadRequestException();
		}

		$portfolio_id = $this->request->named['portfolio_id'];

		$search = ['PortfolioImage' => ['portfolio_id' => $portfolio_id]];
		$data = $this->PortfolioImage->adminList($this, 1000, $search);

		$this->set(compact('data', 'portfolio_id'));
	}

	/**
	 * Sort portfolio images
	 *
	 * @param string|array $ids
	 *
	 * @return void
	 */
	public function admin_sort_images($ids = null): void {
		if ($this->PortfolioImage->sortImages($ids)) {
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

		if (!$this->PortfolioImage->add($file, $this->request->data('portfolio_id'))) {
			throw new InternalErrorException();
		}

		$data = $this->PortfolioImage->get($this->PortfolioImage->id);

		$response = $this->request->data('response');

		$this->set(compact('data', 'response'));

		$this->render('admin_uploaded', 'ajax');
	}

	/**
	 * @return void
	 */
	public function admin_update(): void {
		if ($this->request->is(['post', 'put'])) {
			foreach ($this->request->data('PortfolioImage') as $id => $data) {
				$this->PortfolioImage->update($id, $data);
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
		$success = $this->PortfolioImage->moveup($id, ['portfolio_id']);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_movedown(int $id): void {
		$success = $this->PortfolioImage->movedown($id, ['portfolio_id']);
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
					$this->PortfolioImage->delete($k_id);
				}
			}
		} else {
			$this->PortfolioImage->delete($id);
		}

		$success = true;
		$this->actionResponse($success);
	}
}
