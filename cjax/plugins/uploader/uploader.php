<?php

/**
 * 
 * //@uploader;
 * @author cj
 *
 */
class uploader extends plugin {
	
	private $options = array();
	
	private $callback_id;
	
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
	
	function preview($preview_url, $data = array())
	{
		$ajax = ajax();
		if($ajax->config->preview_url) {
			$preview_url = $ajax->config->preview_url;
		}
		$this->options['preview'] = $data;
		$this->options['preview_url'] = $preview_url;
		$ajax->save('upload_options', $this->options);
	}
	
	function onLoad($btn_id =  null, $target_directory = null, $options = array())
	{
		if(is_array($btn_id) && !$options) {
			$options = $btn_id;
			$btn_id = null;
			
			if(isset($options['dir'])) {
				$target_directory = $options['dir'];
			}
		}
		$ajax = ajax();
		foreach($options as $k =>$v) {
			$this->{$k} = $v;
		}
		if(isset($options['before'])) {
			$this->set('a', $options);
		}
		
		if($ajax->config->uploader_dir) {
			$target_directory = $ajax->config->uploader_dir;
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
		
		if(!isset($options['url'])) {
			$options['url'] = null;
		}
		
		if(!isset($options['target'])) {
			$options['target'] = $target;
		}
		$ajax->save('upload_options', $options);
			
		if(!$btn_id || is_array($btn_id)) {
			$xml = $ajax->form($options['url'], $options['form_id']);
		} else {
			$xml = $ajax->Exec($btn_id, $ajax->form($options['url'], $options['form_id']));
		}
		$this->options = $options;
		$this->callback($xml);
	}
	
	function onAjaxLoad($btn_id, $target_directory, $options = array())
	{
		return $this->onLoad($btn_id, $target_directory, $options);
	}
	
}