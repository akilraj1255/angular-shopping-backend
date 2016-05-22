<?php
App::uses('AppController', 'Controller');
/**
 * Privileges Controller
 *
 * @property Privilege $Privilege
 * @property PaginatorComponent $Paginator
 */
class PrivilegesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Privilege->recursive = 0;
		$this->set('privileges', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Privilege->exists($id)) {
			throw new NotFoundException(__('Invalid privilege'));
		}
		$options = array('conditions' => array('Privilege.' . $this->Privilege->primaryKey => $id));
		$this->set('privilege', $this->Privilege->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Privilege->create();
			if ($this->Privilege->save($this->request->data)) {
				$this->Session->setFlash(__('The privilege has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The privilege could not be saved. Please, try again.'));
			}
		}
		$roles = $this->Privilege->Role->find('list');
		$statuses = $this->Privilege->Status->find('list');
		$this->set(compact('roles', 'statuses'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Privilege->exists($id)) {
			throw new NotFoundException(__('Invalid privilege'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Privilege->save($this->request->data)) {
				$this->Session->setFlash(__('The privilege has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The privilege could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Privilege.' . $this->Privilege->primaryKey => $id));
			$this->request->data = $this->Privilege->find('first', $options);
		}
		$roles = $this->Privilege->Role->find('list');
		$statuses = $this->Privilege->Status->find('list');
		$this->set(compact('roles', 'statuses'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Privilege->id = $id;
		if (!$this->Privilege->exists()) {
			throw new NotFoundException(__('Invalid privilege'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Privilege->delete()) {
			$this->Session->setFlash(__('The privilege has been deleted.'));
		} else {
			$this->Session->setFlash(__('The privilege could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
