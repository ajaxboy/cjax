<?php

class Test extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 
	 * ajax.php?test/test/a/b/c
	 * 
	 * @param unknown_type $a
	 * @param unknown_type $b
	 * @param unknown_type $c
	 */
	function test($a = null,$b = null, $c = null)
	{
		$this->load->view('test', array('data' => $a .' '.$b.' '.$c));
	}
		
	/**
	 * ajax.php?test/test2
	 * 
	 * Here we are testing out the javascript library.
	 * 
	 * Note: the library it is  not meant to be included in ajax controllers - but in front-controllers,
	 * it is being used here for the sake of simplicity in testing.
	 */
	function test2()
	{
		//see application/views/test2.php
		$this->load->view('test2');
	}

	function test2handler()
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
	}
	
	
	/**
	 * 
	 * ajax.php?test/test3
	 * 
	* will return a json string to the ajax request.
	 */
	function test3()
	{
		$data = array('test1','test2','test3');
		
		return $data;
	}
}