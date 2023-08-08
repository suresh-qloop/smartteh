<?php

App::uses('AppController', 'Controller');
App::uses('Industry', 'Model');

/**
 * Industries
 */
class IndustriesController extends AppController
{
	public $name = 'Industries';

	public $uses = ['Industry', 'Product'];

	/**
	 * @return void
	 */
	public function index(): void {
		$data = $this->Industry->getFirst();

		if (!$data) {
			throw new NotFoundException();
		}

		// to correctly fetch metatags
		$this->request->action = 'view';

		$this->view($data['Industry']['strid_' . $this->lang]);
	}

	/**
	 * @param string $strid
	 */
	public function view(string $strid): void {
		// $this->tempRedirect($this->lang);
		$this->redirectFromIdToStrid($this->Industry, $strid, 'strid_' . $this->lang);

		$data = $this->Industry->findByStrid($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Industry->findByStrid($strid, $lang);
				if ($data && in_array($this->lang, $data['Industry']['translated'], true)) {
					$this->redirect(['action' => 'view', $data['Industry']['strid_' . $this->lang]]);
				}
			}

			$this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);
			// throw new NotFoundException();
		}

		$page_header_image = $this->Industry->getHeaderImage($data);

		$bc = [$data['Industry']['id']];

		$heading = $this->Industry->getValue($bc[0], 'title_' . $this->lang);

		$products = $this->Product->getAllActiveInIndustry($this->lang, $data['Industry']['id']);

		$portfolio = $this->Portfolio->getAllActiveInIndustry($this->lang, $data['Industry']['id']);

		$articles = $this->Article->getAllActiveInIndustry($this->lang, $data['Industry']['id']);

		$robots_noindex = !in_array($this->lang, $data['Industry']['translated'], true);

		$breadcrumbs = $this->Industry->getFullBreadcrumbs($data['Industry']['id'], $this->lang);

		$this->set(compact(
			'data',
			'bc',
			'heading',
			'products',
			'portfolio',
			'articles',
			'page_header_image',
			'robots_noindex',
			'breadcrumbs'
		));

		$this->render('view');
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Industry->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Industry->save($this->request->data)) {
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
			if ($this->Industry->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Industry.id');
		} else {
			$this->request->data = $this->Industry->getOrFail($id);
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
	 * @param bool|null $enabled
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_active(int $id, bool $enabled = null): void {
		$success = $this->Industry->active($id, $enabled);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_moveup(int $id): void {
		$success = $this->Industry->moveup($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_movedown(int $id): void {
		$success = $this->Industry->movedown($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		$this->Industry->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
