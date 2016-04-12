<?php

use CJAX\Core\CJAX;

class _test {
	
	function test2()
	{
		echo "This is response of test/test2, generic test controller.";
	}
	
	function remote($key){
        $ajax = CJAX::getInstance();
		$ajaxEvent = json_decode($_COOKIE['cjaxevent'], TRUE);
        $ajaxEventMessage = "<br>";
        foreach($ajaxEvent as $key => $value){
            if($key == "timeStamp") $value = date("Y-m-d H:i:s", $value/1000);
            $ajaxEventMessage .= "{$key}: {$value};<br>";
        }

		$ajax->success("You pressed key: {$key}. It is associated with event: {$ajaxEventMessage}");
    }
	
	function formHandler()
	{
		$this->debug($_POST);
	}
}