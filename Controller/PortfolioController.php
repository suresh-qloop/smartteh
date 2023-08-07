<?php

App::uses('AppController', 'Controller');
App::uses('Portfolio', 'Model');

/**
 * Portfolio
 */
class PortfolioController extends AppController
{
	public $name = 'Portfolio';

	public $uses = ['Portfolio', 'Industry'];

	/**
	 * @return void
	 */
	public function index(): void
	{

		$data = $this->Portfolio->findAll($this, 5);

		$this->set(compact('data'));
	}

	/**
	 * @param string $strid
	 *
	 * @return void
	 */
	public function view(string $strid): void
	{
		// $this->tempRedirect($this->lang);
		if (empty($strid)) {
			$this->redirect(['controller' => 'portfolio', 'action' => 'index'], 301);
		}

		$this->redirectFromIdToStrid($this->Portfolio, $strid, 'strid_' . $this->lang);

		$data = $this->Portfolio->findByStrid($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Portfolio->findByStrid($strid, $lang);
				if ($data && in_array($this->lang, $data['Portfolio']['translated'], true)) {
					$this->redirect(['action' => 'view', $data['Portfolio']['strid_' . $this->lang]]);
				}
			}

			$this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);
			// throw new NotFoundException();
		}

		$this->set(compact('data'));
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void
	{
		$search = $this->manageSearchRequest();

		$data = $this->Portfolio->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void
	{
		if ($this->request->is('post')) {
			if ($this->Portfolio->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} else {
			$this->request->data['Portfolio']['date'] = date('Y-m-d');
		}

		$list_industries = $this->Industry->findList('title_' . $this->lang);
		$this->set(compact('list_industries'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_update(int $id): void
	{
		if ($this->request->is(['post', 'put'])) {
			if ($this->Portfolio->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Portfolio.id');
		} else {
			$this->request->data = $this->Portfolio->getOrFail($id);
		}

		$list_industries = $this->Industry->findList('title_' . $this->lang);
		$this->set(compact('id', 'list_industries'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_metatags(int $id): void
	{
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
	 * @param bool $enabled
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_active(int $id, bool $enabled): void
	{
		$success = $this->Portfolio->active($id, $enabled);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_moveup(int $id): void
	{
		$success = $this->Portfolio->moveup($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_movedown(int $id): void
	{
		$success = $this->Portfolio->movedown($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void
	{
		$this->Portfolio->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
