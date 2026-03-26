<?php

/*ADDITIONAL EXERCISES
------------------------------------------

Exercise 7
Use a FOR loop to display **even numbers** between 1 and 20.
*/
echo "<b> Exercise 7 </b>";
echo "<br>";

for ($i = 1; $i <= 20; $i++){
    if ($i % 2 == 0){
        echo $i . " ";
    }
}

/*
Exercise 8
Use a WHILE loop to display numbers **counting down** from 10 to 1.
*/
echo "<br>";
echo "<b> Exercise 8 </b>";
$count = 10;
while ($count <= 10 && $count > 0){
    echo "<br>";
    echo $count--;
}
echo "<br>";

/*
Exercise 9
Create an array of 5 colors.
Use FOREACH to display: "I like [color]".
*/
echo "<br>";
echo "<b> Exercise 9 </b>";
$colors = ["Red", "Blue", "Purple", "Gray"];
foreach ($colors as $color){
    echo "<br>";
    echo "I like ". $color;
}
echo "<br>";

/*
Exercise 10
Use IF-ELSE inside a loop:
For numbers 1 to 10, display "Even" if the number is even, "Odd" if it is odd.
*/
echo "<br>";
echo "<b> Exercise 10 </b>";
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

foreach ($numbers as $number){
    if ($number % 2 == 0){
        echo "<br>";
        echo $number . " is Even";
    } else {
        echo "<br>";
        echo $number . " is Odd";
    }
}

/*
Exercise 11
Create an array of 5 items with prices.
Use a loop to calculate the **total cost** of all items.
*/
echo "<br>";
echo "<b> Exercise 11 </b>";
$prices = [
    "Rice" => 500,
    "Beans" => 400,
    "Yam" => 800
];

$total_cost = 0;
foreach ($prices as $item => $price){
    $total_cost += $price;

/* 
Exercise 12
Create a simple **countdown timer** 
using a FOR loop that counts from 5 to 1 and then prints "Blast off!".
*/
echo "<br>";
echo "<b> Exercise 12 </b>";

for ($i = 5; $i > 0; $i--){
    echo "<br>";
    echo $i;
}
echo "<br>";
echo "Blast off!";

/*
Exercise 13
Create an array of 5 animals.
Use a loop to display **only animals that start with a vowel** (A, E, I, O, U).

Use a loop to display:
We have [quantity] [item](s) in stock.
*/
echo "<br>";
echo "<b> Exercise 13 </b>";
$animals = ["Elephant", "Dog", "Ostrich", "Cat", "Ant"];
foreach ($animals as $animal){
    if (in_array(strtoupper($animal[0]), ["A", "E", "I", "O", "U"])){
        echo "<br>";
        echo $animal;
    }
}

/*
Exercise 14
Combine arrays:
Create two arrays:
$fruits1 = ["Apple", "Banana"];
$fruits2 = ["Orange", "Mango"];
Merge them and display all fruits using a loop.
*/
echo "<br>";
echo "<b> Exercise 14 </b>";
$fruits1 = ["Apple", "Banana"];
$fruits2 = ["Orange", "Mango"];
$all_fruits = array_merge($fruits1, $fruits2);
foreach ($all_fruits as $fruit){
    echo "<br>";
    echo $fruit;
}

?>