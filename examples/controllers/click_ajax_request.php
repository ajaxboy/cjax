<?php


class click_ajax_request {
	
	public function click_button($message)
	{
		$ajax = ajax();

		$ajax->success("You clicked the button.. $message");
	}
}