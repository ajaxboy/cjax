<?php

class AjaxController extends  CI_Controller {
	
	function main()
	{
		$this->load->file(FCPATH.'application/libraries/ajax.php');
	}
	
}