<?php

// Saves language in cookie for 30 days
// Use urls in the form http://something.com/fr/page/ where fr is the language in 2 letter format.
// $cookie_name = 'w_language';
// $cookie_value = substr($_SERVER['REQUEST_URI'], 1, 2);
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/');

// Classes autoload
require '../vendor/autoload.php';

// Config
require '../app/config.php';

// Global functions
require '../W/globals.php';


// Create application
$app = new W\App($w_routes, $w_config);

// Launch application
$app->run();
