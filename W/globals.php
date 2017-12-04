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
	* Transforms string into camel case
	* Removes blanks and hyphens
	* @param  string $string
	* @return string
	*/
	function toCamelCase($string){

		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

	}

}
