<?php

/**
 * //@uploadify;
 * 
 * Plugin Controller
 * 
 * @author cj
 *
 */
class uploadify extends plugin {
	
	private $options = array(); //local variable
	
	//extensions
	public $exts = array('jpg','jpeg','gif','png');
		

	/**
	 * 
	 * @param string $upload_id
	 * @param array $options
	 */
	function onLoad($upload_id = null, $options = array())
	{
	
		$this->options = $options;
		
		//Remove these if already on your page, or load manually
		//preload dependecies, import multiple files
		
		//updates 3rd paramaters in the plugin
		$this->set('c',  session_id());
	}
	
	/**
	 * This function updates second parameter values options
	 * eg.
	 * $this->buttonText = "Button";
	 * $this->fileTypeDesc = "Images";
	 */
	function __set($setting, $value)
	{
		//upload directory
		if($setting=='target') {
			if($dir = ajax()->config->upload_dir) {
				$value = rtrim($dir,'/') . '/uploadify/';
			}
			if(!$value) {
				$value = './';
			}
			if(!is_writable($value)) {
				
				$ajax = ajax();
				$ajax->error("Uploadify: Target is not writable. Check directory exists and has proper permission, then try again.");
				
				//remove any pending uploadify tasks
				$this->abort();
				return;
			}
			$this->save('target', $value);
			return;
		}
		
		/**
		 * "fileTypeExts" only deals with client side, but there is a second
		 * check in the ajax contoller, save it then we can get it there to make
		 * sure we are using  the right extensions.
		 * see controlles/uploadify.php
		 */
		if($setting=='fileTypeExts') {
			$exts = preg_replace(array("/^\*\./","/\*|\;/"),'',$value);
			$exts = explode('.',$exts);
				
			//update extensions
			$this->exts = $exts;
			$this->save('exts', $exts);
		}
		//update options
		$this->options[$setting] = $value;
		
		//Save to options /second parameter
		$this->set('b', $this->options, $this->_id); //parameter, variable
	}
}