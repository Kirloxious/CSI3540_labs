
<?php

$states = "Mississippi Alabama Texas Massachusetts Kansas";
$temp = explode(" ", $states);
$statesarray = array();
foreach ($temp as $s) {
    $pattern = "/xas/";
    $result = preg_match($pattern, $str);
    if ($result == 1) {
        $statesarray[0] = $s;
    }
}
echo $statesarray[0];
?>
