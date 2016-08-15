<?php

class Test {
	
	function test($a = null, $b = null)
	{
		$ajax = ajax();

		$ajax->success("Cjax was successfully installed.", 20);


		$ajax->response = "Version: {$ajax->version}";

		$ajax->wait(3);

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

		$ajax->response = array(
			'style' => array(
				'position' => 'relative',
				'top' => '200px',
				'left' => '200px'
			));

		$ajax->response = "Go ahead, lets <a href='examples/'>Continue</a>";


	}
}