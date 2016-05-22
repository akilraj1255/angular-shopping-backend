<?php
App::uses('AppController', 'Controller');
/**
 * Subcategories Controller
 *
 * @property Subcategory $Subcategory
 * @property PaginatorComponent $Paginator
 */
class SubcategoriesController extends AppController {

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
		$this->Subcategory->recursive = 0;
		$this->set('subcategories', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
		$this->set('subcategory', $this->Subcategory->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Subcategory->create();
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subcategory could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Subcategory->Category->find('list');
		$statuses = $this->Subcategory->Status->find('list');
		$this->set(compact('categories', 'statuses'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subcategory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
			$this->request->data = $this->Subcategory->find('first', $options);
		}
		$categories = $this->Subcategory->Category->find('list');
		$statuses = $this->Subcategory->Status->find('list');
		$this->set(compact('categories', 'statuses'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Subcategory->id = $id;
		if (!$this->Subcategory->exists()) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Subcategory->delete()) {
			$this->Session->setFlash(__('The subcategory has been deleted.'));
		} else {
			$this->Session->setFlash(__('The subcategory could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
