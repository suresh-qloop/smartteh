<?php

App::uses('AppController', 'Controller');
App::uses('Service', 'Model');

/**
 * Services
 */
class ServicesController extends AppController
{
	public $name = 'Services';

	public $uses = ['Service'];

	/**
	 * @return void
	 */
	public function index(): void {

		$data = $this->Service->getFirst();

		if (!$data) {
			throw new NotFoundException();
		}

		// to correctly fetch metatags
		// $this->request->action = 'view';

		// $this->view($data['Service']['strid_' . $this->lang]);

		$this->redirect(['action' => 'view', $data['Service']['strid_' . $this->lang]], 301);
	}

	/**
	 * @param string $strid
	 *
	 * @return void
	 */
	public function view(string $strid): void {
		// $this->tempRedirect($this->lang);
		$this->redirectFromIdToStrid($this->Service, $strid, 'strid_' . $this->lang);

		$data = $this->Service->findByStrid($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Service->findByStrid($strid, $lang);
				if ($data && in_array($this->lang, $data['Service']['translated'], true)) {
					$this->redirect(['action' => 'view', $data['Service']['strid_' . $this->lang]]);
				}
			}

			$this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);
			// throw new NotFoundException();
		}

		$breadcrumbs = $this->Service->getFullBreadcrumbs($data['Service']['id'], $this->lang);

		$bc = [$data['Service']['id']];

		$heading = $this->Service->getValue($bc[0], 'title_' . $this->lang);

		$robots_noindex = !in_array($this->lang, $data['Service']['translated'], true);
		$urls = $this->commanUrlGet($this->lang,$strid,'Service','services');
		$this->set(compact(
			'data',
			'breadcrumbs',
			'bc',
			'heading',
			'robots_noindex',
			'urls'
		));

		$this->render('view');
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Service->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Service->save($this->request->data)) {
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
			if ($this->Service->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Services.id');
		} else {
			$this->request->data = $this->Service->getOrFail($id);
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
		$success = $this->Service->active($id, $enabled);
		$this->actionResponse($success);
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
	public function admin_moveup(int $id): void {
		$success = $this->Service->moveup($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_movedown(int $id): void {
		$success = $this->Service->movedown($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		$this->Service->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
