<?php
// strlen shows the length of the string

$name = "Amina";
echo "Length of name " .  strlen($name);

$greeting = "Hello John";
$newGreeting = str_replace("John", "Amina", $greeting);
echo "<br>";
echo "New Greeting: " . $newGreeting;

$text = "Programming";

echo "<br>";
echo "First 4 letters: " . substr($text, 0, 4);

$text = "Programming";

echo "<br>";
echo "First 4 letters: " . substr($text, -3);

$word = "craving";

echo "<br>";
echo "Uppercase: " . strtoupper($word);

?>