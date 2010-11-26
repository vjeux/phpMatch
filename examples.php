<pre>
<?php

require 'match.php';

/*-------*/
/* Match */
/*-------*/
echo "\n<h2>Match</h2>\n";

$file = <<<EOF
<div><a class="abc" id="123"><strong>Name</strong></a>

</div>
EOF;

echo "\nNo match: \n";
$none = match($file, 'href="([^"]+)"');
var_dump($none);
// false

echo "\nSingle capture: \n";
$string = match($file, 'id="([0-9]+)"');
var_dump($string);
// 123

echo "\nAssociative capture: \n";
$assoc = match($file, '<a class="(?P<class>[^"]+)" id="(?P<id>[^"]+)">');
print_r($assoc);
// array("class" => "abc", "id" => "123")

echo "\nArray capture: \n";
$array = match($file, '<a class="([^"]+)" id="([^"]+)">');
print_r($array);
// array("abc", "123")


echo "\nMultiline capture: \n";

$multiline = match($file, '
	<div>
	.*?
	<a class="(?P<class>[^"]+)" id="(?P<id>[^"]+)">
		(?P<name>.*?)
	</a>
	.*?
	</div>');
print_r($multiline);
// array("class" => "abc", "id => "123", "name" => "\n\t\t<strong>\n\t\t\tName\n\t\t</strong>")


/*-----------*/
/* Match All */
/*-----------*/
echo "\n<h2>Match All</h2>\n";

$file = <<<EOF
<a href="http://blog.vjeux.com/">Vjeux</a>
<a href="http://www.curse.com/">Curse</a>
<a href="http://www.google.com/">Google</a>
EOF;


echo "\nSingle captures: \n";
$singles = match_all($file, '<a href="[^"]+">(.*?)</a>');
print_r($singles);
// array("Vjeux", "Curse", "Google")

echo "\nArray captures: \n";
$arrays = match_all($file, '<a href="([^"]+)">(.*?)</a>');
print_r($arrays);
// array(
//   array("http://blog.vjeux.com/", "Vjeux"),
//   array("http://www.curse.com/", "Curse"),
//   array("http://www.google.com/", "Google"))

echo "\nAssociative captures: \n";
$associatives = match_all($file, '<a href="(?P<link>[^"]+)">(?P<name>.*?)</a>');
print_r($associatives);
// array(
//   array("link" => "http://blog.vjeux.com/",	"name" => "Vjeux"),
//   array("link" => "http://www.curse.com/",	"name" => "Curse"),
//   array("link" => "http://www.google.com/",	"name" => "Google"))

?>
</pre>