<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Messages extends AJAXController{
	
	public function showMessages($message){

		$this->ajax->process("You are about to see the type of messages you can display on the screen..",5);
		$this->ajax->update("msgs","You are about to see the type of messages you can display on the screen..");
		$this->ajax->wait(5);
		
		$this->ajax->success($message. " Success message...");
		$this->ajax->update("msgs"," Success message...");
		$this->ajax->wait(5);
		
		$this->ajax->update("msgs"," Warning message...");
		$this->ajax->warning("Warning message...");
		$this->ajax->wait(5);
		
		$this->ajax->error($message. " Error Message...");
		$this->ajax->update("msgs"," Error Message...");
		$this->ajax->wait(5);
		
		$this->ajax->process($message. " You can run and display lots of stuff..",7);
		$this->ajax->update("msgs"," You can run and display lots of stuff..");
		
		$this->ajax->wait(3);
		$this->ajax->update("msgs"," :) ");
	}
}