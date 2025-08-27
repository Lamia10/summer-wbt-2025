<?php
$rows = 3;    
$ch = 'A';    

for ($i = 1; $i <= $rows; $i++) {

    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }

    echo "   "; 

    for ($k = $rows; $k >= $i; $k--) {
        echo ($rows - $k + 1);
    }

    echo "   "; 

    for ($l = 1; $l <= $i; $l++) {
        echo $ch . " ";
        $ch++;
    }

    echo "<br>";
}
?>