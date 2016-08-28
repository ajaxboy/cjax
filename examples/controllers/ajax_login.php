<?php

class ajax_login {
	
	function user($username)
	{
		echo "<b>$username</b> is available";
	}
	
	function handler($username, $password) 
	{
		$ajax = ajax();
		
		if(!$username) {
			return  $ajax->err = 'Enter your username.';
		}
		if(!$password) {
			return $ajax->err = 'Enter your password.';
		}
		
		$ajax->success("Hello $username, You haved successfully logged in.");
		
		$ajax->flush('a_login'); //clear the previous events (overlay)
		$ajax->overlay();//clear overlay
		
		$ajax->login_div = "Hello $username!, Logout Now.."; 
		$ajax->insert('#login_div','#a_login', true);
		
		
		
		$ajax->click('a_login', $ajax->call('ajax.php?ajax_login/logout'));
		$ajax->a_login = 'Logout';
		
	}
	
	function logout()
	{
		$ajax = ajax();
		$ajax->flush('a_login');
		$ajax->success("You haved logged out.");
		$ajax->a_login = 'Login';
		$ajax->insert('#login_now_area','#a_login');
		$ajax->login_div = 'Login Again..';
		

		//$link = $ajax->click('button1',$ajax->form('ajax.php?ajax_login/handler','form1'));

		$ajax->click('a_login', $ajax->overlay('resources/html/login.html', array('left'=> '400px')));
		$ajax->on('overlayPop', $ajax->click('button1',$ajax->form('ajax.php?ajax_login/handler','form1')));

	}
}