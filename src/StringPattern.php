<?php

namespace Src;

use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

final class StringPattern
{
	const OPEN_PARENTHESES = '(';
	const CLOSE_PARENTHESES = ')';
	const OPEN_BRACKETS = '[';
	const CLOSE_BRACKETS = ']';
	const OPEN_BRACES = '{';
	const CLOSE_BRACES = '}';

	public function isValid($s)
	{
		if (!$this->checkValidation($s)) {
			return false;
		}

		$a_string = str_split($s, 1);
		$open_key = '';
		$open = '';
		foreach ($a_string as $key => $c_curr) {
			if ($this->isOpen($c_curr)) {
				$open_key = $key;
				$open = $c_curr;
			} else {
				if (!$this->matchStrings($open, $c_curr)) {
					return false;
				}
				unset($a_string[$open_key], $a_string[$key]);
				reset($a_string);
				if (count($a_string) !== 0) {
					$new_string = implode($a_string);
					return $this->isValid($new_string);
				}
				break;
			}
		}

		return true;
	}

	private function checkValidation($s)
	{
		$s_length = strlen($s);

		if ($s_length < 1 || $s_length > 104) {
			return false;
		}

		if ($s_length % 2 !== 0) {
			return false;
		}

		$s_first = substr($s, 0, 1);

		if ($this->isClose($s_first)) {
			return false;
		}

		if (!$this->isOpen($s_first) && !$this->isClose($s_first)) {
			return false;
		}

		return true;
	}

	private function isOpen($ch): bool
	{
		return ($ch === self::OPEN_PARENTHESES || $ch === self::OPEN_BRACKETS || $ch === self::OPEN_BRACES);
	}

	private function isClose($ch): bool
	{
		return ($ch === self::CLOSE_PARENTHESES || $ch === self::CLOSE_BRACKETS || $ch === self::CLOSE_BRACES);
	}

	private function matchStrings($open, $close): bool
	{
		return ($open === self::OPEN_PARENTHESES && $close === self::CLOSE_PARENTHESES)
			|| ($open === self::OPEN_BRACKETS && $close === self::CLOSE_BRACKETS)
			|| ($open === self::OPEN_BRACES && $close === self::CLOSE_BRACES);
	}
}
