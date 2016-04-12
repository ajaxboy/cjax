<?php

/**
 * 
 * Ajax Uploader 1.3
 * @author cj
 *
 */

use CJAX\Core\CJAX; 
 
class Uploader{

	private $error;
	private $post;
	private $options;
	private $files;	
	private $uploadCount = 0;
	
	/**
	 * 
	 * Upload Files
	 */
	public function upload(){
		$ajax  = CJAX::getInstance();
		$error = false;
		$filesFount = false;
		$files = [];
		
		$ajax->cacheWrapper(["<html><body>","</body></html>"]);
		$options = $ajax->get('upload_options', true);
		$this->options = $options;		
		if(!$this->options->target){
			$this->abort("No target directory.");
		}		
		if(!is_writable($options->target)){            
			return $this->abort("Directory is not writable.");
		}		
		$this->chkLength();
		
		if(!$_FILES){
			if(isset($_REQUEST['files']) && $_REQUEST['files']){
				if(count($_REQUEST['files']) > 1){
					$this->error = "The files you tried to upload are too big or invalid.";
				} 
                else{
					$this->error = "The file you tried to upload is too big or invalid.";
				}
			}
		} 
        else{
			foreach($_FILES as $k => $v){
				if(is_array($v['error'])){
					foreach($v['error'] as $k2 => $err){
						$filename = $v['name'][$k2];
						if(!$filename){
							continue;
						}
						$size = $v['size'][$k2];
						if($filename){
							$filesFount = true;
						}
						if($err){
							$this->error = $this->error($err, $filename, $size);
							continue;
						} 
                        else{
							if($filename && !$this->chkExt($filename)){
								break;
							}
							
							if($f = $this->uploadFile($v['tmp_name'][$k2],$filename)){
								$files[] = $f;
							}
						}
					}
				} 
                else{
					$filename = $v['name'];
					if(!$filename){
						continue;
					}
					if($filename && !$this->chkExt($filename)){
						break;
					}
					if($v['error']){
						$this->error = $this->error($v['error'], $filename, $v['size']);
						break;
					} 
                    else{
						if($v['name']){
							$filesFount = true;
						}
						if($f = $this->uploadFile($v['tmp_name'], $filename)){
							$files[] = $f;
						}
					}
				}
			}
		}
		
		
		$this->debug($this->options);
		
		if(!$filesFount){
			if(!$this->options->files_require && !$this->uploadCount){
				$this->flush();
				$ajax->message();
				return true;
			}
			if(!$this->error){
				$this->error = "No Files Were selected";
			}
		}
		
		if(!$this->error){
			if($this->post){
				$ajax->ajaxVars($this->post);
			}
			if($this->options->preview){
				$preview = $this->options->preview;
				$previewUrl = $this->options->preview_url;
				if($previewUrl) {
					$previewUrl = rtrim($previewUrl,'/').'/';
				}
                
				$range = range(1,  count($this->files));
				array_walk($range, function(&$v){
					$v =  "#image{$v}#";					
				});
				foreach($this->files as $k => $v){
					$this->files[$k] = $previewUrl.$v;
				}
				foreach($preview as $k => $v){
					$image = str_replace($range, $this->files, $v);
					$ajax->update($k, $image);
				}
			}
			
			$_files = implode(', ',$files);
			$message = $this->options->success_message;
			if(!$message){
				$message = "File(s) $_files successfully uploaded.";
			} 
            else{
				$message = str_replace("@files", $_files, $message);
			}
			$ajax->success($message, 5);
		} 
        else{			
			$ajax->warning($this->error, 5);
		}
		
	}
	
	public function flush(){
		CoreEvents::$lastCache = [];
		CoreEvents::$cache = [];
	}
	
	/*
	 * abort the uploads
	 */
	public function abort($error){
		$ajax = CJAX::getInstance();		
		$ajax->error($error, 8);		
		exit();
	}

	public function debug($options){
		if($options && $options->debug) {
			$ajax = CJAX::getInstance();			
			$options->{"List Of Files Uploaded"} = $this->post;				
			$settings['php.ini post_max_size'] = ini_get('post_max_size');
			$settings['php.ini upload_max_filesize'] = ini_get('upload_max_filesize');
			$settings['php.ini max_execution_time'] = ini_get('max_execution_time');
			$settings['CONTENT_LENGTH'] = @$_SERVER['CONTENT_LENGTH'].' bytes';
			
			$debugMessage = null;
			if(is_string($options->debug)) {
				$debugMessage = $options->debug."<br /><br />";
			}
			$ajax->dialog("
				$debugMessage
				To be able to upload files, the server has to be able to handle them. 
				These are settings you can control in php.ini file. Any file(s) that exceeds these limitations
				will not be uploaded.
				<br />
				<br />
				These are server settings:
				<pre>". print_r($settings,1)."</pre>
				Settings Passed:
				<pre>".print_r($options,1)."</pre>"
				."Files:".
				"<pre>".print_r($_FILES,1)."</pre>"
			,"Debug Information");
		}
	}
	
	/**
	 * 
	 * Check file extension
	 * @param unknown_type $filename
	 */
	public function chkExt($filename){
		$info = pathinfo($filename);		
		if($this->options->ext && is_array($this->options->ext)) {
			$exts =  array_map('strtolower', $this->options->ext);
			if(!in_array(strtolower($info['extension']), $exts)) {
				$this->error = "File Extension: .{$info['extension']}  is not supported.";
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 
	 * Upload File
	 * @param unknown_type $tmpname
	 * @param unknown_type $filename
	 */
	public function uploadFile($tmpname, $filename){
		$info = pathinfo($filename);
		$filename = $info['filename'];
		
		$oldFilename = $filename;
		if($prefix = $this->options->prefix){
			if($prefix=='time'){
				$prefix = time();
			}
			if($prefix=='rand'){
				$prefix = rand(1, 10000000);
			}
			$filename = $prefix.'_'.$filename;
		}
		if($suffix = $this->options->suffix){
			if($suffix=='time'){
				$suffix = time();
			}
			if($suffix=='rand'){
				$suffix = rand(1, 10000000);
			}
			$filename = $filename.'_'.$suffix;
		}
		
		$filename = $filename.'.'.$info['extension'];		
		$ajax = CJAX::getInstance();		
		$this->post['a'][] = $filename;
		$this->files[] = $filename;
		
		if(@move_uploaded_file($tmpname,$this->options->target.$filename)) {
			$this->uploadCount++;
			return $filename;
		} else {
			sleep(2);
			//try again
			if(!@copy($tmpname,$this->options->target.$filename)) {
				$this->uploadCount++;
				$error = error_get_last();
				$this->error = "Could not upload file $filename. {$error['message']}";
			}
		}	
	}

	/**
	 * 
	 * Check request length
	 */
	public function chkLength(){
		if(isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH']) {
		
			$postMax = $_postMax = @ini_get('post_max_size');// / 8;		
			$postMax = preg_replace("/([^0-9]+)/","", $postMax);		
			switch(substr($_postMax,-1)){
			    case 'G':
				    $postMax = $postMax * 1024;
			    case 'M':
				    $postMax = $postMax * 1024;
			    case 'K':
				    $postMax = $postMax * 1024;
			}
			
			if($_SERVER['CONTENT_LENGTH'] > $postMax){
				$error = "Upload Failed. This server limits max upload to $_postMax (post_max_size in php.ini). ";
				$this->abort($error);
			}
		}
	}
	
	/**
	 * 
	 * Error Handling
	 * 
	 * @param integer $errorNo
	 * @param string $fileName
	 * @param integer $size
	 */
	public function error($errorNo, $fileName, $size = 0){
		$ajax  = CJAX::getInstance();
		$error = null;
		
		if($errorNo){
			switch($errorNo){
				case UPLOAD_ERR_INI_SIZE:
					$_uploadMax = @ini_get('upload_max_filesize');
					
					$error = "{$fileName} - File exceeds max upload limit of $_uploadMax";
				break;
				case UPLOAD_ERR_FORM_SIZE:
					$error = "{$fileName} - The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form. ";
				break;
				case UPLOAD_ERR_PARTIAL:
					$error = "{$fileName} -The uploaded file was only partially uploaded.";
				break;
				case UPLOAD_ERR_NO_FILE:
					$error = "{$fileName} - No file was uploaded. ";
				break;
				case UPLOAD_ERR_NO_TMP_DIR:
					$error = "{$fileName} - Missing a temporary folder.";
				break;
				case UPLOAD_ERR_CANT_WRITE:
					$error = "{$fileName} - Failed to write file to disk.";
				break;
				case UPLOAD_ERR_EXTENSION:
					$error = "{$fileName} - A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop;<br /> examining the list of loaded extensions with phpinfo() may help.";
				break;
				default:
				$error = "$fileName Unknown Error Occurred.";
			}
		}		
		return $error;
	}
}