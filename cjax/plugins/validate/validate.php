<?php

/**
 * 
 * validate @validate;
 * 
 * @author cj
 *
 */
 
namespace CJAX\Plugins\Validate; 
use CJAX\Core\CJAX;
use CJAX\Core\Plugin;
 
class Validate extends Plugin{
	
	private $rules;
	
	/**
	 * 
	 * Handles right api assignments eg:
	 * 
	 * $ajax->overlay()->validate();
	 * $ajax->call()->validate();
	 * etc...
	 * @param string $api - internal API name 
	 * @param array $args
	 */
	public function rightHandler($api, $args, $xmlObj){
		switch($api){
			case '_overLay':				
				$xmlObj->callback = $this;
				break;
			case '_overLayContent':
				$xmlObj->callback = $this;
				break;
			default:
				$xmlObj->callback = $this;
		}
		
	}
	
	function onLoad($buttonId, $postUrl, $rules = [], $importJs = false){
		$ajax = CJAX::getInstance();
		$this->callback($ajax->click($buttonId,$ajax->form($postUrl)));	
		
		if($importJs){
			$this->import('jquery.validate.min.js');
		}		
		$this->rules = $rules;
	}
	
	public function onAjaxLoad($buttonId, $postUrl, $rules = []){
		return $this->onLoad($buttonId, $postUrl, $rules);
	}
	
	/**
	 * 
	 * Add additional rules
	 * @param unknown_type $name
	 * @param unknown_type $rule
	 */
	public function rule($name, $rule){
		if(!$rule){
			return;
		}
		$rules = $this->rules['rules'];
		$messages  = $this->rules['messages'];
		
		foreach($rule as $k => $v){
			if(is_array($v)){
				if(isset($v[0])){
					$rules[$name][$k] = $v[0];
				}
				if(isset($v[1])){
					$messages[$name][$k] = $v[1];
				}
			} 
            else{
				$rules[$name][$k] = $v;
			}
		}
		$this->rules['rules'] = $rules;
		$this->rules['messages'] = $messages;
		
		$this->set('c', $this->rules);
	}
}