[phpMatch](http://blog.vjeux.com/) - user friendly preg_match
================================

preg_match is your ally when you are working on spiders, however it is not really convenient to work with. Those small helpers will help you capture elements with more ease!

Match
-----

### Prototype

	match($str, $regex, $trim = true)

Takes

* str: the string to execute the search on
* regex: the regular expression to match
	` is automatically used as regex escaping character
	\n and \t are trimmed (not spaces!)
	Multiple line environment

Returns

* false: is nothing is matched
* string: if there's one non-named captured element
* associative array: if there are named captured elements
* array: all the captured elements

	

Match All
---------

### Prototype

