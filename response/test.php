<?php

class Test {

	public function __construct() {}

	function test($a = null, $b = null)
	{
		$step1 = true;
		include 'cjax/integration/default/testing.php';
	}

	public function test2()
	{

		$ajax = ajax();

		$ajax->success("<span id='cjax'>Cjax</span> was installed <span id='flip'>successfully</span>.", 30);

		$ajax->response = "Version: {$ajax->version}";

		$ajax->wait(3);

		//center text some what
		$ajax->response = array(
			'style' => array(
				'position' => 'relative',
				'top' => '120px',
				'left' => '200px'
			));

		$ajax->wait(4);

		$ajax->response = array(
			'style' => array(
				'fontWeight' => 'bolder',
				'fontSize' => '25px',
				'left' => '200px'
			));

		$ajax->wait(3);

		$ajax->spin('#cjax','spin');
		$ajax->spin('#flip','flipUp');

		$ajax->wait(5);


		$ajax->spin('#response','flip', 5000);


		$ajax->response2 = "Go ahead, lets <a href='examples/'>Continue</a>";

		$ajax->response2 = array(
			'style' => array(
				'fontWeight' => 'bolder',
				'fontSize' => '25px',
				'left' => '200px'
			));

		$step2 = true;
		include 'cjax/integration/default/testing.php';
	}
}