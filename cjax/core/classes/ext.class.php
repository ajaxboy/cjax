<?php

class ext {
	
	function __construct($array = array())
	{
		if($array && is_array($array) || is_object($array)) {
			foreach($array as $k => $v) {
				$this->{$k} = $v;
			}
		}
	}
	
	function __set($setting, $value)
	{
		$this->$setting = $value;
	}
	
	function __get($setting)
	{
		if(isset($this->$setting)) {
			return $this->$setting;
		}
	}
}