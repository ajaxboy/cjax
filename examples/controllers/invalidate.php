<?php

class invalidate {
	
	/**
	 *
	 * this is part of the "invalid" plugin which displays an dynamic invalid message.
	 */
	function invalid()
	{
		$ajax = CJAX::getInstance();
		
		$ajax->invalid(
			array(
					'text1'=> 'Enter Value..',
					'text2'=> 'Enter Value..',
					'text3'=> 'Enter Value..'
				)
			);
	}
}