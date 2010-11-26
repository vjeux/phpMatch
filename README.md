[phpMatch](http://blog.vjeux.com/) - user friendly preg_match
================================

preg_match is your ally when you are working on web spiders, however it is not really convenient to work with. Those small helpers will help you capture elements with more ease!

* The result is directly in the return value and have the form you expect
	* Capturing one element will give you that element, it won't be wrapper on an array
	* No more duplicate in the array when naming the elements
	* The matched string is removed from the result. It is annoying when dumping the result and who ever used it!?
* Regex is configured properly to fit your needs
	* ` is used as regex escape character
	* ms options to be multi-line ready
	* tabs and new lines are removed to let you write readable regex

Match
-----

### Prototype

	match($str, $regex, $trim = true)

Takes

* **str**: the string to execute the search on
* **regex**: the regular expression to match
	* ` is automatically used as regex escaping character
	* \n and \t are trimmed (not spaces!)
	* Multiple line environment

Returns

* **false**: is nothing is matched
* **string**: if there's one non-named captured element
* **associative array**: if there are named captured elements
* **array**: all the captured elements


### Examples

The value is directly returned by the function, no need to do write another line to get the result. false is returned when nothing is matched.

	$none = match('<a class="abc">', 'id="([0-9]+)"');
	// false

If you are only capturing one element, it is given as is. No more useless single array.
	$string = match('<a id="123">', 'id="([0-9]+)"');
	// 123

When naming elements, all the numbered values are removed!
	$assoc = match('<a class="abc" id="123">', '<a class="(?P<class>[^"]+)" id="(?P<class>[^"]+)">');
	// array("class" => "abc", "id" => "123")

The first element of the resulting array (the matched string) is removed, you now only get what you wanted!
	$array = match('<a class="abc" id="123">', '<a class="([^"]+)" id="([^"]+)">');
	// array("abc", "123")

When working on real files, your regexes can be complex. You can use tabs and line breaks to make it more readable.
The . is also capturing \n, this will let you use the [.*? trick](http://www.google.fr/search?q=regex+non+greedy) to magically capture the content you want :)

	$file = <<<EOF
	<div><a class="abc" id="123"><strong>Name</strong></a>

	</div>
	EOF;

	// WARNING: Make sure you convert the indentation to TABs when copy & pasting the code!
	$multiline = match($file, '
		<div>
		.*?
		<a class="(?P<class>[^"]+)" id="(?P<id>[^"]+)">
			(?P<name>.*?)
		</a>
		.*?
		</div>');

	// array("class" => "abc", "id => "123", "name" => "\n\t\t<strong>\n\t\t\tName\n\t\t</strong>")

Match All
---------

### Prototype

