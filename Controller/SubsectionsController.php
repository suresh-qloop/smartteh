<?php

App::uses('AppController', 'Controller');
App::uses('Subsection', 'Model');

/**
 * Subsections
 */
class SubsectionsController extends AppController
{
	public $name = 'Subsections';

	public $uses = ['Subsection'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Subsection->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Subsection->save($this->request->data)) {
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
			if ($this->Subsection->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} else {
			$this->request->data = $this->Subsection->getOrFail($id);
		}
	}
}
