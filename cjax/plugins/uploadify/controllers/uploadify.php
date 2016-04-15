<?php

/**
 * Uploadify Plugin 2.0
 * 
 * Ajax Controller
 * 
 * Controller to upload files
 * 
 * @author cj
 *
 */

/*
Uploadify v3.2.1
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

namespace CJAX\Plugins\Uploadify\Controllers;
use CJAX\Core\AJAXController;

class Uploadify extends AJAXController{
	
	public function fileExists(){
		$plugin = $this->ajax->uploadify();				
		if(file_exists($plugin->target . $_POST['filename'])){
			echo 1;
		} 
        else{
			echo 0;
		}
	}
	
	public function upload(){
		$plugin = $this->ajax->uploadify();		
		$exts = $plugin->get('exts');		
		$target = $plugin->get('target');		
		$targetFolder = $target;
		
		if(!empty($_FILES)){
			
			$tempFile = $_FILES['Filedata']['tmp_name'];
			
			$targetFile = rtrim($targetFolder,'/') . '/' . $_FILES['Filedata']['name'];
			// Validate the file type
			if($exts){
				$fileTypes = $exts; // File extensions
			} 
            else{
				$fileTypes = ['jpg','jpeg','gif','png']; // File extensions
			}
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			if(in_array($fileParts['extension'], $fileTypes)){
				echo $targetFile;
				if(move_uploaded_file($tempFile, $targetFile)){
					echo '1';
				} 
                else{
					echo 'error!';
				}
			} 
            else{
				echo 'Invalid file type.';
			}
		}
	}
}