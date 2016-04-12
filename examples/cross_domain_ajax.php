<?php

require 'ajax.php';

$url = $ajax->config->crossdomain_url; //reserved, some servers don't allow outbund requestt. 
//For testing purposes the crossdomain_url setting can be speficied in config.
if(!$url) {
	$url = 'http://ajax-framework-for-codeigniter.googlecode.com/svn/trunk/_extra/test/cross_domain.php';
}

$ajax->click('btn_request', $ajax->call($url,'div_response'));

?>
<html>
<head>
<?php echo $ajax->init(); ?>
</head>
<h2>Cross Domain Ajax</h2>

With cross domain ajax you can request any other remote content/html or text  back and forth, you can also request commands from remote ajax controllers.
<br />
<br />
The link bellow will fire a request to  a different domain.
<br />
<a id='btn_request' href='#'>Request</a>
<br />
<div id='div_response'></div>
<br />
<br />
<br />
<br />
Code Used:
<?php 
echo $ajax->code("
\$ajax->click('btn_request', \$ajax->call('http://ajax-framework-for-codeigniter.googlecode.com/svn/trunk/_extra/test/cross_domain.php','div_response'));
");
?>

</html>