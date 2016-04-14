<?php

use CJAX\Core\CJAX;

class Ajax_login{
	
	public function user($username){
		echo "<b>$username</b> is available";
	}
	
	public function handler($username, $password) {
		$ajax = CJAX::getInstance();
		
		if(!$username){
			return  $ajax->err = 'Enter your username.';
		}
		if(!$password){
			return $ajax->err = 'Enter your password.';
		}
		
		$ajax->success("Hello $username, You haved successfully logged in.");
		
		$ajax->flush('#a_login'); //clear the previous events (overlay)
		$ajax->overlay();//clear overlay
		
		$ajax->login_div = "Hello $username!, Logout Now.."; 
		$ajax->insert('#login_div','#a_login', true); 
				
		$ajax->click('#a_login', $ajax->call('ajax.php?ajax_login/logout'));
		$ajax->a_login = 'Logout';
		
	}
	
	public function logout(){
		$ajax = CJAX::getInstance();
		$ajax->flush('#a_login');
		$ajax->success("You haved logged out.");
		$ajax->a_login = 'Login';
		$ajax->insert('#login_now_area','#a_login');
		$ajax->login_div = 'Login Again..';
		
		$overlay = $ajax->overlay('resources/html/login.html', ['left'=> '400px']);
		$link = $ajax->exec('button1',$ajax->form('ajax.php?ajax_login/handler','form1'));
		$overlay->callback($link);
		$ajax->click('a_login', $overlay);
	}
}