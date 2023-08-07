<?php

App::uses('AppController', 'Controller');
App::uses('TrackingView', 'Model');

class TrackingController extends AppController
{
	/**
	 * @var string
	 */
	public $name = 'Tracking';

	/**
	 * @var string[]
	 */
	public $uses = ['Tracking', 'TrackingView', 'TrackingUser', 'Section', 'Product', 'Metatag', 'Portfolio', 'Category', 'Industry', 'Service', 'Article'];

	/**
	 * @throws Exception
	 */
	public function saveclick(): void {
		$controllerInfo = $this->getControllerName($this->request->data['url_path'] ?? '');
		if ($controllerInfo && $controllerInfo['model']) {
			if (!$this->Session->check('uuid')) {
				$this->Session->write('uuid', bin2hex(random_bytes(20)));
			}
			$uuid = $this->Session->read('uuid');
			unset($this->request->data['url_path']);
			$this->request->data['controller'] = $controllerInfo['controller'];
			$this->request->data['model'] = $controllerInfo['model'];
			$this->request->data['strid'] = $controllerInfo['strid'];
			if (strpos($this->request->data['url'], '?') > -1) {
				$this->request->data['url'] = substr($this->request->data['url'], 0, strpos($this->request->data['url'], '?'));
			}

			if (array_key_exists('pdf', $controllerInfo)) {
				$this->request->data['url'] = str_replace('/pdf/', '/', $this->request->data['url']);
			}
			$id = $this->Tracking->firstOrCreate($this->request->data, $this->lang);
			$trackingView = $this->TrackingView->firstOrCreate($id);
			if (array_key_exists('pdf', $controllerInfo)) {
				$this->TrackingView->updateAll(['pdf_download' => ++$trackingView['pdf_download']], ['TrackingView.id' => $trackingView['id']]);
			}
			if (!$this->TrackingUser->hasAny(['views_id' => $trackingView['id'], 'uuid' => $uuid])) {
				$this->TrackingView->updateAll(['views' => ++$trackingView['views']], ['TrackingView.id' => $trackingView['id']]);
				$this->TrackingUser->save([
					'views_id' => $trackingView['id'],
					'uuid' => $uuid
				]);
			}
		}

		$this->jsonSuccess();
	}

	/**
	 * @param string $url
	 *
	 * @return array
	 */
	public function getControllerName(string $url): array {
		if (!$url) {
			return [];
		}

		$langs = array_keys(Configure::read('Languages.all'));
		$pieces = explode('/', $url);

		if ($pieces[0] === 'admin') {
			return [];
		}

		$cleared = false;
		while (!$cleared) {
			if ($pieces[0] === '' || in_array($pieces[0], $langs, true)) {
				array_splice($pieces, 0, 1);
			} else {
				$cleared = true;
			}
		}

		$data = [];

		if (str_contains($pieces[0], 'info')) {
			$data = ['model' => 'Section', 'controller' => 'sections'];
		} elseif (str_contains($pieces[0], 'portfolio')) {
			$data = ['model' => 'Portfolio', 'controller' => 'portfolio'];
		} elseif ((str_contains($pieces[0], 'iekartas')) || (str_contains($pieces[0], 'categories'))) {
			$data = ['model' => 'Category', 'controller' => 'categories'];
		} elseif ((str_contains($pieces[0], 'iekarta')) || (str_contains($pieces[0], 'product'))) {
			$data = ['model' => 'Product', 'controller' => 'products'];
		} elseif ((str_contains($pieces[0], 'industrijas')) || (str_contains($pieces[0], 'industries'))) {
			$data = ['model' => 'Industry', 'controller' => 'industries'];
		} elseif ((str_contains($pieces[0], 'pakalpojumi')) || (str_contains($pieces[0], 'services'))) {
			$data = ['model' => 'Service', 'controller' => 'services'];
		} elseif ((str_contains($pieces[0], 'blogs')) || (str_contains($pieces[0], 'blog')) || (str_contains($url, 'article'))) {
			$data = ['model' => 'Article', 'controller' => 'articles'];
		}
		$data['strid'] = '';
		if (sizeof($pieces) > 1) {
			if ($pieces[1] === 'pdf') {
				$data['pdf'] = true;
				$data['strid'] = strpos($pieces[2], '?') > -1 ? urldecode(substr($pieces[2], 0, strpos($pieces[2], '?'))) : urldecode($pieces[2]);
			} else {
				$data['strid'] = strpos($pieces[1], '?') > -1 ? urldecode(substr($pieces[1], 0, strpos($pieces[1], '?'))) : urldecode($pieces[1]);
			}
		}

		return $data;
	}

	/**
	 * @param string $strid
	 * @param string $lang
	 * @param string $model
	 * @param string $controller
	 *
	 * @return array
	 */
	public function getTrackingData(string $strid, string $lang, string $model, string $controller): array {
		$data = $this->$model->getTrackingData($strid, $lang);
		$meta = $this->Metatag->getData([
			'lang' => $lang,
			'controller' => $controller,
			'action' => 'view',
			'pid' => $data[$model]['id'] ?? null
		], true);

		return ['data' => $data, 'meta' => $meta];
	}

	/**
	 * @param array $item
	 *
	 * @return array
	 */
	public function updateTrackingStats(array $item): array {
		$info = $this->getTrackingData($item['Tracking']['strid'], $item['Tracking']['lang'], $item['Tracking']['model'], $item['Tracking']['controller']);
		$img_count = 0;
		if ($item['Tracking']['model'] === 'Product' && array_key_exists('ProductImage', $info['data'])) {
			$img_count = count($info['data']['ProductImage']);
		} elseif ($item['Tracking']['model'] === 'Portfolio' && array_key_exists('PortfolioImage', $info['data'])) {
			$img_count = count($info['data']['PortfolioImage']);
		}
		$data = [];
		$data['url_id'] = $info['data'][$item['Tracking']['model']]['id'] ?? null;
		$data['img_count'] = $img_count;
		if (array_key_exists('Metatag', $info['meta'])) {
			$data['meta_title'] = "'".$info['meta']['Metatag']['title']."'";
			$data['meta_description'] = "'".$info['meta']['Metatag']['description']."'";
		}
		$this->Tracking->updateAll(
			$data,
			[
				'Tracking.id' => $item['Tracking']['id']
			]
		);

		return $data;
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @return void
	 */
	public function admin_urlstats(): void {
		$search = $this->manageSearchRequest();
		$data = $this->Tracking->adminList($this, 15, $search);
		$all_views = 0;
		$all_form_submits = 0;
		$all_pdf_downloads = 0;
		foreach ($data as $index => $item) {
			if ($this->shouldMergeData($item)) {
				$data[$index]['Tracking'] = array_merge($item['Tracking'], $this->updateTrackingStats($item));
			}
			$previous_views = $this->TrackingView->previousViews($item['Tracking']['id'], $search);
			$data[$index]['Tracking']['previous_views'] = $previous_views[0]['TrackingView']['previous_views'];
			$all_views += $data[$index]['Tracking']['summedViews'];
			$all_form_submits += $data[$index]['Tracking']['summedForms'];
			$all_pdf_downloads += $data[$index]['Tracking']['summedPDF'];
		}
		$this->set(compact('data', 'all_views', 'all_form_submits', 'all_pdf_downloads'));
	}

	/**
	 * @return void
	 */
	public function admin_imagestats(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Tracking->adminList($this, 15, $search, ['Tracking.place', 'Tracking.img'], true);
		foreach ($data as $index => $item) {
			if ($this->shouldMergeData($item)) {
				$data[$index]['Tracking'] = array_merge($item['Tracking'], $this->updateTrackingStats($item));
			}
		}
		$this->set(compact('data'));
	}


	/**
	 * @param $item
	 *
	 * @return bool
	 */
	private function shouldMergeData($item): bool {
		return
			date('Y-m-d', strtotime($item['Tracking']['updated'])) !== date('Y-m-d')
			||
			(
				$item['Tracking']['updated'] === $item['Tracking']['created']
				&& !$item['Tracking']['meta_title']
				&& !$item['Tracking']['meta_description']
			);
	}
}
