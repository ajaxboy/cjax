<?php
/** ################################################################################################**
 * CJ Galindo Copyright (c) .
 * Permission is granted to copy, distribute and/or modify this document
 * under the terms of the GNU Free Documentation License, Version 1.2
 * or any later version published by the Free Software Foundation;
 * Provided 'as is' with no warranties, nor shall the autor be responsible for any mis-use of the same.
 * A copy of the license is included in the section entitled 'GNU Free Documentation License'.
 *
 *   ajax made easy with cjax
 *   -- DO NOT REMOVE THIS --
 *   -- AUTHOR COPYRIGHT MUST REMAIN INTACT -
 *   Written by: CJ Galindo
 *   Website: http://cjax.sourceforge.net                     $
 *   Email: cjxxi@msn.com
 *   Date: 2/12/2007                           $
 *   File Last Changed:  10/05/2013            $
 **####################################################################################################    */


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
