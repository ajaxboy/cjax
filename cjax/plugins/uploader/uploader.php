<?php

/**
 * 
 * Ajax Uploader 2.0
 * @author cj
 *
 */

namespace CJAX\Plugins\Uploader;
use CJAX\Core\CJAX;
use CJAX\Core\CoreEvents;
use CJAX\Core\Plugin; 
 
class Uploader extends Plugin{
	
	private $options = [];
	
	private $callbackId;
	
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
	public function rightHandler($api, $args, $xmlObj){
		$xmlObj->postCallback = $this;
	}
		
	/**
	 * Right handler routed
	 * 
	 * handles chain call $ajax->someApi->uploader();
	 * 
	 * @param unknown_type $value
	 */
	public function callbackHandler($sender, $receiver, $setting){
        $coreEvents = new CoreEvents;
		switch($setting){
			case 'postCallback':
				$event = CoreEvents::$cache[$receiver->id];				
				$callback = CoreEvents::$cache[$sender->id];				
				$event['postCallback'][$sender->id] = $callback;
				$sender->delete();
				
				$callbacks = $coreEvents->processScache($event['postCallback']);
				$callbacks = $coreEvents->mkArray($callbacks,'json', true);
				$event['postCallback'] =  "<cjax>{$callbacks}</cjax>";				
				CoreEvents::$cache[$receiver->id] = $event;				
				$coreEvents->simpleCommit();
			break;
		}
	}
	
	public function preview($previewUrl, $data = []){
		$ajax = CJAX::getInstance();
		if($ajax->config->previewUrl){
			$previewUrl = $ajax->config->previewUrl;
		}
		$this->options['preview'] = $data;
		$this->options['preview_url'] = $previewUrl;
		$ajax->save('upload_options', $this->options);
	}
	
	public function onLoad($btnId =  null, $targetDirectory = null, $options = []){
		if(is_array($btnId) && !$options){
			$options = $btnId;
			$btnId = null;
			
			if(isset($options['dir'])){
				$targetDirectory = $options['dir'];
			}
		}
		$ajax = CJAX::getInstance();
		foreach($options as $k =>$v){
			$this->{$k} = $v;
		}
		if(isset($options['before'])){
			$this->set('a', $options);
		}
		
		if($ajax->config->uploaderDir){
			$targetDirectory = $ajax->config->uploaderDir;
		}
		if(!$targetDirectory){
			$targetDirectory = './';
		}

		if(!is_writable($targetDirectory) && !is_writable("../{$targetDirectory}")){
			return $ajax->warning("Cjax Upload: Directory '{$targetDirectory}' is not writable, , aborting..",5);
		}
		if(!isset($options['text'])){
			$options['text'] = 'Uploading File(s)...';
		}
		if(!isset($options['ext'])){
			$options['ext'] = ['jpg','jpeg','gif','png'];
		}
		if(!isset($options['files_require'])){
			$options['files_require'] = true;
		}
		if(!isset($options['form_id'])){
			$options['form_id'] = null;
		}
		$ajax->text = $options['text'];
		$target = rtrim($targetDirectory,'/') . '/';
		
		if(!isset($options['url'])){
			$options['url'] = null;
		}
		
		if(!isset($options['target'])){
            $root = (defined('CJAX_ROOT'))?CJAX_ROOT."/":"";         
			$options['target'] = $root.$target;
		}
		$ajax->save('uploadOptions', $options);
			
		if(!$btnId || is_array($btnId)){
			$xml = $ajax->form($options['url'], $options['form_id']);
		} 
        else{
			$xml = $ajax->exec($btnId, $ajax->form($options['url'], $options['form_id']));
		}
		$this->options = $options;
		$this->callback($xml);
	}
	
	public function onAjaxLoad($btnId, $targetDirectory, $options = []){
		return $this->onLoad($btnId, $targetDirectory, $options);
	}
}