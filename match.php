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
		` is automatically used as regex escaping character
		\n and \t are trimmed (not spaces!)
		Multiple line environment
	
	Returns
	 - array of (string / array / associative array)
*/

function match_all($str, $regex, $trim = true) {
	preg_match_all(_change_regex($regex, $trim), $str, $results, PREG_SET_ORDER);

	foreach ($results as $key => $result) {
		$results[$key] = _change_result($result);
	}

	return $results;
}

/* 
	Helper for preg_match

	Takes
	 - str: the string to execute the search on
	 - regex: the regular expression to match
		` is automatically used as regex escaping character
		\n and \t are trimmed (not spaces!)
		Multiple line environment
	
	Returns
	 - false: is nothing is matched
	 - string: if there's one non-named captured element
	 - associative array: if there are named captured elements
	 - array: all the captured elements
*/

function match($str, $regex, $trim = true) {
	$found = preg_match(_change_regex($regex, $trim), $str, $result);
	if (!$found) {
		return false;
	}
	return _change_result($result);
}

/* Helpers */

function _change_regex($regex, $trim) {
	$regex = '`' . $regex . '`ms';
	if ($trim) {
		$regex = str_replace(array("\n", "\t"), '', $regex);
	}
	return $regex;
}

function _change_result($result) {
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