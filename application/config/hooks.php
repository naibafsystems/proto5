<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
/*if(ENVIRONMENT == 'dev' || ENVIRONMENT == 'test') {
	// Tiene que estar habilitado save_queries en TRUE en database.php
	$hook['post_system'][] = array(
		'class' => 'QueryLogHook',
		'function' => 'log_queries',
		'filename' => 'QueryLogHook.php',
		'filepath' => 'hooks'
	);
}*/

$hook['post_controller_constructor'] = array(
	'class'    => 'Home',
	'function' => 'check_login',
	'filename' => 'Home.php',
	'filepath' => 'hooks'
);
//EOC