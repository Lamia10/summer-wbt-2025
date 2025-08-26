<?php
$amount = 1000;   // set
$vat = ($amount * 15) / 100;

echo "Amount = $amount<br>";
echo "VAT (15%) = $vat<br>";
echo "Total with VAT = " . ($amount + $vat) . "<br>";
?>