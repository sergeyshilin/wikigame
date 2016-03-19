<?php
class View{
	function generate($content_view, $template_view, $data=null, $info=null, $data2=null, $data3=null){
		include 'application/views/'.$template_view;
	}
}