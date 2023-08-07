<?php

App::uses('AppController', 'Controller');

/**
 * Administrators
 */
class AdminsController extends AppController
{
	public $name = 'Admins';

	public $uses = ['Admin'];

	public $components = [];

	// page, that should be opened after successfull login
	public $landing_page = ['admin' => true, 'controller' => 'sections', 'action' => 'index'];

	/**
	 * If admin is already logged in, redirect to landing page, otherwise redirect
	 * to login page
	 */
	public function index() {
		if ($this->Session->check('Admin')) {
			$this->redirect($this->landing_page);
		}

		$this->redirect(['action' => 'login']);
	}

	/**
	 * Login admin
	 */
	public function login() {
		if ($this->Session->check('Admin')) {
			$this->redirect($this->landing_page);
		}

		if ($this->request->is('post')) {
			$data = $this->Admin->checkLoginCredentials(
				$this->request->data['Admin']['username'],
				$this->request->data['Admin']['password']
			);

			if ($data) {
				$this->Session->write('Admin', $data['Admin']);

				$redirect = $this->Session->read('admin_redirect');
				if ($redirect) {
					$this->Session->delete('admin_redirect');
					$this->redirect($redirect);
				}

				if ($this->request->data['Admin']['password'] == '123') {
					$this->Flash->error(__d('admin', 'Please change your password'));
					$this->redirect(['admin' => true, 'action' => 'passwd']);
				}

				$this->redirect($this->landing_page);
			} else {
				$this->redirect($this->referer());
			}
		}

		$this->layout = 'admin/login';
	}

	/**
	 * Logout admin
	 */
	public function logout() {
		$this->Session->delete('Admin');
		$this->redirect(['controller' => 'start', 'action' => 'index']);
	}

	// ~~~ Administration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public function admin_index(): void {
		$search = $this->manageSearchRequest();

		$data = $this->Admin->adminList($this, 20, $search);

		$this->set('data', $data);
	}

	/**
	 * Create new admin
	 *
	 * Access: root
	 */
	public function admin_create(): void {
		if (!$this->Session->read('Admin.root')) {
			$this->redirect($this->referer());
		}

		if ($this->request->is('post')) {
			if ($this->Admin->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}
		}
	}

	/**
	 * Update existing admin
	 *
	 * Root can update any admin
	 */
	public function admin_update(int $id): void {
		if ($this->request->is(['post', 'put'])) {
			if (!$this->Session->read('Admin.root') && $this->request->data['Admin']['id'] != $this->Session->read('Admin.id')) {
				$this->redirect($this->referer());
			}

			if (isset($this->request->data['Admin']['root'])) {
				unset($this->request->data['Admin']['root']);
			}

			if ($this->Admin->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__d('admin', 'MSG_ERR'));
			}

			$data = $this->Admin->getOrFail($this->request->data['Admin']['id']);
		} else {
			$this->request->data = $this->Admin->getOrFail($id);
			$data = $this->request->data;
		}

		$id = $data['Admin']['id'];

		$this->set(compact('data', 'id'));
	}

	/**
	 * Change password
	 *
	 * Root can change every admin's password
	 */
	public function admin_passwd($id = null) {
		if ($this->request->is(['post', 'put'])) {
			if (!$this->Session->read('Admin.root')) {
				$this->request->data['Admin']['id'] = $this->Session->read('Admin.id');
			}

			if ($this->Admin->save($this->request->data)) {
				$this->Flash->success(__d('admin', 'MSG_OK'));
				$this->redirect(['action' => 'index']);
			}
		} else {
			if (empty($id) || !$this->Session->read('Admin.root')) {
				$id = $this->Session->read('Admin.id');
			}

			$this->request->data = $this->Admin->get($id);
		}
	}

	/**
	 * Delete admin
	 *
	 * Root can delete any admin
	 *
	 * Standart admin can delete only himself
	 */
	public function admin_delete(int $id): void {
		if (!$this->Session->read('Admin.root') && $this->Session->read('Admin.id') != $id) {
			$this->redirect($this->referer());
		}

		$success = $this->Admin->delete($id);

		if ($success && $this->Session->read('Admin.id') == $id) {
			$this->logout();
		}

		$this->actionResponse($success, ['action' => 'index']);
	}
}
