<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\ExampleModel;

class ExampleController extends Controller{


	/**
	 * Show home page
	 */
	public function homePage(){

		// Show page
		$this->show('main/home');

	}

	/**
	 * Show example page
	 */
	public function examplePage($lang){

		// Do something with the Model
		// $exampleModel = new ExampleModel();
		// $exampleModel->find($id);

		// Show page
		$this->show('main/example', array(
			'lang'=> $lang
		));

	}


}
