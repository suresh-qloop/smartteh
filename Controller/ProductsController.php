<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Category', 'Model');
App::uses('Industry', 'Model');

/**
 * Products
 */
class ProductsController extends AppController
{
	public $name = 'Products';

	public $uses = ['Product', 'Category', 'Industry', 'Subsection'];

	/**
	 * @param string $strid
	 *
	 * @return void
	 */
	public function view(string $strid): void
	{
		// $this->tempRedirect($this->lang);
		if (empty($strid)) {
			$this->redirect(['controller' => 'industries', 'action' => 'index'], 301);
		}

		$this->redirectFromIdToStrid($this->Product, $strid, 'strid_' . $this->lang);

		$data = $this->Product->getFull($strid, $this->lang);

		if (!$data) {
			$langs = Configure::read('Languages.all');
			unset($langs[$this->lang]);

			foreach (array_keys($langs) as $lang) {
				$data = $this->Product->getFull($strid, $lang);
				if ($data && in_array($this->lang, $data['Product']['translated'], true)) {
					$this->redirect(['action' => 'view', $data['Product']['strid_' . $this->lang]]);
				}
			}

			$this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);
			throw new NotFoundException();
		}

		$from = $this->request->query['from'] ?? '';

		$canonical = $from ? ['controller' => 'products', 'action' => 'view', $strid] : null;
		$robots_noindex = !in_array($this->lang, $data['Product']['translated'], true);

		if (!in_array($from, ['category', 'industry'])) {
			$from = 'category';
		}

		if ($from === 'industry' && $data['Industry']['id']) {
			$bc = [$data['Industry']['id']];
			$heading = $this->Industry->getValue($bc[0], 'title_' . $this->lang);
			$page_header_image = $this->Industry->getHeaderImage($data);
			$breadcrumbs = $this->Industry->getFullBreadcrumbs($data['Industry']['id'], $this->lang);
		} else {
			$bc = $this->Category->getBreadcrumbs($data['Category']['id']);
			$heading = $this->Category->getValue($bc[0], 'title_' . $this->lang);
			$page_header_image = $this->Category->getHeaderImage($data);
			$breadcrumbs = $this->Category->getFullBreadcrumbs($data['Category']['id'], $this->lang);
		}

		$this->set(compact(
			'data',
			'bc',
			'heading',
			'from',
			'page_header_image',
			'canonical',
			'robots_noindex',
			'breadcrumbs'
		));
	}

	/**
	 * Download pdf version of product page
	 *
	 * @param string $strid
	 *
	 * @return void
	 * @throws Exception
	 */
	public function pdf(string $strid): void
	{
		$this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);
		$download = true;

		$data = $this->Product->getFull($strid);

		if (!$data) {
			throw new NotFoundException();
		}

		$html_file = $this->preparePdfFile($data);

		if (!$html_file) {
			throw new RuntimeException('Could not generate/save html file', 1);
		}

		$this->autoRender = false;

		$pdf_file = str_replace('.html', '.pdf', $html_file);

		$xvfb = env('XVFB_PATH');
		if ($xvfb) {
			$wkhtmltopdf = $xvfb . ' --server-args="-screen 0, 1024x768x24" ' . env('WKHTMLTOPDF_PATH');
		} else {
			$wkhtmltopdf = env('WKHTMLTOPDF_PATH');
		}

		// generate pdf
		try {
			$this->execCommand(sprintf(
				'%s --margin-top 10 --margin-right 0 --margin-bottom 15 --margin-left 0 --page-size A4 --disable-smart-shrinking --dpi 300 %s %s',
				$wkhtmltopdf,
				$html_file,
				$pdf_file
			));
		} catch (Exception $e) {
			Utils::deleteNode([$html_file, $pdf_file]);

			if (!is_file($pdf_file)) {
				die($e->getMessage());
			}
		}

		Utils::deleteNode($html_file);

		$filename = $data['Product']['strid_' . $this->lang] . '.pdf';
		if ($download) {
			header('Content-Disposition: attachment; filename="' . $filename . '"');
		} else {
			header('Content-Disposition: inline; filename="' . $filename . '"');
		}

		header('Content-type: application/pdf');
		readfile($pdf_file);

		Utils::deleteNode($pdf_file);
		exit();
	}

	/**
	 * Save html file for pdf generation
	 *
	 * @param array $data
	 *
	 * @return false|string
	 */
	private function preparePdfFile(array &$data)
	{
		$this->autoRender = false;

		$data['Product'] = $this->Product->relativePathsToAbsolute(
			$data['Product'],
			['description_' . $this->lang]
		);

		$filename = APP . 'tmp' . DS . 'generated' . DS . 'products' . DS . str_replace('.', '', microtime(true)) . '.html';

		// main
		$view = new View($this);
		$view->set(compact('data'));
		$output = $view->render('pdf/main', 'pdf/default');
		$html = mb_convert_encoding($output, 'HTML-ENTITIES', 'UTF-8');

		if (!file_put_contents($filename, $html)) {
			return false;
		}

		return $filename;
	}

	/**
	 * Share product via e-mail
	 *
	 * @return void
	 */
	public function share_via_email(): void
	{
		if (!$this->request->is('post')) {
			throw new BadRequestException();
		}

		$id = $this->request->data('Product.id');

		$data = $this->Product->get($id);

		if (!$data || !$data['Product']['enabled']) {
			throw new NotFoundException();
		}

		$this->Product->set($this->request->data);

		if ($this->Product->validates()) {
			$email = $this->request->data('Product.share_email');

			$data['Product'] = $this->Product->relativePathsToAbsolute($data['Product'], ['description_' . $this->lang]);

			$subsection = $this->Subsection->findByTag($this->lang, 'share_product_intro');
			if ($subsection) {
				$subsection = $this->Product->relativePathsToAbsolute($subsection['Subsection'], ['text']);
				$intro = $subsection['text'];
			} else {
				$intro = null;
			}

			$vars = ['data' => $data, 'lang' => $this->lang, 'intro' => $intro];

			$sent = $this->sendEmail([
				'to' => $email,
				'subject' => 'SmartTEH - ' . $data['Product']['title_' . $this->lang],
				'template' => 'product_share'
			], $vars);

			if ($sent) {
				$this->Flash->success(__('E-pasts nosūtīts veiksmīgi.'));
			} else {
				$this->Flash->error(__('Kļūda! E-pasts netika nosūtīts.'));
			}

			$this->log(sprintf('Product #%s shared with %s. Status: %s', $id, $email, ($sent ? 'OK' : 'ERR')), 'info');
		} else {
			$error = current($this->Product->validationErrors['share_email']);
			$this->Flash->error($error);
		}

		$this->redirect($this->referer());
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_index(): void
	{
		$search = $this->manageSearchRequest();

		$data = $this->Product->adminList($this, 15, $search);

		$this->set(compact('data'));
	}

	/**
	 * @return void
	 */
	public function admin_create(): void
	{
		if ($this->request->is('post')) {
			$this->request->data['Product']['lang'] = $this->lang;

			if ($this->Product->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		}

		$list_categories = $this->Category->findThreadedList(null, 'title_' . $this->lang);
		$list_industries = $this->Industry->findList('title_' . $this->lang);
		$this->set(compact('list_categories', 'list_industries'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_update(int $id): void
	{
		if ($this->request->is(['post', 'put'])) {
			if ($this->Product->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$id = (int)$this->request->data('Product.id');
		} else {
			$this->request->data = $this->Product->getOrFail($id);
		}

		$list_categories = $this->Category->findThreadedList(null, 'title_' . $this->lang);
		$list_industries = $this->Industry->findList('title_' . $this->lang);
		$this->set(compact('list_categories', 'list_industries', 'id'));
	}

	/**
	 * Duplicate existing item
	 *
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_duplicate(int $id): void
	{
		$new_id = $this->Product->duplicate($id);

		if ($new_id) {
			$this->Flash->success(__d('admin', 'MSG_OK'));
			$this->redirect(['action' => 'update', $new_id]);
		} else {
			$this->Flash->error(__d('admin', 'MSG_ERR'));
		}

		$this->redirect($this->referer());
	}

	/**
	 * Update metatags
	 *
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
		$success = $this->Product->active($id, $enabled);
		$this->actionResponse($success);
	}

	/**
	 * @param int|null $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void
	{
		$this->Product->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
