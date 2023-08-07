<?php

App::uses('AppController', 'Controller');

/**
 * Metatags
 */
class MetatagsController extends AppController
{
	public $name = 'Metatags';

	public $uses = ['Metatag'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Metatag->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_update(int $id): void {
		if ($this->request->is(['post', 'put'])) {
			if ($this->Metatag->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} else {
			$this->request->data = $this->Metatag->getOrFail($id);
		}
	}

	/**
	 * @return void
	 */
	public function admin_update_external(): void {
		if ($this->request->is(['post', 'put'])) {
			$data = array_merge(['lang' => $this->lang], $this->request->data('Metatag'));

			if ($this->Metatag->saveData($data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		}

		$this->redirect($this->referer());
	}
}
