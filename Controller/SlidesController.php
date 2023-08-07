<?php

App::uses('AppController', 'Controller');

/**
 * Slides
 */
class SlidesController extends AppController
{
	public $name = 'Slides';

	public $uses = ['Slide'];

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public function admin_index(): void {
		$data = $this->Slide->adminList($this, 15);
		$this->set(compact('data'));
	}

	public function admin_create(): void {
		if ($this->request->is('post')) {
			$this->request->data['Slide']['lang'] = $this->lang;

			if ($this->Slide->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		}

		$list_colors = $this->Slide->colors;
		$this->set(compact('list_colors'));
	}

	/**
	 * @param int|null $id
	 */
	public function admin_update(int $id): void {
		if ($this->request->is(['post', 'put'])) {
			if ($this->Slide->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = $this->request->data('Slide.id');
		} else {
			$this->request->data = $this->Slide->getOrFail($id);
		}

		$list_colors = $this->Slide->colors;

		$this->set(compact('id', 'list_colors'));
	}

	/**
	 * @param int|null $id
	 * @param bool|null $enabled
	 */
	public function admin_active(int $id, bool $enabled = null) {
		$success = $this->Slide->active($id, $enabled);
		$this->actionResponse($success);
	}

	/**
	 * @param int|null $id
	 */
	public function admin_moveup(int $id): void {
		$success = $this->Slide->moveup($id, ['lang']);
		$this->actionResponse($success);
	}

	/**
	 * @param int|null $id
	 */
	public function admin_movedown(int $id): void {
		$success = $this->Slide->movedown($id, ['lang']);
		$this->actionResponse($success);
	}

	/**
	 * @param int|null $id
	 */
	public function admin_delete(int $id): void {
		$this->Slide->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
