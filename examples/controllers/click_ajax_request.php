<?php

use CJAX\Core\CJAX;

class click_ajax_request {
	
	function click_button($message)
	{
		$ajax = CJAX::getInstance();
	    $ajaxEvent = json_decode($_COOKIE['cjaxevent'], TRUE);
        $ajaxEventMessage = "<br>";
        foreach($ajaxEvent as $key => $value){
            if($key == "timeStamp") $value = date("Y-m-d H:i:s", $value/1000);
            $ajaxEventMessage .= "{$key}: {$value};<br>";
        }

		$ajax->success("You clicked the button.. {$message}. It is associated with event: {$ajaxEventMessage}");
	}
}