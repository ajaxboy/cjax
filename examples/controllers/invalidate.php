<?php

use CJAX\Core\CJAX;

class Invalidate{
	
	/**
	 *
	 * this is part of the "invalid" plugin which displays an dynamic invalid message.
	 */
	public function invalid(){
		$ajax = CJAX::getInstance();		
		$ajax->invalid(['text1'=> 'Enter Value..', 'text2'=> 'Enter Value..', 'text3'=> 'Enter Value..']);
	}
}