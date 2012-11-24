<?php

class _test {
	
	function test2()
	{
		echo "This is response of test/test2, generic test controller.";
	}
	
	
	
	function formHandler()
	{
		$this->debug($_POST);
	}
}