<?php
$Fruits = ["Apple", "Orange", "Pineapple", "Banana", "Lime"];

echo "First Fruit: " . $Fruits[0];
echo "<br> Third Fruit: " . $Fruits[2];

array_push($Fruits, "Grapes");
echo "<br>Fruit added: " . $Fruits[5];

echo "<br> Total Fruits: " . count($Fruits);
print_r($Fruits)

?>