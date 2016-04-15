<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class AJAXLogin extends AJAXController{
	
	public function user($username){
		echo "<b>$username</b> is available";
	}
	
	public function handler($username, $password) {
		if(!$username){
			return  $this->ajax->err = 'Enter your username.';
		}
		if(!$password){
			return $this->ajax->err = 'Enter your password.';
		}
		
		$this->ajax->success("Hello $username, You haved successfully logged in.");
		
		$this->ajax->flush('#a_login'); //clear the previous events (overlay)
		$this->ajax->overlay();//clear overlay
		
		$this->ajax->login_div = "Hello $username!, Logout Now.."; 
		$this->ajax->insert('#login_div','#a_login', true); 
				
		$this->ajax->click('#a_login', $this->ajax->call('ajax.php?ajaxlogin/logout'));
		$this->ajax->a_login = 'Logout';		
	}
	
	public function logout(){
		$this->ajax->flush('#a_login');
		$this->ajax->success("You haved logged out.");
		$this->ajax->a_login = 'Login';
		$this->ajax->insert('#login_now_area','#a_login');
		$this->ajax->login_div = 'Login Again..';
		
		$overlay = $this->ajax->overlay('resources/html/login.html', ['left'=> '400px']);
		$link = $this->ajax->exec('button1',$this->ajax->form('ajax.php?ajaxlogin/handler','form1'));
		$overlay->callback($link);
		$this->ajax->click('a_login', $overlay);
	}
}