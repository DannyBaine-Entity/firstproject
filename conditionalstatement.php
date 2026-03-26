<?php
// IF STATEMENTS

echo "== IF statement Example ==<br>";

$loggedIn = false;
if($loggedIn){
    echo "Welcome to my Webpage";
}else{
    echo "No user found";
}

echo "<br>";

// IF ELSE STATEMENTS
echo "<br>== IF ELSE statement Example ==<br>";

$mark = 0;
if ($mark >= 90){
    echo "A";
} elseif ($mark >= 75){
    echo "B";
} elseif ($mark >= 60){
    echo "C";
} elseif ($mark >= 45){
    echo "D";
} else {
    echo "F";
}

echo "<br>";

echo "Another Example <br>";

$light = "Yellow";

switch ($light){
    case "Red";
        echo "Stop <br>";
        break;

    case "Yellow";
        echo "Get Ready <br>";
        break;

    case "Green";
        echo "Go! <br>";
        break;

    default;
        echo "Invalid Traffic Color";
}

?>