<?php

namespace Sf2apiBundle\Services;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class Sf2PasswordEncoder implements PasswordEncoderInterface {

	const SALT = 'saltcomeshere';

	public function encodePassword($raw, $salt) {
		return sha1($raw . self::SALT);
	}

	public function isPasswordValid($encoded, $raw, $salt = NULL) {
		return ($encoded===(sha1($raw . self::SALT)));
	}
}

