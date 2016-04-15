<?php

require_once "ajax.php";


//see controllers/messages.php  to view the code that handles this request.

//call method Messages::showMessages()  in controllers/messages.php
$ajax->call("ajax.php?controller=messages&function=showMessages&a=HELLO WORLD");
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
namespace Examples\\Controllers;
use CJAX\\Core\\AJAXController;    
class Messages extends AJAXController{
	
	public function showMessages(\$message){
		\$this->ajax->process(\"You are about to see the type of messages you can display on the screen..\",5);
		\$this->ajax->update(\"msgs\",\"You are about to see the type of messages you can display on the screen..\");
		\$this->ajax->wait(5);
		
		\$this->ajax->success(\$message. \" Success message...\");
		\$this->ajax->update(\"msgs\",\" Success message...\");
		\$this->ajax->wait(5);
		
		\$this->ajax->warning(\$message.\" Warning message...\");
		\$this->ajax->update(\"msgs\",\" Warning message...\");
		\$this->ajax->wait(5);
		
		\$this->ajax->error(\$message. \" Error Message...\");
		\$this->ajax->update(\"msgs\",\" Error Message...\");
		\$this->ajax->wait(5);
		
		\$this->ajax->process(\$message. \" You can run and display lots of stuff..\",7);
		\$this->ajax->update(\"msgs\",\" You can run and display lots of stuff..\");
		
		\$this->ajax->wait(3);
		\$this->ajax->update(\"msgs\",\" :) \");
	}
}
");?>

</body>
</html>