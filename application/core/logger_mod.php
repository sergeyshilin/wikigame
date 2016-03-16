<?php
function logger($msg){
	$f = fopen("info.txt", "a+");
	$str = "[".date("Y-m-d H:m:s")."] ".$msg."\n";
	fwrite($f, $str);
	fclose($f);
}
?>