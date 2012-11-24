<?php
/*
 * 
 * (c) Cj Galindo
 */

$_SERVER['HTTP_X_REQUESTED_WITH'] = 'CJAX FRAMEW0RK //@version;';

if(!is_file($f = '../../cjax.php')) {
	exit('file not found');
}
require_once $f;
/** session.gc_maxlifetime
* max_input_time
* max_execution_time
* upload_max_filesize
* post_max_size*/


class iframeUpload {
	
	private $error;
	private $post;
	private $options;
	
	private $upload_count = 0;
	
	
	
	/**
	 * 
	 * Upload Files
	 */
	function __construct()
	{
		$ajax  = ajax();
		$error = false;
		$files_fount = false;
		$files = array();
		
		$ajax->cacheWrapper(array("<html><body>","</body></html>"));
		$options = $ajax->get('upload_options', true);
		
		$this->options = $options;
		$this->debug($this->options);
		
		$this->chkLength();
		
		if(!$_FILES) {
			if(isset($_REQUEST['files']) && $_REQUEST['files']) {
				if(count($_REQUEST['files']) > 1){
					$this->error = "The files you tried to upload are too big or invalid.";
				} else {
					$this->error = "The file you tried to upload is too big or invalid.";
				}
			}
		} else {
			foreach($_FILES as $k => $v) {
				if(is_array($v['error'])) {
					foreach($v['error'] as $k2 => $err) {
						$filename = $v['name'][$k2];
						if(!$filename) {
							continue;
						}
						$size = $v['size'][$k2];
						if($filename) {
							$files_fount = true;
						}
						if($err) {
							$this->error = $this->error($err,$filename, $size);
							continue;
						} else {
							if($filename && !$this->chkExt($filename)) {
								break;
							}
							
							if($f = $this->uploadFile($v['tmp_name'][$k2],$filename)) {
								$files[] = $f;
							}
						}
					}
				} else {
					$filename = $v['name'];
					if(!$filename) {
						continue;
					}
					if($filename && !$this->chkExt($filename)) {
						break;
					}
					if($v['error']) {
						$this->error = $this->error($err, $filename, $v['size']);
						break;
					} else {
						if($v['name']) {
							$files_fount = true;
						}
						if($f = $this->uploadFile($v['tmp_name'], $filename)) {
							$files[] = $f;
						}
					}
				}
			}
		}
		
		if(!$files_fount) {
			if(!$this->options->files_require && !$this->upload_count)  {
				$ajax->flush();
				$ajax->message();
				return true;
			}
			$this->error = "No Files Were selected";
		}
		
		if(!$this->error) {
			if($this->post) {
				$ajax->ajaxVars($this->post);
			}
			$_files = implode(', ',$files);
			$message = $this->options->success_message;
			if(!$message) {
				$message = "File(s) $_files successfully uploaded.";
			} else {
				$message = str_replace("@files", $_files, $message);
			}
			$ajax->success($message, 5);
		} else {
			
			$ajax->warning($this->error, 5);
		}
		
	}
	
	/*
	 * abort the uploads
	 */
	function abort($error)
	{
		$ajax = ajax();
		
		$ajax->error($error, 8);
		
		exit();
	}

	function debug($options)
	{
		if($options && $options->debug) {
			$ajax = ajax();
			
			$options->{"Files Uploaded Successfully"} = $this->post;
				
			$settings['php.ini post_max_size'] = ini_get('post_max_size');
			$settings['php.ini upload_max_filesize'] = ini_get('upload_max_filesize');
			$settings['php.ini max_execution_time'] = ini_get('max_execution_time');
			$settings['CONTENT_LENGTH'] = @$_SERVER['CONTENT_LENGTH'].' bytes';
			
			$debug_message = null;
			if(is_string($options->debug)) {
				$debug_message = $options->debug."<br /><br />";
			}
			$ajax->dialog("
				$debug_message
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
	function chkExt($filename)
	{
		$info = pathinfo($filename);
		
		if($this->options->ext && is_array($this->options->ext)) {
			
			if(!in_array($info['extension'], $this->options->ext)) {
				$this->error = "File Extension: .{$info['extension']}  is not supported.";
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 
	 * Upload File
	 * @param unknown_type $tmp_name
	 * @param unknown_type $filename
	 */
	function uploadFile($tmp_name, $filename)
	{
		$info = pathinfo($filename);
		$filename = $info['filename'];
		
		$old_filename = $filename;
		if($prefix = $this->options->prefix) {
			if($prefix=='time') {
				$prefix = time();
			}
			if($prefix=='rand') {
				$prefix = rand(1, 10000000);
			}
			$filename = $prefix.'_'.$filename;
		}
		if($suffix = $this->options->suffix) {
			if($suffix=='time') {
				$suffix = time();
			}
			if($suffix=='rand') {
				$suffix = rand(1, 10000000);
			}
			$filename = $filename.'_'.$suffix;
		}
		
		$filename = $filename.'.'.$info['extension'];
		
		$ajax = ajax();
		
		
		$this->post['a'][] = $ajax->encode($filename);
		if(@move_uploaded_file($tmp_name,$this->options->target.$filename)) {
			$this->upload_count++;
			return $filename;
		} else {
			sleep(2);
			//try again
			if(!@copy($tmp_name,$this->options->target.$filename)) {
				$error = error_get_last();
				$this->error = "Could not upload file $filename. {$error['message']}";
			}
		}
		
	}

	/**
	 * 
	 * Check request length
	 */
	function chkLength()
	{
		if(isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH']) {
		
			$post_max = $_post_max = @ini_get('post_max_size');// / 8;
			
			$post_max = preg_replace("/([^0-9]+)/","", $post_max);
		
			switch (substr($_post_max,-1) )
			{
			case 'G':
				$post_max = $post_max * 1024;
			case 'M':
				$post_max = $post_max * 1024;
			case 'K':
				$post_max = $post_max * 1024;
			}
			
			if($_SERVER['CONTENT_LENGTH'] > $post_max) {
				$error = "Upload Failed. This server limits max upload to $_post_max (post_max_size in php.ini). ";
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
	function error($errorNo,$fileName, $size = 0)
	{
		$ajax  = ajax();
		$error = null;
		
		if($errorNo)  {
			switch($errorNo) {
				case UPLOAD_ERR_INI_SIZE:
					$_upload_max = @ini_get('upload_max_filesize');
					
					$error = "{$fileName} - File exceeds max upload limit of $_upload_max";
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
				$error = "$fileName Unkown Error Occurred.";
			}
		}
		
		return $error;
	}
}
new iframeUpload();
