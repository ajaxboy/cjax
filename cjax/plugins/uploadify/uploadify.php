<?php

/**
 * uploadify 1.6
 * 
 * Plugin Controller
 * 
 * @author cj
 *
 */
 
namespace CJAX\Plugins\Uploadify; 
use CJAX\Core\CJAX;
use CJAX\Core\Plugin;
 
class uploadify extends Plugin{
	
	private $options = []; //local variable
	
	//extensions
	public $exts = ['jpg','jpeg','gif','png'];
		

	/**
	 * 
	 * @param string $upload_id
	 * @param array $options
	 */
	public function onLoad($uploadId = null, $options = []){
	
		$this->options = $options;
		
		//Remove these if already on your page, or load manually
		//preload dependecies, import multiple files

		
		//$this->waitFor('jquery.uploadify-3.1.js');
		
		$this->import('uploadify-3.2/jquery.uploadify.js',0,true);
		
		
		
		//import single file (this file is relative to the plugin)
		$this->import('uploadify-3.2/uploadify.css');
		//uploadify-v3.1/jquery.uploadify-3.1.min.js
		
		
		//updates 3rd paramaters in the plugin
		$this->set('c',  session_id());
	}
	
	/**
	 * This function updates second parameter values options
	 * eg.
	 * $this->buttonText = "Button";
	 * $this->fileTypeDesc = "Images";
	 */
	public function __set($setting, $value){
		//upload directory
		if($setting=='target'){
			if($dir = CJAX::getInstance()->config->uploadify_dir){
				$value = $dir;
			}
			if(!$value){
				$value = './';
			}
			if(!is_writable($value)){
				
				$ajax = CJAX::getInstance();
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
		if($setting=='fileTypeExts'){
			$exts = preg_replace(["/^\*\./","/\*|\;/"],'',$value);
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