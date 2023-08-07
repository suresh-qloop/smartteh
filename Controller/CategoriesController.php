<?php

App::uses('AppController', 'Controller');
App::uses('Category', 'Model');

/**
 * Categories
 */
class CategoriesController extends AppController
{
	public $name = 'Categories';

	public $uses = ['Category', 'Product'];

	/**
	 * @return void
	 */
	public function index(): void
	{
		$data = $this->Category->getFirst();

		if (!$data) {
			throw new NotFoundException();
		}

		$this->redirect(['action' => 'view', $data['Category']['strid_' . $this->lang]], 301);
	}

	/**
	 * @param string $strid
	 *
	 * @return void
	 */
	public function view(string $strid): void
	{
		// $this->tempRedirect($this->lang);
		$this->redirectFromIdToStrid($this->Category, $strid, 'strid_' . $this->lang);

		$data = $this->Category->findByStrid($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Category->findByStrid($strid, $lang);
				if ($data && in_array($this->lang, $data['Category']['translated'], true)) {
					$this->redirect(['action' => 'view', $data['Category']['strid_' . $this->lang]]);
				}
			}

			$this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);
			// throw new NotFoundException();
		}

		$page_header_image = $this->Category->getHeaderImage($data);

		$bc = $this->Category->getBreadcrumbs($data['Category']['id']);
		$heading = $this->Category->getValue($bc[0], 'title_' . $this->lang);

		$subcategories = $this->Category->getChildren($data['Category']['id']);
		$products = $this->Product->getAllActiveInCategory($this->lang, $data['Category']['id']);

		$robots_noindex = !in_array($this->lang, $data['Category']['translated'], true);

		$breadcrumbs = $this->Category->getFullBreadcrumbs($data['Category']['id'], $this->lang);

		$this->set(compact(
			'data',
			'bc',
			'heading',
			'subcategories',
			'products',
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
	public function admin_index(): void
	{
		$data = $this->Category->threadedToFlat(
			$this->Category->findAllThreaded($this->lang, true)
		);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void
	{
		if ($this->request->is('post')) {
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		}

		$list_categories = $this->Category->findThreadedList(null, 'title_' . $this->lang);
		$this->set(compact('list_categories'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_update(int $id): void
	{
		if ($this->request->is(['post', 'put'])) {
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Category.id');
		} else {
			$this->request->data = $this->Category->getOrFail($id);
		}

		$list_categories = $this->Category->findThreadedList(null, 'title_' . $this->lang);
		$this->set(compact('list_categories', 'id'));
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
	 * @param bool|null $enabled
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_active(int $id, bool $enabled = null): void
	{
		$success = $this->Category->active($id, $enabled);
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
		$success = $this->Category->moveup($id, ['parent_id']);
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
		$success = $this->Category->movedown($id, ['parent_id']);
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
		$this->Category->deleteThreaded($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
