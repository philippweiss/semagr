<?

$str = "Mi,	17.10.2012 10:30-12:30 Uhr";
//$str = str_replace ("	", " ", $str);

$arr2 = str_split($str, 2);
$arr3 = str_split($str, 3);
$arr4 = str_split($str, 4);

echo $arr2;
echo $arr3;
echo $arr4;

$weekday = $arr2[0];
$date_start = $arr4[10]."-".$arr2[7]."-".$arr2[4]." ".$arr2[15].":".$arr2[18].":"."00";
$date_end = $arr4[10]."-".$arr2[7]."-".$arr2[4]." ".$arr2[15].":".$arr2[18].":"."00";

echo $weekday." ".$date_start;

?>


