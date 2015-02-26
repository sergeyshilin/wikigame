<?php

	include_once('simple_html_dom.php');

	$html = file_get_html("http://en.wikipedia.org/wiki/World_War_II");
	echo $html;

?>