<?php
// Accessing Index

$students = ["Amina", "Christiana", "Emily", "Daniel", "Chineye"];

echo "<br><br>Students List: ";
print_r($students);

echo "<br>";
echo "First Student: " . $students[0];

echo "<br>";
echo "Third Student: " . $students[2];

// Associative Array
$studentScores = [
    "Amina" => 76,
    "Christaina" => 91,
    "Emily" => 60,
    "Daniel" => 70,
    "Chineye" => 34
];

echo "<br>";
echo "Best Student: " . $studentScores["Amina"];

echo "<br>";
echo "Total Students: " . count($students);

// Adding to an Array
array_push($students, "Layla");
echo "<br> Students after adding: ";
print_r($students);

// Merging Arrays
$moreStudents = ["Femi", 'Ngozi'];

$allStudents = array_merge($students, $moreStudents);

echo "<br>All students combined: ";
print_r($allStudents);
?>