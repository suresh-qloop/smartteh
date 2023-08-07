<?php

App::uses('AppController', 'Controller');

/**
 * Quotes
 */
class QuotesController extends AppController
{
	public $name = 'Quotes';

	public $uses = ['Quote'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$data = $this->Quote->adminList($this, 15);
		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Quote->save($this->request->data)) {
				$this->request->data['Quote']['lang'] = $this->lang;

				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		}
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_update(int $id): void {
		if ($this->request->is(['post', 'put'])) {
			if ($this->Quote->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Quote.id');
		} else {
			$this->request->data = $this->Quote->getOrFail($id);
		}

		$this->set(compact('id'));
	}

	/**
	 * @param int $id
	 * @param bool|null $enabled
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_active(int $id, bool $enabled = null): void {
		$success = $this->Quote->active($id, $enabled);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		$this->Quote->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
