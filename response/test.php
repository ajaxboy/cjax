<?php

class Test {
	
	function test($a = null, $b = null)
	{
		$ajax = ajax();

		$ajax->success("Cjax was installed successfully.", 13);

		$ajax->response = "Version: {$ajax->version}";

		$ajax->wait(3);

		//center text some what
		$ajax->response = array(
			'style' => array(
				'position' => 'relative',
				'top' => '200px',
				'left' => '200px'
			));

		$ajax->wait(4);

		$ajax->response = "Are you ready for some real action?";

		$ajax->rumble('response');

		$ajax->wait(5);

		//rumble screws with the position of the text, so lets re-center it
		$ajax->response = array(
			'style' => array(
				'position' => 'relative',
				'top' => '200px',
				'left' => '200px'
			));

		$ajax->response = "Go ahead, lets <a href='examples/'>Continue</a>";


	}
}