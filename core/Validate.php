<?php

namespace app\core;

class Validate
{
	public static function isNameValid($name): bool
	{
		if (preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name)) {
			$valid = true;
		} else {
			$valid = false;
		}

		return $valid;
	}

	public static function isEmailValid($email): bool
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$valid = true;
		} else {
			$valid = false;
		}
		return $valid;
	}
}
