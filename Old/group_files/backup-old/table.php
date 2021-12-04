<?php
require_once "connection.php";
// get the q parameter from URL
$q = $_REQUEST["q"];

$maxCapacity = "60";

$strSeats = "";

if ($q >= 6) {
	$strSeats = "6";
	$q = $q-6;
} elseif ($q > 4 && $q < 6) {
	$strSeats = "4";
	$q = $q-6;
} elseif ($q > 0 && $q < 4) {
	$strSeats = "2";
	$q = $q-6;
} else {
	$strSeats = "Error";
}

while ($q > 0) {
	if ($q >= 5) {
		$strSeats .= "+6";
		$q = $q-6;
	} elseif ($q >= 3 && $q < 5) {
		$strSeats .= "+4";
		$q = $q-6;
	} elseif ($q > 0 && $q < 3) {
		$strSeats .= "+2";
		$q = $q-6;
	} else {
		$strSeats = "Error";
	}
}

// Output "no suggestion" if no hint was found or output correct values
//echo $hint === "" ? "no suggestion" : $hint;
echo $strSeats;
?>
