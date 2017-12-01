<?php

// Global namespace
namespace {

	/**
	 * print_r with easier display
	 * @param mixed $var La variable a déboger
	 */
	function debug($var){

		echo '<pre style="padding: 10px; font-family: Consolas, Monospace; background-color: #000; color: #FFF;">';
		print_r($var);
		echo '</pre>';

	}

	/**
	 * Returns the application instance from the global namespace
	 * @return \W\App
	 */
	function getApp(){

		if (!empty($GLOBALS['app'])){
			return $GLOBALS['app'];
		}

		return null;

	}

	/**
	 * Return text from default.php (default) or another file in 'assets/translations/', depending on the language in the URL
	 * @param string $key Array key in the translation file from which to choose the correct translation
	 * @param string $file Name of the file containing the translations, 'default' by default
	 */
	function translate($key, $file='default'){

		require dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'htdocs' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR . $file . '.php';

		return $default_translations[$key][substr($_SERVER['REQUEST_URI'], 1, 2)];

	}

	/**
	* Transforms string into camel case
	* Removes blanks and hyphens
	* @param  string $string
	* @return string
	*/
	function toCamelCase($string){

		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

	}

}
