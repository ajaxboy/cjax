<?php

class overlay_validation {
	
	function form()
	{
		$ajax = ajax();
		//show posted variables
		$ajax->debug($_POST,'Post Debug Info',"These are the fields posted.");
	}
	
	function overlay2()
	{
		$ajax = ajax();
		
		$rules = array(
			'rules' => array(
				'a[name]' => array(
					'required' => true,
					'minlength'  => 5,
				),
				'a[last_name]' => array(
					'required' => true,
					'minlength'  => 5,
				)
			),
			'messages' => array(
				'a[name]' => array(
					'required' => 'Please enter your name',
				),
				'a[last_name]' => array(
					'required' => 'Enter your last name',
				)
			)
		);
		
		$ajax->overlayContent(file_get_contents('resources/html/test_form.html'));

		$ajax->on('overlayPop', $ajax->validate('button1','ajax.php?overlay_validation/form', $rules));


	}
}