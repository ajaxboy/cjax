<?php
//@app_header;

/**
 * renamed from singleton to cjax_singleton to void problems with some hosts, having todo with name space
 */
class instanceFanctory {
	
	public static function cjax_autoload($class)
	{
		$file = CJAX_CORE.'/classes/'.$class.'.class.php';
		if(file_exists($file)) {
			require_once $file;
		}
	}
}

class cjax_singleton {
	static $instances = array();  // array of instance names
	
    static  function getInstance ($class,$param=null){
    // implements the 'singleton' design pattern.	
        if (!array_key_exists($class, self::$instances)) {
            // instance does not exist, so create it
            self::$instances[$class] = new $class;
        }
        $instance =& self::$instances[$class];
        return $instance;   
    } 
}
