<?php
$numbers = array(10, 20, 30, 40, 50);
$search = 30;   
$found = false;

foreach($numbers as $n){
    if($n == $search){
        $found = true;
        break;
    }
}

if($found){
    echo "$search found in array";
} else {
    echo "$search not found in array";
}
?>
