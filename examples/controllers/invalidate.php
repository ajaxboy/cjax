<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;

class Invalidate extends AJAXController{
	
	/**
	 *
	 * this is part of the "invalid" plugin which displays an dynamic invalid message.
	 */
	public function invalid(){
		$this->ajax->invalid(['text1'=> 'Enter Value..', 'text2'=> 'Enter Value..', 'text3'=> 'Enter Value..']);
	}
}