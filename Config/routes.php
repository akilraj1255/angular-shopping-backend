<?php
	Router::connect('/', array('controller' => 'pages', 'action' => 'index'));

	/*Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));*/

	Router::connect('/admin', array('prefix' => 'admin', 'admin' => true));

	CakePlugin::routes();

	require CAKE . 'Config' . DS . 'routes.php';
