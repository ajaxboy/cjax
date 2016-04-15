<?php

namespace Examples\Controllers;
use CJAX\Plugins\Uploader\Controllers\Uploader;
 
class UploadFile extends Uploader{

	public function post($files){
		//files listed under 'files' array are files that were successfully uploaded
		if($files){
			$this->ajax->wait(2, false);			
			$this->ajax->alert("Controller Response:".print_r($files,1));
		}

		//uncoment to see the response on the screen
		//$this->ajax->overlayContent($this->ajax->dialog("<pre>".print_r($_REQUEST,1)."</pre>","Controller Response: upload_file/post "));
	}
	
	/**
	 * 
	 * @deprecated
	 * @param unknown_type $file_names
	 */
	public function sendfile($file_names = null){
		$dir = realpath(dirname(__FILE__).'/../'); //directory where the file is uploaded..
		
		if($_FILES || $this->ajax->get('cjax_iframe')) {
			if(!is_writable($dir)) {
				return $this->ajax->overlayContent("Directory $dir is not writeable.\nPermission denied.<br /> (chmod $dir 777) or make sure the directory exists.");
			}
		
			if(empty($_FILES)) {
				return $this->ajax->overlay("ajax.php?controller=upload_file&function=error");
			}
			$file = $_FILES['my_file'];
			if(!$file['name']) {
				exit('error');
			}
			
			$temp = (($file['tmp_name'])?$file['tmp_name']:null);

			$temp = trim($temp,DIRECTORY_SEPARATOR);
			if(@move_uploaded_file($temp, $dir.'/'.$file['name'])){
				$this->ajax->success("File uploaded..",10);
			} 
            else{
				$this->ajax->warning("Could not move file");
			}
		} 
        elseif($this->ajax->request()){
			$this->ajax->process("Uploading file..",1000);
			//Ajax request
			//PRE-POST FILE
			if(!$_REQUEST['my_file']) {
				$this->ajax->warning("Please select a file");
				$this->ajax->focus('my_file');
				exit;
			}			
		}
	}
	
	
	public function triggerError(){
		$upload_max = $this->ajax->toMB(ini_get('upload_max_filesize'));
		$post_max = $this->ajax->toMB($pmax = ini_get('post_max_size'));// / 2;
		$max_size = ($upload_max < $post_max) ? $upload_max : $post_max;
		$cause = ($upload_max < $post_max) ? "upload_max_filesize " : "post_max_size ";	
		echo "Could not upload file. This server limits max upload to {$max_size}MB ($cause in php.ini). ";
	}
	
}