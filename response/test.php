<?php

class Test {
	
	function test($a = null, $b = null)
	{
		$ajax = ajax();

		$ajax->success("Cjax was successfully installed.", 6);


		$ajax->response = "Version: {$ajax->version}";
	}
}