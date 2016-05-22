<?php	
	class DetailsController extends AppController {

		public function admin_edit($id = null){
			if (!$this->Detail->exists($id)) {
				throw new NotFoundException(__('Invalid Detail'));
			}
			if ($this->request->is(array('post', 'put'))) {
				$this->request->data['Detail'] = $this->request->input('json_decode', true);
				if ($this->Detail->save($this->request->data)) {
					return json_encode(array('success' => 'Details have been saved.'));
				} else {
					return json_encode(array('error' => 'Details could not be saved. Please, try again.'));
				}
			}
		}

		public function admin_view($id = null) {
			if (!$this->Detail->exists($id)) {
				throw new NotFoundException(__('Invalid Detail'));
			}
			return json_encode($this->Detail->findById($id));
		}
	}
?>