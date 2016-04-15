<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class ClickAJAXRequest extends AJAXController{
	
	public function clickButton($message){
	    $ajaxEvent = json_decode($_COOKIE['cjaxevent'], TRUE);
        $ajaxEventMessage = "<br>";
        foreach($ajaxEvent as $key => $value){
            if($key == "timeStamp") $value = date("Y-m-d H:i:s", $value/1000);
            $ajaxEventMessage .= "{$key}: {$value};<br>";
        }
		$this->ajax->success("You clicked the button.. {$message}. It is associated with event: {$ajaxEventMessage}");
	}
}