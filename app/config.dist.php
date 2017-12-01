<?php

$w_config = [
   	// DB connexion info
	'db_host' => 'localhost',
    'db_user' => 'root',
    'db_pass' => '',
    'db_name' => '',
    'db_table_prefix' => '',

	// Authentification, autorisation
	'security_user_table' => 'users',
	'security_id_property' => 'id',
	'security_username_property' => 'username',
	'security_email_property' => 'email',
	'security_password_property' => 'password',
	'security_role_property' => 'role',

	'security_login_route_name' => 'login',

	// Global config
	'site_name'	=> '',
];

require('routes.php');
