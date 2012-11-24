<?php

class flush  {
	
	function flush_element()
	{
		$ajax = ajax();
		
		$ajax->flush('#link1');
		
		$ajax->info("Element has been flushed.. if you click it nothing will happen.",5);
		
	}
	
}