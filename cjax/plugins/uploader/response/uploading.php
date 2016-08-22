<?php

/**
 * 
 * uploader 1.2
 * @author cj
 *
 */
class Uploading extends  uploader
{
	private $error;
	private $post;
	private $options;
	private $files;
	
	private $upload_count = 0;
	
	/**
	 * 
	 * Upload Files
	 */
	function upload()
	{
		$ajax  = ajax();
		$error = false;
		$files_fount = false;
		$files = array();
		$instance_id =  isset($_REQUEST['instance_id'])? $_REQUEST['instance_id']: 0;
		$use_debug = isset($_REQUEST['use_debug'])  && $_REQUEST['use_debug']? 1 : 0;
		$ajax->cacheWrapper(array("<html><body>","</body></html>"));
		$options = (object) $this->options = $ajax->get('Uploader_upload_options' . $instance_id, true);
		$options->use_debug = $use_debug;

		if(!$options->target) {
			$this->abort("No target directory.");
		}
		
		if(!is_writable($options->target )) {
			return $this->abort(sprintf("Directory %s is not writable.", $options->target));
		}
		
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
						$this->error = $this->error($v['error'], $filename, $v['size']);
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
		
		
		$this->debug($options);
		
		if(!$files_fount) {
			if(!$options->files_require && !$this->upload_count)  {
				$this->flush();
				$ajax->message();
				return true;
			}
			if(!$this->error) {
				$this->error = "No Files Were selected";
			}
		}


		
		if(!$this->error) {
			if($this->post) {
				$ajax->ajaxVars($this->post);
			}

			if($options->preview_container) {
				$preview_container = $options->preview_container;
				$preview_url = $options->preview_dir;
				if($ajax->config->preview_url) {
					$preview_url = $ajax->config->preview_url;
				}
				if($preview_url) {
					$preview_url = rtrim($preview_url,'/').'/';
				}

				$img_class = 'img';
				if($options->img_class) {
					$img_class = $options->img_class;
				}

				foreach($files as $k => $v) {
					$img = sprintf("<img class='%s' src='%s' />", $img_class, $preview_url . $v);
					if ($options->preview_type == 'single') {
						$ajax->update($preview_container, $img);
					} else {
						$ajax->insert($preview_container, $img);
					}
				}
				if($options->overlay) {
					$overlay_img_class = 'img_overlay';
					if($options->overlay_img_class) {
						$overlay_img_class = $options->overlay_img_class;
					}
					$ajax->click('.' . $img_class,
						array(
							$ajax->overlayContent(sprintf("<img class='%s' src='#' />", $overlay_img_class)),
							$ajax->updateX('.' . $overlay_img_class, 'src')
						)
					);
				}

			}
			
			$_files = implode(', ',$files);
			$message = $options->success_message;
			if($message) {
				$message = str_replace("@files", $_files, $message);
				$ajax->success($message);
			}
		} else {
			
			$ajax->warning($this->error, 10);
		}
		
	}
	
	public function flush()
	{
		CoreEvents::$lastCache = array();
		CoreEvents::$cache = array();
	}
	
	/*
	 * abort the uploads
	 */
	function abort($error)
	{
		$ajax = ajax();
		
		$ajax->error($error, 20);
		
		exit(0);
	}

	function debug($options)
	{
		if($options && $options->use_debug) {
			$ajax = ajax();
			
			$options->{"List Of Files Uploaded"} = $this->post;
				
			$settings['php.ini post_max_size'] = ini_get('post_max_size');
			$settings['php.ini upload_max_filesize'] = ini_get('upload_max_filesize');
			$settings['php.ini max_execution_time'] = ini_get('max_execution_time');
			$settings['CONTENT_LENGTH'] = @$_SERVER['CONTENT_LENGTH'].' bytes';

			$ajax->dialog("

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
			,"Debug Option is turned on this Demo");
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
		
			$this->files[] = $ajax->encode($filename);
		
		if(@move_uploaded_file($tmp_name,$this->options->target.$filename)) {
			$this->upload_count++;
			return $filename;
		} else {
			sleep(2);
			//try again
			if(!@copy($tmp_name,$this->options->target.$filename)) {
				$this->upload_count++;
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
