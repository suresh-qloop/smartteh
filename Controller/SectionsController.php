<?php

App::uses('AppController', 'Controller');
App::uses('Section', 'Model');

/**
 * Sections
 */
class SectionsController extends AppController
{
	public $name = 'Sections';

	public $uses = ['Section'];

	/**
	 * @param string $strid
	 */
	public function view(string $strid): void {

		// $this->tempRedirect($this->lang);
		$this->redirectFromIdToStrid($this->Section, $strid, 'strid_' . $this->lang);

		$data = $this->Section->findByStrid($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Section->findByStrid($strid, $lang);
				if ($data) {
					$this->redirect(['action' => 'view', $data['Section']['strid_' . $this->lang]], 301);
				}
			}

			$this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);
			// throw new NotFoundException();
		}


		if (!$data) {
			throw new NotFoundException();
		}
		$urls = $this->commanUrlGet($this->lang,$strid,'Section','sections');
		$this->set(compact('data','urls'));
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$data = $this->Section->adminList($this, 20);
		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Section->save($this->request->data)) {
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
			if ($this->Section->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Section.id');
		} else {
			$this->request->data = $this->Section->getOrFail($id);
		}

		$this->set(compact('id'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_metatags(int $id): void {
		$this->request->data = $this->Metatag->getData([
			'lang' => $this->lang,
			'controller' => $this->request->controller,
			'action' => 'view',
			'pid' => $id
		]);

		$this->set(compact('id'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		$this->Section->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
