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
*   File Last Changed:  04/06/2016           $     
**####################################################################################################    */   

namespace CJAX\Core;

class CJAX extends Framework{

	private static $CJAX;
		
        
	/**
	* get an instance of CJAX
	* with singleton pattern 
	* @return CJAX_FRAMEWORK OBJECT
	*/
	public static function getInstance(){
		if(self::$CJAX){
			return self::$CJAX;
		}		
		CoreEvents::errorHandlingConfig();
		$ajax = new self;
		if(!defined('JSON_FORCE_OBJECT')){
			define('JSON_FORCE_OBJECT', 16);
		}
		
		if(!isset($ajax->format) || !$ajax->format){
			$ajax->format = new Format;		
			$config = new Ext;
			if(file_exists($f = CJAX_HOME."/"."config.php")) {
				include($f);
				if(isset($config)){
					$config = new ext($config);
				}
			}
			$ajax->config = $config;
			
			$ajax->initiate($ajax);
			if(!$ajax->isAjaxRequest()){
				//$ajax->flushCache();
				if(defined('AJAX_CD')){
					@setcookie ('AJAX_CD', AJAX_CD, null, '/');
				} 
                else{
					//@setcookie ('AJAX_CD', null, time()-(3600*1000),'/');
				}
			} 
            else{
				if(isset($_COOKIE['AJAX_CD']) && !defined('AJAX_CD')){
					define('AJAX_CD', $_COOKIE['AJAX_CD']);
				}
				if(!function_exists('cleanInput')){
					function cleanInput($input){
						return $input;
					}
				}
			}
		}
        
		if($ajax->config->ipDebug){
			if(is_array($ajax->config->ipDebug)){
				if(in_array(@$_SERVER['REMOTE_ADDR'], $ajax->config->ipDebug)){
					$ajax->config->ipDebug = false;
				}
			} 
            else{
				if(@$_SERVER['REMOTE_ADDR']!=$ajax->config->ipDebug){
					$ajax->config->ipDebug = false;
				}
			}
		}
		
		if($ajax->config->caching){
			if(isset($_SERVER['REQUEST_URI'])){
				$ajax->crc32 = crc32($_SERVER['REQUEST_URI']);
				$cache = $ajax->readCache('cjax-'.$ajax->crc32);
				$ajax->caching = $cache;
			}
		}
		if($ajax->config->debug){
			@ini_set('display_errors', 1);
			@ini_set('log_errors', 1);
		}
		
		if(!$jsDir = $ajax->config->jsPath){
			if(@is_dir('cjax/')){
				$jsDir  = "cjax/assets/js/";
			} 
            elseif(@is_dir('assets/js/')){
				$jsDir  = "assets/js/";
			} 
            elseif(@is_dir('../cjax')){
				$jsDir  = "../cjax/assets/js/";
			} 
            elseif(@is_dir('../../cjax')){
				$jsDir  = "../../cjax/assets/js/";
			} 
            elseif(@is_dir('../../../cjax')){
				$jsDir  = "../../../cjax/assets/js/";
			} 
            else{
				die("Cannot find the correct path to Js directory.");
			}
			
			$error = error_get_last();			
			if($error && preg_match('%.*(open_basedir).*File\(([^\)]+)%', $error['message'], $match)){
				die(sprintf('Restriction <b>open_basedir</b> is turned on. File or directory %s will not be accessible while this setting is on due to security directory range.', $match[2]));
			}
		}
		$ajax->js($jsDir);
		
		return self::$CJAX = $ajax;
	}

    public function initiateRequest(){
        if(!$this->handleModRewrite()) return;
        $this->handleFriendlyURLs();        
    }

    private function handleModRewrite(){
        if(isset($_SERVER['REDIRECT_QUERY_STRING']) && $_SERVER['REDIRECT_QUERY_STRING']){
        	$_SERVER['QUERY_STRING'] = $_SERVER['REDIRECT_QUERY_STRING'];
        } 
        elseif(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] && !$_SERVER['QUERY_STRING']){
	        $_SERVER['QUERY_STRING'] = ltrim($_SERVER['PATH_INFO'],'/');
        }

        $file = 'ajax.php';
        if(isset($_SERVER['SCRIPT_NAME'])){
	        $file = preg_replace("/.+\//",'', ltrim($_SERVER['SCRIPT_NAME'],'/'));
        }
        if(defined('AJAX_FILE') && AJAX_FILE != $file){
	        return false;
        }
        return true;
    }

    private function handleFriendlyURLs(){
        if(isset($_SERVER['QUERY_STRING']) && $query = $_SERVER['QUERY_STRING']){
        	$packet = explode('/' ,rtrim($query,'/'));
        	if(count($packet) == 1) {
                $this->handlePlugin($packet[0]);
	        }
        	if($this->isAjaxRequest() || defined('AJAX_VIEW') ){
                $this->handleController($packet);
	        }
        }

        if(!$this->isAjaxRequest()){
	        if(count(array_keys(debug_backtrace(false))) == 1 && !defined('AJAX_VIEW')){
		        exit("Security Error. You cannot access this file directly.");
        	}
        }
    }

    private function handlePlugin($isPlugin = null){
	    if($plugin = $this->isPlugin($isPlugin)){
		    if(!defined('AJAX_VIEW')){
		        define('AJAX_VIEW', true);
	        }
	    }        
    }

    private function handleController($packet = null){
	    if($packet && count(array_keys($packet)) >= 2 && $packet[0] && $packet[1]){
		    $_REQUEST['controller'] = $packet[0];
		    $_REQUEST['function'] = $packet[1];
		    $_REQUEST['cjax'] = time();
		    if(count(array_keys($packet)) > 2){
			    unset($packet[0]);
				unset($packet[1]);
				if($packet){
				    $params = range('a','z');
					foreach($packet as $k  => $v){
					    $_REQUEST[current($params)] = $v;
						next($params);
				    }
				}
		    }
		} 
        else{
		    if(!$this->input('controller')){
			    if(count($packet)==1){
				    $url = explode('&',$_SERVER['QUERY_STRING']);
				    if(count($url) ==1){
					    $_REQUEST['controller'] = $packet[0];
				    }
			    }
		    }
	    }        
    }
}

function ajax(){
	return CJAX::getInstance();
}