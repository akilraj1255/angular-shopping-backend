<?php
App::uses('AppController', 'Controller');

class PagesController extends AppController {

	public function admin_index() {
		$this->Page->recursive = 0;
		$pages = $this->Page->find('all');
		return json_encode($pages);
	}

	public function admin_view($id = null) {
		if (!$this->Page->exists($id)) {
			throw new NotFoundException(__('Invalid page'));
		}
		$options = array('conditions' => array('Page.' . $this->Page->primaryKey => $id));
		return json_encode($this->Page->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->request->data['Page'] = $this->request->input('json_decode', true);
			$this->Page->create();
			if ($this->Page->save($this->request->data)) {
				return json_encode(array('success' => 'Page has been saved.'));
			} else {
				return json_encode(array('error' => 'Page could not be saved. Please, try again.'));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$this->Page->exists($id)) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Page'] = $this->request->input('json_decode', true);
			if ($this->Page->save($this->request->data)) {
				return json_encode(array('success' => 'Page has been saved.'));
			} else {
				return json_encode(array('error' => 'Page could not be saved. Please, try again.'));
			}
		}
	}

	public function admin_delete($id = null) {
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Page->delete()) {
			return json_encode(array('success' => 'Page has been deleted.'));
		} else {
			return json_encode(array('error' => 'Page could not be deleted. Please, try again.'));
		}
	}

	public function admin_setstatus($id = null, $status = null) {
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid Page'));
		}
		if ($this->Page->save(array('status_id' => $status))) {
			return json_encode(array('success' => 'Page has been saved.'));
		} else {
			return json_encode(array('error' => 'Page could not be saved. Please, try again.'));
		}
	}
}
