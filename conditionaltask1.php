<?php

// ----------------------------------
// PRACTICE EXERCISES
// ----------------------------------

/*
==========================================
PRACTICE EXERCISES
==========================================

Exercise 1
Create a variable called $age.

If age is 18 or above
display "You can register".

Otherwise display
"You are too young".
*/

$age = 25;

if ($age >= 18){
    echo "You can register";
} else {
    echo "You are too young";
}

/*
Exercise 2
Create a variable called $username.

If the username is "admin"
display "Welcome Admin".

Otherwise display
"Access denied".
*/
echo "<br>";
$username = "admin";
if ($username == "admin"){
    echo "Welcome Admin";
} else {
    echo "Access Denied";
}


/*
Exercise 3
Create a variable called $marks.

90 and above -> Excellent
70 - 89      -> Good
50 - 69      -> Pass
Below 50     -> Fail
*/

echo "<br>";

$marks = 45;

if ($marks >= 90){
    echo "Excellent";
} elseif ($marks >= 70) {
    echo "Good";
} elseif ($marks >= 50){
    echo "Pass";
} else {
    echo "Fail";
}

/*
Exercise 4
Create a variable called $balance.

If balance is greater than 1000
display "You can withdraw".

Otherwise display
"Insufficient balance".
*/
echo "<br>";
 $balance = 999;

 if ($balance > 1000){
    echo "You can withdraw";
 } else {
    echo "Insufficient Balance";
 }

/*
Exercise 5
Create a switch statement for months.

Example:

$month = "December"

Display:
December -> Christmas Month
January -> New Year
Other months -> Regular Month
*/
echo "<br";

$month = "Janurary";

switch ($month){
    case "December";
        echo "Christmas Month <br>";
        break;

    case "Janurary";
        echo "New Year <br>";
        break;

    default;
        echo "Regular Month <br>";
}

/*
==========================================
SUMMARY
==========================================

if statement
Used when we want to check a condition.

if...else
Used when there are two outcomes.

if...elseif...else
Used when there are many conditions.

switch
Used when checking many specific values.

================
END OF WEEK 4 LESSON
==========================================

*/



?>