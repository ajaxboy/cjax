<?php

/**
 * 
 * validate @validate;
 * 
 * @author cj
 *
 */
class Validate extends plugin {
	
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
	function rightHandler($api, $args, $xmlObj)
	{
		switch($api) {
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
	
	function onLoad($button_id, $post_url, $rules = array(), $import_js = false)
	{
		$ajax = ajax();

		$ajax->on('validate', $ajax->form($post_url));

		$this->rules = $rules;
	}
	
	function onAjaxLoad($button_id, $post_url, $rules = array())
	{
		return $this->onLoad($button_id,$post_url, $rules);
	}
	
	/**
	 * 
	 * Add additional rules
	 * @param unknown_type $name
	 * @param unknown_type $rule
	 */
	function rule($name, $rule)
	{
		if(!$rule) {
			return;
		}
		$rules = $this->rules['rules'];
		$messages  = $this->rules['messages'];
		
		foreach($rule as $k => $v) {
			if(is_array($v)) {
				if(isset($v[0])) {
					$rules[$name][$k] = $v[0];
				}
				if(isset($v[1])) {
					$messages[$name][$k] = $v[1];
				}
			} else {
				$rules[$name][$k] = $v;
			}
		}
		$this->rules['rules'] = $rules;
		$this->rules['messages'] = $messages;
		
		$this->set('c', $this->rules);
	}
}