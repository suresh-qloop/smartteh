<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

use Devio\Pipedrive\Pipedrive;

/**
 * Callbacks
 */
class CallbacksController extends AppController
{
	public $name = 'Callbacks';

	public $uses = ['Callbacks', 'Setting'];

	/**
	 * @return void
	 */
	public function index(): void {
		if (!$this->request->is('post')) {
			throw new BadRequestException();
		}
		
		$existing = $this->Callbacks->find('first', [
			'conditions' => ['request_hash' => $this->request->data('Callbacks.request_hash')]
		]);

		$pipedrive = new Pipedrive(PIPEDRIVE_KEY);

		$response = $pipedrive->deals->add([
			'title' => $this->request->data('Callbacks.name'), // Deal title
			'd70ec9ad9023ae81e7d60f7c0f7aac704d093180' => $this->request->data('Callbacks.phone'), // phone no field
			'7d3852b061e86a3770e2eec0d3c0a4203a638436' => $this->request->data('Callbacks.question'), // question field
			// 'value' => 0, // Phone numbers
		]);

		if (!$existing && $this->Callbacks->save($this->request->data)) {

			// $this->redirect(['controller' => 'start', 'action' => 'index', 'lang' => $this->lang]);

			$this->notifyAdminViaEmail($this->Callbacks->id);

			if (!env('APP_DEBUG')) {
				$this->Callbacks->sendToAmoCrm($this->Callbacks->id);
			}

			$this->set(['success' => true, 'hash' => md5(Utils::uuid4())]);
		} else {
			$this->set('error', $this->Callbacks->validationErrors);
		}

		setcookie('helpbox', 'minimized', time() + 950000000); // ~ 1 year
		unset($this->request->data);

		//render spacial view for ajax
		$this->render('ajax_response', 'ajax');
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

		$data = $this->Callbacks->getOrFail($id, ['Product']);
		$vars = ['data' => $data];

		$this->sendEmail([
			'to' => $to,
			'subject' => 'Atzvanīt ziņa',
			'template' => 'callbacks',
			'transactional' => true
		], $vars);
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	/**
	 * @param int|null $id
	 *
	 * @return void
	 */
	public function admin_view(int $id): void {
		$data = $this->Callbacks->getOrFail($id, ['Product']);
		$this->set(compact('data', 'id'));
	}

	/**
	 * @return void
	 */
	public function admin_index(): void {
		$search = $this->manageSearchRequest();
		$data = $this->Callbacks->adminList($this, 20, $search);
		$this->set(compact('data'));
	}

	/**
	 * @param int|null $id
	 */
	public function admin_finished($id = null) {
		$success = $this->Callbacks->finished($id);
		$this->actionResponse($success);
	}

	/**
	 * @param int|null $id
	 *
	 * @return void
	 */
	public function admin_delete($id = null): void {
		$this->Callbacks->delete($id);
		$this->actionResponse(true, ['action' => 'index']);
	}
}
