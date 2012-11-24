<?php

/**
 * Uploadify Plugin
 * 
 * Ajax Controller
 * 
 * Controller to upload files
 * 
 * @author cj
 *
 */
/*
Uploadify v3.1.0
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

class _uploadify {
	
	function fileExists()
	{
		$ajax = ajax();
		$plugin = $ajax->uploadify();
		
		
		if (file_exists($plugin->target . $_POST['filename'])) {
			echo 1;
		} else {
			echo 0;
		}
	}
	
	function upload()
	{
		$ajax = ajax();
		
		$plugin = $ajax->uploadify();
		
		$exts = $plugin->get('exts');
		
		$target = $plugin->get('target');
		
		
		$targetFolder = $target;
		
		if (!empty($_FILES)) {
			
			$tempFile = $_FILES['Filedata']['tmp_name'];
			
			$targetFile = rtrim($targetFolder,'/') . '/' . $_FILES['Filedata']['name'];
			// Validate the file type
			if($exts) {
				$fileTypes = $exts; // File extensions
			} else {
				$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			}
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			if (in_array($fileParts['extension'],$fileTypes)) {
				echo $targetFile;
				if(move_uploaded_file($tempFile,$targetFile)) {
					echo '1';
				} else {
					echo 'error!';
				}
			} else {
				echo 'Invalid file type.';
			}
		}
	}
}