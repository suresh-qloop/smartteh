<?php

App::uses('AppController', 'Controller');
App::uses('Article', 'Model');

/**
 * Articles
 */
class ArticlesController extends AppController
{
	public $name = 'Articles';

	public $uses = ['Article', 'Industry', 'Theme'];

	/**
	 * @return void
	 */
	public function index(string $strid = null): void {
		$conditions = [];
		$active = '';
		if (!empty($strid)) {
			$theme = $this->Theme->findByStrid($strid, $this->lang);
			if (!$theme) {
				$langs = Configure::read('Languages.all');
				unset($langs[$this->lang]);

				foreach (array_keys($langs) as $lang) {
					$theme = $this->Theme->findByStrid($strid, $lang);
					if ($theme) {
						$this->redirect(['action' => 'index', $theme['Theme']['strid_'.$this->lang]], 301);
					}
				}

				throw new NotFoundException();
			}
			$conditions = ['theme_id' => $theme['Theme']['id']];
			$active = $theme['Theme']['id'];
		}

		$data = $this->Article->findAll($this, 5, $conditions);
		$theme_list = $this->Theme->findAllActive();
		$urls = Sitemap::getLanguageUrls('articles');
		$this->set(compact('data', 'theme_list', 'active', 'urls'));
	}

	/**
	 * @param string|null $strid
	 *
	 * @return void
	 */
	public function view(string $strid = null): void {
		if (empty($strid)) {
			$this->redirect(['controller' => 'articles', 'action' => 'index'], 301);
		}

		$this->redirectFromIdToStrid($this->Article, $strid, 'strid_'.$this->lang);

		$data = $this->Article->findByStrid($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Article->findByStrid($strid, $lang);
				if ($data && in_array($this->lang, $data['Article']['translated'], true)) {
					$this->redirect(['action' => 'view', $data['Article']['strid_'.$this->lang]]);
				}
			}

			throw new NotFoundException();
		}

		$breadcrumbs = $this->Article->getFullBreadcrumbs($data['Article']['id'], $this->lang);
		$urls = Sitemap::getLanguageUrls('articles', $this->lang, $strid, 'Article');
		$this->set(compact('data', 'breadcrumbs', 'urls'));
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Article->adminList($this, 20, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function admin_create(): void {
		if ($this->request->is('post')) {
			if ($this->Article->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		} else {
			$this->request->data['Article']['date'] = date('Y-m-d');
		}

		$list_industries = $this->Industry->findList('title_'.$this->lang);
		$list_articles = $this->Article->findList('title_'.$this->lang, null, ['JSON_CONTAINS(`translated`, \'"'.$this->lang.'"\', "$")']);
		$list_themes = $this->Theme->findList('title_'.$this->lang, null);
		$this->set(compact('list_industries', 'list_articles', 'list_themes'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_update(int $id): void {
		if ($this->request->is(['post', 'put'])) {
			if ($this->Article->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Article.id');
		} else {
			$this->request->data = $this->Article->getOrFail($id);
		}

		$list_industries = $this->Industry->findList('title_'.$this->lang);
		$list_articles = $this->Article->findList('title_'.$this->lang, null, ['JSON_CONTAINS(`translated`, \'"'.$this->lang.'"\', "$")']);
		$list_themes = $this->Theme->findList('title_'.$this->lang, null);
		$this->set(compact('id', 'list_industries', 'list_articles', 'list_themes'));
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
		$success = $this->Article->active($id, $enabled);
		$this->actionResponse($success);
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		$this->Article->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
