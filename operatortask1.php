<?php

$a = 30;
$b = 20;
$mul = $a * $b;
$plus = $a + $b;
$div = $a / $b;
$sub = $a - $b;

// ARITHMETIC

echo "Multiplication of ". $a. " and ". $b. " = ". $mul  ."<br>";
echo "Addition of ". $a. " and ". $b. " = ". $plus  ."<br>";
echo "Division of ". $a. " and ". $b. " = ". $div  ."<br>";
echo "Substraction of ". $a. " and ". $b. " = ". $sub  ."<br>";

echo "<br>";

// COMPARISON

$age = 40;

if ($age >= 18){
    echo "You're an adult";
} else {
    echo "You're still a child";
}

echo "<br>";

$score = 50;

if ($score >= 50 && $score <= 100){
    echo "You Passed";
}else {
    echo "You Failed";
}

echo "<br>";

// ASSIGNMENT OPERATORS
$n = 40;
$n += 3;
echo $n;

echo "<br>";

$m = 40;
$m *= 3;
echo $m;

echo "<br>";

$d = 40;
$d /= 3;
echo $d;

echo "<br>";

$s = 40;
$s -= 3;
echo $s;

echo "<br>";

var_dump(5 == "5");
echo "<br>";
var_dump(5 === "5");
echo "<br>";


?>