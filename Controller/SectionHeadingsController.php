<?php

App::uses('AppController', 'Controller');
App::uses('SectionHeading', 'Model');

/**
 * SectionHeadings
 */
class SectionHeadingsController extends AppController
{
	public $name = 'SectionHeadings';

	public $uses = ['SectionHeading'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->SectionHeading->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->SectionHeading->save($this->request->data)) {
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
			if ($this->SectionHeading->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} else {
			$this->request->data = $this->SectionHeading->getOrFail($id);
		}
	}
}
