<?php

$min = 1000;
$max = 4999;
$randomNum1 = rand($min, $max);
$randomNum2 = rand($min, $max);

//This below makes it almost impossible to get the same random number
if ($randomNum1 != $randomNum2){
    echo $randomNum1;
}else{
    echo $randomNum1 + $randomNum2;
}
?>