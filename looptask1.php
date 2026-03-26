<?php

/*
==========================================
PRACTICE EXERCISES
==========================================

Exercise 1
Use a FOR loop to display numbers 1 to 10.
*/
echo "<b> Exercise 1 </b>";
 for($number = 1; $number <= 10; $number++){
    echo "<br>";
    echo $number;
 }
echo "<br>";
/*
Exercise 2
Use a WHILE loop to display numbers 5 to 10.
*/
echo "<br>";
echo "<b> Exercise 2 </b>";
$count = 5;
while ($count <= 10){
    echo "<br>";
    echo "Number " . $count;
    $count++;
}
echo "<br>";
/*
Exercise 3
Create an array of 5 fruits.
Use FOREACH to display each fruit.
*/

echo "<br>";
echo "<b> Exercise 3 </b>";
 $fruits = ["Apple", "Grape", "Orange", "Pineapple", "Cucumber"];

 foreach ($fruits as $fruit){
    echo "<br>";
    echo $fruit; 
    }
echo "<br>";
/*

Exercise 4
Create an array of student names.
Display them using a loop.
*/

echo "<br>";
echo "<b> Exercise 4 </b>";
$students = ["Josh", "Daniel", "Favour", "Maleek"];
foreach ($students as $student){
    echo "<br>";
    echo $student;
}
echo "<br>";
/*

Exercise 5
Create an associative array:

$prices = [
"Rice" => 500,
"Beans" => 400,
"Yam" => 800
];

Use FOREACH to display:

Rice costs 500
Beans costs 400
Yam costs 800
*/

echo "<br>";
echo "<b> Exercise 5 </b>";
$prices = [
"Rice" => 500,
"Beans" => 400,
"Yam" => 800
];

foreach ($prices as $product => $price){
    echo "<br>";
    echo $product . " costs " . $price;
}
echo "<br>";
/*
==========================================
SUMMARY
==========================================

for loop
Used when we know how many times
we want to repeat something.

while loop
Repeats while a condition is true.

do...while loop
Runs at least once before checking the condition.

foreach loop
Used mainly for arrays.

==========================================
END OF WEEK 5 LESSON
==========================================
*/

?>