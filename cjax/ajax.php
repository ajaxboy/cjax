<?php

/** ################################################################################################**   
* Copyright (c)  2008  CJ.   
* Permission is granted to copy, distribute and/or modify this document   
* under the terms of the GNU Free Documentation License, Version 1.2   
* or any later version published by the Free Software Foundation;   
* Provided 'as is' with no warranties, nor shall the author be responsible for any misuse of the same.     
* A copy of the license is included in the section entitled 'GNU Free Documentation License'.   
*   
*   CJAX  6.0               $     
*   ajax made easy with cjax                    
*   -- DO NOT REMOVE THIS --                    
*   -- AUTHOR COPYRIGHT MUST REMAIN INTACT -   
*   Written by: CJ Galindo                  
*   Website: http://cjax.sourceforge.net                     $      
*   Email: cjxxi@msn.com    
*   Date: 2/12/2007                           $     
*   File Last Changed:  04/18/2016            $     
**####################################################################################################    */   

require_once __DIR__."/autoloader.php";
use CJAX\AjaxAuth;
use CJAX\Core\CJAX; 
use CJAX\Core\CoreEvents;
use CJAX\Core\Ext;
 
final class AJAX{
	
    private $ajax;
    
    
	public function __construct($controller){
		$this->ajax = CJAX::getInstance();
		$controller = $rawClass = preg_replace('/:.*/', '', $controller);
		$function = isset($_REQUEST['function'])? $_REQUEST['function']: null;		
		if($this->ajax->config->camelize){
			$rawClass = $this->ajax->camelize($rawClass, $this->ajax->config->camelizeUcfirst);
		}
		$requestObject = null;
		$altController = null;
		
        $this->_validate($controller, $function);      	
		$args = $this->_params();
		if($controller == '_crossdomain'){
            $method = new ReflectionMethod($this->ajax, 'crossdomain');
			return $this->_response($method->invokeArgs($this->ajax, $this->_event($method, $args)));
		}	
        if($plugin = $this->ajax->plugin($controller, true)){ 
            if(method_exists($plugin, $function)){
                $method = new ReflectionMethod($plugin, $function);
                return $this->_response($method->invokeArgs($plugin, $this->_event($method, $args)));
            } 
            else{
                $altController = $plugin->controllerFile;
                if(!file_exists($altController)){
                    $this->abort("{$controller} Plugin: Controller File Not Found.");
                }
            }
        }

		$isFile = $this->_files($controller, $altController);	
        $requestObject = ($isFile)? $this->_controller($controller, $function): $requestObject;	
        if($this->_auth($controller, $function, $args, $requestObject)){
            return;
        }
    
        $function = ($function)? $function: $rawClass;
        $this->_exists($isFile, $controller, $rawClass, $requestObject, $controller, $function);        
        $method = new ReflectionMethod($requestObject, $function);
        $this->_response($method->invokeArgs($requestObject, $this->_event($method, $args)));
	}
    
	public function abort($err){
		$this->ajax->error($err);
		exit($err);
	}
    
    private function _validate($controller, $function){
		if(preg_match("/[^a-zA-Z0-9_]/", $controller)){
			$this->abort("Invalid Controller: {$controller}");
		}
		if($function && preg_match("/[^a-zA-Z0-9_]/", $function)){
			//if function is empty, it still passes.
			$this->abort("Invalid Function: {$function}");
		} 
		if(file_exists($f = CJAX_HOME.'/'.'includes.php')){
			if(!defined('AJAX_INCLUDES')){
				$this->ajax->includes = true;
				include_once $f;
			}
		}          
    }
    
    private function _exists($isFile, $class, $rawClass, $requestObject, $controller, $function){
		if(!$isFile){
			header("Content-disposition:inline; filename='{$controller}.php'");
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 Not Found");
			$this->abort("Controller File: {$controller}.php not found");
		}
		if(!$class){
			$this->abort("Controller Class \"{$rawClass}\" could not be found.");
		}
		if(!method_exists($requestObject, $function)){
			$this->abort("Controller Method/Function: {$rawClass}::{$function}() was not found");
		}        
    }
    
    private function _auth($controller, $function, $args, $requestObject){
		if(file_exists($f = CJAX_HOME.'/auth.php')){
			require_once $f;
			if(class_exists('AjaxAuth')){
				$auth = new AjaxAuth;
				if(!$auth->validate($controller, $function, $args, $requestObject)) {
					$auth->authError();
                    return true;
				}
			} 
            else{
				$this->abort("Class AjaxAuth was not found.");
			}
			if(method_exists($auth, 'intercept') && $_response = $auth->intercept($controller, $function , $args, $requestObject)){
				if(is_array($_response) || is_object($_response)){
					$this->_response($_response);
				}
				return true;
			}
		}
        return false;        
    }
    
    private function _event($method, $args){
        $parameters = $method->getParameters();
        if($parameters){
            $parameterClass = $parameters[0]->getClass();
            if($parameterClass && $parameterClass->getNamespaceName() == "CJAX\\Event"){
                array_unshift($args, $parameterClass->newInstance(json_decode($_COOKIE['cjaxevent'])));
            }
        } 
        return $args;        
    }
    
	private function _response($response){
		if($response && (is_array($response) || is_object($response))){
            $coreEvents = new CoreEvents;
			header('Content-type: application/json; charset=utf-8');
			print $coreEvents->jsonEncode($response);
		}		
	}
	
	private function _files($controller, $altController = null){
		if($altController){
			$files[] = $altController;
		}
		if(defined('AJAX_CD')){
			$ajaxCd = AJAX_CD;
		} 
        elseif(isset($_COOKIE['AJAX_CD']) && $_COOKIE['AJAX_CD']){
			$ajaxCd = $_COOKIE['AJAX_CD'];
		}
		
		$files[] = "{$ajaxCd}/{$controller}.php";
		$files[] = "{$this->ajax->controllerDir}/{$ajaxCd}/{$controller}.php";
		$files[] = CJAX_ROOT."/{$ajaxCd}/{$controller}.php";
		
		do{
			if(file_exists($f = $files[key($files)])){
				require_once $f;
				return $f;
			}
		}while(next($files));
	}
	
	private function _params(){
		$args = [];
		$argCount = count(array_keys($_REQUEST)) - 3;
		foreach(range('a','z') as $k => $v){
			if(isset($_REQUEST[$v])){
				if(is_array($_REQUEST[$v])){
					foreach($_REQUEST[$v] as $k2 => $v2){
                        $args[$v][$k2] = (is_array($_REQUEST[$v][$k2]))
                                         ? array_map('urldecode', $_REQUEST[$v][$k2])
                                         : urldecode($_REQUEST[$v][$k2]);
					}
				} 
               else{
					$args[$v] = urldecode($_REQUEST[$v]);
				}
			}
            else{
				$args[$v] = null;
			}
			if($k >= $argCount){
				break;
			}
		}
		if(function_exists('cleanInput')){
			$args = cleanInput($args);
			$_REQUEST = cleanInput($_REQUEST,'_REQUEST');
			$_POST = cleanInput($_POST,'_POST');
			$_GET = cleanInput($_GET,'_GET');
		}
		
		foreach($args as $k => $v){
            $this->ajax->{$k} = (is_array($v))? new Ext($v): $v;
		}
		return $args;
	}
	
	
	private function _controller($class, $function){
		if(!$class){
			return false;
		}

        if($this->ajax->plugin($class, true)){
            $class = "CJAX\\Plugins\\{$class}\\Controllers\\{$class}";
        }
        else{
            $className = ucwords(AJAX_CD."/".$class, "/");
            $class = str_replace("/", "\\", $className);
        }
	    return new $class($this->ajax);
	}
    
    public static function main(){
        $base = realpath(__DIR__.'/..');
        defined('CJAX_ROOT') or define('CJAX_ROOT', $base);
        defined('AJAX_BASE') or define('AJAX_BASE', "{$base}/cjax/");
        defined('CJAX_HOME') or define('CJAX_HOME', "{$base}/cjax");
        defined('CJAX_CORE') or define('CJAX_CORE', "{$base}/cjax/core");   
        define('AJAX_CONTROLLER',1);
        if(!defined('AJAX_CD')){
	        define('AJAX_CD', 'controllers');
        }  

        $ajax = CJAX::getInstance();
        $ajax->initiateRequest();
        $ajax->initiatePlugins();
        $controller = $ajax->input('controller');
        if($controller){
	        new self($controller);
        }   
    }
}

AJAX::main();
$ajax = CJAX::getInstance();