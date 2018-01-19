<?php
	//Constantes
	$configs = new HXPHP\System\Configs\Config;

	$configs->env->add('development');

	$configs->env->development->baseURI = '/ProtocoloSistema/';

	$configs->env->development->database->setConnectionData(array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'dbname' => 'sistemahx'
	));

	$configs->env->development->auth->setURLs('/ProtocoloSistema/home/', '/ProtocoloSistema/login/');

	$configs->env->development->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home',
		'Editar perfil/cog' => '%baseURI%/perfil/editar',
		'Sair/sign-out' => '%baseURI%/login/sair',
	), 'user');

	$configs->env->development->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home',
		'Usuários/users' => '%baseURI%/usuarios',
		'Editar perfil/cog' => '%baseURI%/perfil/editar',
		'Sair/sign-out' => '%baseURI%/login/sair'
	), 'administrator');

	$configs->env->development->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home'
	));

	$configs->env->development->menu->setConfigs(array(
		'container' => 'nav',
		'container_class' => 'navbar navbar-default',
		'menu_class' => 'nav navbar-nav'
	));

	$configs->env->add('production');

	$configs->env->production->baseURI = '/';

	$configs->env->production->database->setConnectionData(array(
		'host' => 'localhost',
		'user' => 'hxphp190_sistema',
		'password' => '^EKI1LK(&kV[',
		'dbname' => 'hxphp190_sistemahx'
	));

	$configs->env->production->auth->setURLs('/home/', '/login/');

	$configs->env->production->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home',
		'Editar perfil/cog' => '%baseURI%/perfil/editar',
		'Sair/sign-out' => '%baseURI%/login/sair',
	), 'user');

	$configs->env->production->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home',
		'Usuários/users' => '%baseURI%/usuarios',
		'Editar perfil/cog' => '%baseURI%/perfil/editar',
		'Sair/sign-out' => '%baseURI%/login/sair'
	), 'administrator');

	$configs->env->production->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home'
	));

	$configs->env->production->menu->setConfigs(array(
		'container' => 'nav',
		'container_class' => 'navbar navbar-default',
		'menu_class' => 'nav navbar-nav'
	));

	return $configs;
