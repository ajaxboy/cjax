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
		$ajax = ajax();
		
		$ajax->update('response','Cjax Works');
		
		$ajax->append('#response','<br /><br />version: '.$ajax->version);
		
		$ajax->success('Cjax was successfully installed.', 5);
		
		//see application/views/test2.php
		$this->load->view('test2');
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