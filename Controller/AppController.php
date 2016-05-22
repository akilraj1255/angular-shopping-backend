<?php
class AppController extends Controller {	
	public $components = array(
								'Session','Cookie','Email',
								'Auth' => array(
									'authenticate' => array(
										'Form' => array(
											'fields' => array('username' => 'email'),
											'scope' => array('User.status_id' => 1)
										)
									)
								)
						 );
	
	public function beforeFilter() {
		$this->autoRender = false;
		if (isset($this->params['admin']) && $this->params['admin']) {
			if($this->request->action != 'admin_login' && $this->request->action != 'admin_register' && $this->request->header('X-CSRF-Token') != $this->Session->id()) {
				$this->Auth->logout();
				throw new ForbiddenException(__("You don't have permission to access the url."));
			}
			$this->Auth->allow('admin_login', 'admin_register');
		} else {
			$this->Auth->allow();
		}
	}

	public function beforeRender() {
		$this->response->disableCache();
	}
}