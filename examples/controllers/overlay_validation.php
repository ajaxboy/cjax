<?php

use CJAX\Core\CJAX;

class Overlay_validation {
	
	public function form(){
		$ajax = CJAX::getInstance();
		//show posted variables
		$ajax->debug($_POST,'Post Debug Info',"These are the fields posted.");
	}
	
	public function overlay2(){
		$ajax = CJAX::getInstance();
		
		$rules = [
			'rules' => [
				'a[name]' => ['required' => true, 'minlength'  => 5],
				'a[last_name]' => ['required' => true, 'minlength'  => 5]
			],
			'messages' => [
				'a[name]' => ['required' => 'Please enter your name'],
				'a[last_name]' => ['required' => 'Enter your last name']
			]
		];
		
		$overlay = $ajax->overlayContent(file_get_contents('resources/html/test_form.html'));
		$overlay->validate('button1','ajax.php?overlay_validation/form', $rules);
		
	}
}