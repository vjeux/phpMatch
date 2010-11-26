<?php
/*
	phpMatch by vjeux, November 2010
	<vjeuxx@gmail.com> http://blog.vjeux.com/

	preg_match helpers to make it more user friendly
*/

/* 
	Helper for preg_match_all

	Takes
	 - str: the string to execute the search on
	 - regex: the regular expression to match
		Captured elements **must be named** (?P<name>pattern)
		` is automatically used as regex escaping character
		\n and \t are trimmed (not spaces!)
		Multiple line environment
	
	Return
	 - array of associative arrays
*/

function match_all($str, $regex, $trim = true) {
	$regex = '`' . $regex . '`ms';
	if ($trim) {
		$regex = str_replace(array("\n", "\t"), '', $regex);
	}
	preg_match_all($regex, $str, $result, PREG_SET_ORDER);

	for ($i = 0; $i < count($result); ++$i) {
		for ($j = 0; array_key_exists($j, $result[$i]); ++$j) {
			unset($result[$i][$j]);
		}
	}

	return $result;
}

/* 
	Helper for preg_match

	Takes
	 - str: the string to execute the search on
	 - regex: the regular expression to match
		` is automatically used as regex escaping character
		\n and \t are trimmed (not spaces!)
		Multiple line environment
	
	Return
	 - false: is nothing is matched
     - string: if there's one non-named captured element
	 - associative array: if there are named captured elements
	 - array: all the captured elements
*/

function match($str, $regex, $trim = true) {
	$regex = '`' . $regex . '`ms';
	if ($trim) {
		$regex = str_replace(array("\n", "\t"), '', $regex);
	}
	$found = preg_match($regex,	$str, $result);
	if (!$found) {
		return $found;
	}

	// If there are named keys, remove all the integer keys
	$is_digit = true;
	foreach ($result as $key => $values) {
		if (!is_numeric($key)) {
			$is_digit = false;
			break;
		}
	}
	if (!$is_digit) {
		for ($j = 0; array_key_exists($j, $result); ++$j) {
			unset($result[$j]);
		}
	}

	else {
		// Remove the matched string, we want only the captured results
		array_shift($result);

		// If there's a single key, return it
		if (count($result) == 1) {
			$values = array_values($result);
			return $values[0];
		}
	}

	return $result;
}
?>