<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function admin_login() {
		if( $this->Auth->loggedIn() ){
			return json_encode(array('user' => $this->Session->read("Auth.User"), 'token' => $this->Session->id()));
		} else {
			if( $this->request->is('post') ) {
				$this->request->data['User'] = $this->request->input('json_decode', true);
				if($this->Auth->login()) {
					return json_encode(array('user' => $this->Session->read("Auth.User"), 'token' => $this->Session->id()));
				} else {
					return json_encode(array('error' => 'Email or Passowrd does not match'));
				}
			} else {
				return json_encode(array('error' => 'Authentication failed'));
			}
		}
	}
	

	public function admin_logout() {
		if($this->Auth->logout()) {
			return json_encode(array('success' => 'Logout successfully'));
		} else {
			return json_encode(array('error' => 'Some error ocuured!! Please logout again.'));
		}
	}

	public function admin_index() {
		$this->User->recursive = 1;
		$users = $this->User->find('all');
		return json_encode($users);
	}

	public function admin_view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->User->recursive = -1;
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id), 'fields' => array('id', 'name', 'email', 'status_id'));
		$user = $this->User->find('first', $options);
		return json_encode($user);
	}


	public function admin_register() {
		if ($this->request->is('post')) {
			$this->request->data['User'] = $this->request->input('json_decode', true);
			$this->request->data['User']['status_id'] = 1;
			$this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				if($this->Auth->login($this->request->data)) {
					$user = $this->User->find('first', array('conditions' => array('User.id' => $this->User->getLastInsertID()), 'fields' => array('User.id', 'User.email')));

					return json_encode(array('user' => $user['User'], 'token' => $this->Session->id()));
				} else {
					return json_encode(array('error' => 'Email or Passowrd does not match'));
				}
			} else {
				return json_encode(array('error' => 'User could not be saved. Please, try again.'));
			}
		}
	}


	public function admin_edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['User'] = $this->request->input('json_decode', true);
			if ($this->User->save($this->request->data)) {
				return json_encode($this->User->find('first', array('conditions' => array('User.id' => $id))));
			} else {
				return json_encode(array('error' => 'The User could not be saved. Please, try again.'));
			}
		}
	}
}