<?php
require 'ajax.php';
?>
<html>
<head>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Custom Auth and Routing</h2>
<br />
Since 5.0RC3 the ajax framework allows for custom authentication and custom routing without making changes to the core files.
<br /><br />
There is a file: cjax/auth.default.php, in this file there is a further information and framework functionality
to create custom validation and routes. For changes to take effect you must rename file auth.default.php to auth.php.
<br />
<h3>Auth and Routing</h3>
file auth.php has a class with name "AjaxAuth", in this class there are two functions, one of them is "validation" - triggers at validation besore the
ajax request is finished and allows you to write your own custom validation code. The other function is "intercept" - provides you with a section
where you can create your custom code to route ajax requests to other parts of your application.
<h3>Auth</h3>
Returning true indicates that the session is valid. If your return false the request will not proceed and will present an error.
<?php 
echo $ajax->code("
public function validate(\$controller = null, \$function = null, \$args = []){
	return true;
}");
?>
<h3>Routing</h3>
Ajax Routes are specially needed if your application
supports plugins or addons, then these addons may also have full access to the ajax framework and feed
ajax requests through your custom route.
<br />
The intercept function gives you space to write your own custom routes.
Returning "true" in the intercept function would tell the framework not to persue the request any longer and indicates that your route has
taken lead of the request. Returning false would give back the control to the framework and continue the request as it normally would.
<?php 
echo $ajax->code("
public function intercept(\$controller = null, \$function = null , \$args = [], \$requestObj = null){
	return false;
}"
);
?>
</body>
</html>