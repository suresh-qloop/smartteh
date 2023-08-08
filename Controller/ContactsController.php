<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Contacts
 */
class ContactsController extends AppController
{
	public $name = 'Contacts';

	public $uses = ['Contacts', 'Setting', 'Tracking', 'TrackingView'];

	/**
	 * @return void
	 */
	public function index(): void {
		if (!$this->request->is('post')) {
			throw new BadRequestException();
		}
		$page_url = $this->request->data('Contacts.page_url');
		unset($this->request->data['Contacts']['page_url']);
		$existing = $this->Contacts->find('first', [
			'conditions' => ['request_hash' => $this->request->data('Contacts.request_hash')]
		]);

		if (!$existing && $this->Contacts->save($this->request->data)) {
			$this->notifyAdminViaEmail($this->Contacts->id);

			if (!env('APP_DEBUG')) {
				$this->Contacts->sendToAmoCrm($this->Contacts->id);
			}

			$this->set(['success' => true, 'hash' => md5(Utils::uuid4())]);
		} else {
			$this->set('error', $this->Contacts->validationErrors);
		}

		setcookie('helpbox', 'minimized', time() + 950000000); // ~ 1 year
		unset($this->request->data);

		$this->updateFormSubmitTracking($page_url);

		if ($this->request->is('ajax')) {
			//render spacial view for ajax
			$this->render('ajax_response', 'ajax');
		} else {
			$this->set('done', true);
		}
	}

	public function updateFormSubmitTracking(string $url): bool {
		$data['img'] = '';
		$data['url'] = $url;
		if (strpos($url, "?") > -1) {
			$data['url'] = substr($url, 0, strpos($url, "?"));
		}
		$id = $this->Tracking->find('first', [
			'conditions' => [$data],
			'fields' => ['id']
		]);
		if ($id) {
			$trackingView = $this->TrackingView->firstOrCreate($id['Tracking']['id']);
			$this->TrackingView->updateAll(['form_submit' => ++$trackingView['form_submit']], ['TrackingView.id' => $trackingView['id']]);
		}

		return true;
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	private function notifyAdminViaEmail(int $id): void {
		$to = $this->Setting->getValue('contacts-email', 'value');

		if (!$to) {
			return;
		}

		$data = $this->Contacts->getOrFail($id, ['Product']);
		$vars = ['data' => $data];

		$this->sendEmail([
			'to' => $to,
			'subject' => 'Kontaktformas ziņa',
			'template' => 'contacts',
			'transactional' => true
		], $vars);
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function admin_view(int $id): void {
		$data = $this->Contacts->getOrFail($id, ['Product']);
		$this->set(compact('data', 'id'));
	}

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();
		$data = $this->Contacts->adminList($this, 20, $search);
		$this->set(compact('data'));
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 * @throws Exception
	 */
	public function admin_delete(int $id): void {
		$this->Contacts->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
