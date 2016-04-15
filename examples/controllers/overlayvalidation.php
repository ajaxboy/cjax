<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class OverlayValidation extends AJAXController{
	
	public function form(){
		$this->ajax->debug($_POST,'Post Debug Info',"These are the fields posted.");
	}
	
	public function overlay2(){
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
		
		$overlay = $this->ajax->overlayContent(file_get_contents('resources/html/test_form.html'));
		$overlay->validate('button1','ajax.php?overlayvalidation/form', $rules);
		
	}
}