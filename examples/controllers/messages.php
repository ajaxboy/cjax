<?php

class messages  {
	
	function show_messages($message)
	{
		$ajax = ajax();
		
		$ajax->process("You are about to see the type of messages you can display on the screen..",5);
		$ajax->update("msgs","You are about to see the type of messages you can display on the screen..");
		$ajax->wait(5);
		
		$ajax->success($message. " Success message...");
		$ajax->update("msgs"," Success message...");
		$ajax->wait(5);
		
		$ajax->update("msgs"," Warning message...");
		$ajax->warning("Warning message...");
		$ajax->wait(5);
		
		$ajax->error($message. " Error Message...");
		$ajax->update("msgs"," Error Message...");
		$ajax->wait(5);
		
		$ajax->process($message. " You can run and display lots of stuff..",7);
		$ajax->update("msgs"," You can run and display lots of stuff..");
		
		$ajax->wait(3);
		$ajax->update("msgs"," :) ");
	}
}