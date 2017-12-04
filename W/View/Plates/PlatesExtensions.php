<?php

namespace W\View\Plates;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * @link http://platesphp.com/engine/extensions/ Plates documentation
 */
class PlatesExtensions implements ExtensionInterface{

	/**
	 * Saves new functions to Plates
     * @param \League\Plates\Engine $engine Instance of the Plates engine
	 */
    public function register(Engine $engine){

        $engine->registerFunction('assetUrl', [$this, 'assetUrl']);
        $engine->registerFunction('url', [$this, 'generateUrl']);
        $engine->registerFunction('translate', [$this, 'translate']);

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
     * Returns the asset URL
     * @param string $path The path to the file, relative to public/assets/
     * @return string The asset URL
     */
    public function assetUrl($path){

        $app = getApp();
        return $app->getBasePath() . '/assets/' . ltrim($path, '/');

    }


    /**
     * Creates URL from route name
     * @param string $routeName Route name
     * @param mixed $params Array of parameters for the route
     * @param boolean $absolute If true, returns an absolute URL
     * @return L'URL correspondant à la route
     */
    public function generateUrl($routeName, $params = array(), $absolute = false){

    	return \W\Controller\Controller::generateUrl($routeName, $params, $absolute);

    }

}
