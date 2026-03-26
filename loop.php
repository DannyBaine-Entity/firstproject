
<?php

/*
==========================================
WEEK 5: LOOPS IN PHP
==========================================

A loop is used to repeat a block of code
multiple times.

Example:
Instead of writing echo 10 times,
a loop can do it automatically.
*/

echo "==== WEEK 5: LOOPS ====<br><br>";


// ----------------------------------
// 1. FOR LOOP
// ----------------------------------

echo "-- For Loop Example --<br>";

for ($i = -6; $i <= 5; $i++) {
    echo "Number: " . $i . "<br>";
}

echo "<br>";

//When you know exactly how many times you want the loop to run.

// ----------------------------------
// 2. WHILE LOOP
// ----------------------------------

echo "-- While Loop Example --<br>";

$count = 1;

while ($count <= 5) {
    echo "Count: " . $count . "<br>";
    $count++;
}

echo "<br>";
//When you don’t know exactly how many times the loop will run, condition-based.


// ----------------------------------
// 3. DO WHILE LOOP
// ----------------------------------

echo "-- Do While Loop Example --<br>";

$num = 1;

do {
    echo "Value: " . $num . "<br>";
    $num++;
} while ($num <= 5);

echo "<br>";
//Useful when you want the code to run at least once, even if the condition is false.



// ----------------------------------
// 4. FOREACH LOOP
// ----------------------------------

echo "-- Foreach Loop Example --<br>";

$students = ["Amina", "Emeka", "Tunde", "Sade"];

foreach ($students as $student) {
    echo $student . "<br>";
}

echo "<br>";
//Used to iterate over arrays, especially when you want to access each element directly.


// ----------------------------------
// FOREACH WITH ASSOCIATIVE ARRAY
// ----------------------------------

echo "-- Foreach with Associative Array --<br>";


$scores = [
    "Amina" => 85,
    "Emeka" => 72,
    "Tunde" => 90
];

foreach ($scores as $name => $score) {
    echo $name . " scored " . $score . "<br>";
}

echo "<br>";
//Used to iterate over associative arrays, allowing access to both keys and values.

?>