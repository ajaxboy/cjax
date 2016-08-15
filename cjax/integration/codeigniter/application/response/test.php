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

		//this is an experimental plugin that was made in 10 minutes.
		//see under cjax/plugins/rumble/
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