<?php

namespace W\Security;

/**
 * Useful security functions
 */
class StringUtils{

	/**
	 * Generate a random string
	 * @param integer $length length of string
	 * @return string $string generated string
	 */
	public static function randomString($length = 80){

		$possibleChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
        $factory = new \RandomLib\Factory;
		$generator = $factory->getGenerator(new \SecurityLib\Strength(\SecurityLib\Strength::MEDIUM));
		$string = $generator->generateString($length, $possibleChars);

        return $string;

	}

}
