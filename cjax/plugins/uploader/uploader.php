<?php

/**
 * 
 * //@uploader;
 * @author cj
 *
 */
class uploader extends plugin {
	
	private $options = array();

	public $controller = 'uploading';
	
	private $callback_id;



	function onLoad($options = array(), $target_directory = null)
	{
		if(is_array($target_directory) && !$options) {
			$options = $target_directory;

			if(isset($options['dir'])) {
				$target_directory = $options['dir'];
			}
		}
		$instance_id = $this->_id;
		$ajax = ajax();

		if($ajax->config->upload_dir) {
			$target_directory = $ajax->config->upload_dir;
		}
		if(!$target_directory) {
			$target_directory = './';
		}
		if(!is_writable($target_directory)) {
			return $ajax->warning("Cjax Upload: Directory '$target_directory' is not writable, , aborting..",5);
		}
		if(!isset($options['text'])) {
			$options['text'] = 'Uploading File(s)...';
		}
		if(!isset($options['ext'])) {
			$options['ext'] = array('jpg','jpeg','gif','png');
		}
		if(!isset($options['files_require'])) {
			$options['files_require'] = true;
		}
		if(!isset($options['form_id']) ) {
			$options['form_id'] = null;
		}
		$ajax->text = $options['text'];
		$target = rtrim($target_directory,'/') . '/';

		if(!isset($options['before'])) {
			$options['url'] = null;
		}

		if(!isset($options['target'])) {
			$options['target'] = $target;
		}
		$options['instance_id'] = $instance_id;
		$this->set('a', $options, $instance_id);
		//usually we call save, but there could be more than one instance.
		$this->save('upload_options' . $instance_id, $options);

		$this->options = $options;
	}
	
	/**
	 * 
	 * Handles right api assignments eg:
	 * 
	 * $ajax->validate()->uploader();
	 * $ajax->call()->uploader();
	 * etc...
	 * @param string $api - internal API name 
	 * @param array $args
	 */
	function rightHandler($api, $args, $xmlObj)
	{
		$xmlObj->postCallback = $this;
	}
		
	/**
	 * Right handler routed
	 * 
	 * handles chain call $ajax->someApi->uploader();
	 * 
	 * @param unknown_type $value
	 */
	function callbackHandler($sender , $receiver, $setting)
	{
		switch($setting) {
			case 'postCallback':
				$event = CoreEvents::$cache[$receiver->id];
				
				$callback = CoreEvents::$cache[$sender->id];
				
				$event['postCallback'][$sender->id] = $callback;
				$sender->delete();
				
				$callbacks = CoreEvents::processScache($event['postCallback']);
				$callbacks = CoreEvents::mkArray($callbacks,'json', true);
				$event['postCallback'] =  "<cjax>$callbacks</cjax>";
				
				CoreEvents::$cache[$receiver->id] = $event;
				
				CoreEvents::simpleCommit();
			break;
		}
	}
	
	function onAjaxLoad($options = array(), $target_directory = null)
	{
		return $this->onLoad($options, $$target_directory);
	}
	
}