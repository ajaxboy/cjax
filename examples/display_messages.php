<?php

require_once "ajax.php";


//see controllers/messages.php  to view the code that handles this request.

//call method controller_messages::messages()  in controllers/messages.php
$ajax->call("ajax.php?controller=messages&function=show_messages&a=HELLO WORLD");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Displaying Ajax Messages</title>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Response Messages</h2>
<div id='msgs'></div>
<br />
<br />
Controller:
<?php 
echo $ajax->code("
class controller_messages  {
	
	function show_messages(\$message)
	{
		\$ajax = ajax();
		
		\$ajax->process(\"You are about to see the type of messages you can display on the screen..\",5);
		\$ajax->update(\"msgs\",\"You are about to see the type of messages you can display on the screen..\");
		\$ajax->wait(5);
		
		\$ajax->success(\$message. \" Success message...\");
		\$ajax->update(\"msgs\",\" Success message...\");
		\$ajax->wait(5);
		
		\$ajax->warning(\$message.\" Warning message...\");
		\$ajax->update(\"msgs\",\" Warning message...\");
		\$ajax->wait(5);
		
		\$ajax->error(\$message. \" Error Message...\");
		\$ajax->update(\"msgs\",\" Error Message...\");
		\$ajax->wait(5);
		
		\$ajax->process(\$message. \" You can run and display lots of stuff..\",7);
		\$ajax->update(\"msgs\",\" You can run and display lots of stuff..\");
		
		\$ajax->wait(3);
		\$ajax->update(\"msgs\",\" :) \");
	}
}
");?>

</body>
</html>
