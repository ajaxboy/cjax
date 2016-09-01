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
 * Load core events
 */
require_once 'core.class.php';
require_once 'xmlItem.class.php';
class CJAX_FRAMEWORK Extends CoreEvents {

	function click($element_id, $actions = array())
	{
		if(!$actions) {
			return $this->__call('click', $element_id);
		}
		return $this->Exec($element_id, $actions);
	}

	function change($element_id, $actions)
	{
		return $this->Exec($element_id, $actions,'change');
	}

	function blur($element_id, $actions)
	{
		if(!$actions) {
			return $this->__call('blur', $element_id);
		}
		return $this->Exec($element_id, $actions,'blur');
	}

	function keyup($element_id, $actions)
	{
		return $this->Exec($element_id, $actions,'keyup');
	}

	function keydown($element_id, $actions)
	{
		return $this->Exec($element_id, $actions,'keydown');
	}

	function keypress($element_id, $actions, $key = null)
	{
		if($key && is_a($actions,'xmlItem')) {
			if(is_array($key)) {
				foreach($key as $k => $v) {
					if($v=='enter') $v = 13;
					$_keys[$v] = $v;
				}
			} else {
				$_keys = array($key => $key);
			}
			$actions->key = $_keys;
			$actions->buffer = array('key'=> $_keys);
		}
		return $this->Exec($element_id, $actions,'keypress');;
	}

	function toggle($container_id, $label1 =  'Show', $label2 = 'Hide')
	{
		$data['do'] = 'toggle';
		$data['container_id'] = $container_id;
		$data['label1'] = $label1;
		$data['label2'] = $label2;

		return $this->xmlItem($this->xml($data),'toggle','api');
	}

	public function __get($setting)
	{
		/*$value = self::input($setting);
		if(!$value) {
			if($a = self::input('a')) {
				if(isset($a[$setting])) {
					$value = $a[$setting];
				}
			}
		}
		if($value && function_exists('cleanInput')) {
			$value = cleanInput($value);
		}
		return $value;*/
	}

	public function __call($method, $args)
	{
		$params = range('a','z');

		$pParams = array();
		if($args) {
			if(!is_array($args)) {
				$args = array($args);
			}
			foreach($args as $v) {
				$pParams[current($params)] =  $v;
				next($params);
			}
		}

		if(self::isPlugin($method)) {
			$entry_id = null;
			if($pParams) {
				$params = func_get_args();
				$data['do'] = plugin::method($method);
				$data['is_plugin'] = $method;
				$data['options'] = $pParams;
				$data['file'] = plugin::file($method);
				$data['filename'] = preg_replace("/.*\//",'', $data['file']);

				$entry_id = $this->xmlItem($this->xml($data), $method)->id;
			}
			$plugin = plugin::getPluginInstance($method, $params , $entry_id);
			if($pParams) {
				plugin::instanceTriggers($plugin, $pParams);
			}
			return $plugin;
		} else {
			$data = array();
			$data['do'] = '_fn';
			$data['fn'] = $method;

			$data['options'] = $pParams;

			$item = $this->xmlItem($this->xml($data),'fn');
			$item->selector = $method;
			return  $item;
		}
	}

	/**
	 *
	 * Prevent other APIS and saving them to stack that can be retrived by plugins.
	 * @param unknown_type $count
	 * @param unknown_type $call_id
	 */
	function prevent($plugin_name,$id, $count = 1)
	{
		$data['do'] = 'prevent';
		$data['count'] = $count;
		$data['uniqid'] = $id;
		$data['plugin_name'] = $plugin_name;
		$this->xml($data);
	}

	/**
	 * Bind events to elements
	 *
	 * @param $selector
	 * @param $actions
	 * @param $event
	 */
	function Exec($selector , $actions , $event="click")
	{
		if(!self::getCache()) {
			return false;
		}
		if(is_array($selector)) {
			$selector = implode(',', $selector);
		}
		if($event) {
			if(substr($event, 0,2)  != "on" && $event!='click') {
				$event = "on{$event}";
			}
			$this->event = $event;
		}
		$_actions =  array();

		if($actions && is_array($actions)) {

			$cache = CoreEvents::$cache;

			foreach($actions as $k => $v) {
				if(is_object($v) && (is_a($v, 'xmlItem') || is_a($v,'plugin'))) {
					if(is_a($v,'plugin')) {
						$v->element_id = $selector;
						$v->xml->element_id = $selector;
						if(method_exists($v, 'onEvent')) {
							call_user_method('onEvent', $v, $selector);
						}
					}

					if(isset(CoreEvents::$callbacks[$v->id]) && CoreEvents::$callbacks[$v->id]) {
						$v->attach(CoreEvents::$callbacks[$v->id]);
						foreach(CoreEvents::$callbacks[$v->id] as $k2 => $v2) {
							unset(CoreEvents::$cache[$k2]);
						}

					}
					$_actions[$v->id] = $v->xml();
					$v->delete();
				} else {
					if(is_object($v))  {
						//some functions return the ajax object?
						continue;
					}
					$_actions[$v] = CoreEvents::$cache[$v];
					unset(CoreEvents::$cache[$v]);
				}
			}
			return $this->AddEventTo($selector,$_actions, $event);
		}

		if(is_a($actions,'xmlItem') || is_a($actions,'plugin')) {
			if(is_a($actions,'plugin')) {
				$actions->element_id = $selector;
				$actions->xml->element_id = $selector;
				$actions->xml->event_element_id = $selector;
				if(method_exists($actions, 'onEvent')) {
					call_user_method('onEvent', $actions, $selector);
				}
			}

			$item = $actions->xml();
			$item['event'] = $event;
			if(isset(CoreEvents::$callbacks[$actions->id]) && CoreEvents::$callbacks[$actions->id]) {
				$item['callback'] = CoreEvents::processScache(CoreEvents::$callbacks[$actions->id]);
				$item['callback'] = CoreEvents::mkArray($item['callback'],'json', true);
			}
			$actions->delete();
			return $this->AddEventTo($selector, array($actions->id => $item),$event);
		} else {
			$_actions = CoreEvents::$cache[$actions];
			$_actions['event'] = $event;
			$this->removeLastCache(1);
			return $this->AddEventTo($selector, array($actions => $_actions),$event);
		}
	}

	/**
	 *
	 *  Uses call() to post stuff
	 */
	function post($url, $vars = array())
	{
		if(is_array($vars)) {
			$this->post = $vars;
		} else if(!$vars) {
			$vars = parse_url($url, PHP_URL_PATH);
		}
		$this->call($url);
	}


	/**
	 *
	 * Making several requests without Exec event.
	 * This is an alternative to call() when the requests go so fast and need just a little timeout to work properly.
	 *
	 * @param unknown_type $url
	 * @param unknown_type $container_id
	 * @param unknown_type $confirm
	 */
	function callc($url, $container_id=null, $confirm=null)
	{
		$this->wait(200, true);// 200 milliseconds
		return $this->call($url, $container_id, $confirm);
	}

	private function urlAccess($url = array(), &$options = array())
	{
		$controller = $url[0];
		$method = $url[1];
		$params = (isset($url[2])) ? $url[2] : null;

		$_options = (isset($url[3])) ? $url[3] : null;

		$_params = null;
		if ($params && !is_array($params)) {
			$params = array($params);
		}
		if ($params) {

			foreach ($params as $v) {
				$_params[] = '|' . $v . '|';
			}
			$_params = '/' . implode('/', $_params);
		}

		if ($_options) {
			//merged any passed options, this gets pulled back and sent to ajax options.
			$options = array_merge($options, $_options);
		}

		//$cwd = getcwd();

		$f = 'ajax.php';

		$path = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']);
		$path2 = str_replace($_SERVER['SCRIPT_NAME'], '', $path);
		$file_path = dirname($_SERVER['SCRIPT_NAME']) . '/';
		$count = substr_count($file_path, '/') - 1;

		if (is_file($path . $file_path . AJAX_FILE)) {
			//ajax.php is found inside the directory in the script that called it, so you call it relative.
			$f = AJAX_FILE;
		} else if (dirname($path . $file_path) . AJAX_FILE) {
			$f = '../' . AJAX_FILE;
		} else {
			$path = dirname(dirname(dirname(ajax()->config->js_path)));
			if ($path) {
				$f = $path . '/' . AJAX_FILE;
			}
		}

		$cwd = getcwd();

		if (!is_file($cwd . '/' . $f)) {
			do {
				$sub = str_repeat('../', $count);
				$f_path = $sub  .   $f;
				$new_file = $cwd . '/' . $f_path;
				if(is_file($new_file)) {
					$f = $f_path;
					break;
				}
			} while ($count && $count--) ;
		}

		$url = sprintf('%s?%s/%s%s', $f, $controller, $method, $_params);

		return $url;
	}

	/**
	 * Create Ajax calls
	 *
	 * @param required string $url
	 * @param optional string $elem_id = null
	 * @param optional string $cmode = 'get'
	 * @return string
	 */
	public function call($url, $container_id=null, $confirm=null)
	{
		$out = array();
		$out['do'] = '_call';

		if(is_array($url)) {
			$out['options'] = array();
			$url = $this->urlAccess($url, $out['options']);
		}
		$ajax = ajax();

		if(preg_match('/^https?/', $url)) {
			$out['crossdomain'] = true;
		}

		$out['url'] = $url;

		if($ajax->post)  {
			if(is_array($ajax->post)) {
				$args = http_build_query($ajax->post);
				$out['args'] = $args;
				$out['post'] = true;
			} else {
				$out['post'] = true;
			}
		}

		if($container_id) $out['container_id'] = $container_id;
		if(is_bool($ajax->text) && $ajax->text===false) {
			$out['text'] = "no_text";
		} else if($ajax->text) {
			$out['text'] = "{$ajax->text}";
		}

		if($confirm) $out['confirm'] = $confirm;

		if($ajax->loading) {
			$out['is_loading'] = true;
		}

		return $this->xmlItem($this->xml($out),'call','api');
	}


	public function __set($setting, $value)
	{
		if($this->isPlugin($setting)) {
			//is a plugin..
			return;
		}
		if(is_object($value)) {
			switch($value->name) {
				case 'call':
					$value->container_id = $setting;
					break;
				case 'form':
					$this->Exec($setting, $value->id);
					break;
			}
			return self::simpleCommit();
		} else {
			$xml =  $this->property($setting,$value);
			if(!ajax()->isAjaxRequest()) {
				self::simpleCommit();
			}
			return $xml;
		}
	}

	/**
	 *
	 * is used to pass extra variables to POST ajax.
	 * currently used in iframe uploads
	 *
	 * @param unknown_type $vars
	 */
	function ajaxVars($vars)
	{
		$data['do'] = 'ajaxVars';
		if(is_array($vars)) {
			$vars = http_build_query($vars);
		}
		$data['vars'] = $vars;
		$this->xml($data);
	}

	public function dialog($content, $title = null,$options = array())
	{
		$content = $this->format->_dialog($content, $title);
		return $this->overlayContent($content, $options);
	}

	/**
	 *
	 * Show overlay dialog provided information
	 * @param unknown_type $data
	 * @param unknown_type $title
	 */
	function debug($data, $title ='Debug Information', $extra = null)
	{
		if($extra) {
			$extra .= '<br />';
		}
		$this->dialog($extra.'<pre>'.print_r($data,1).'</pre>', $title, array('top'=> 100));
	}

	/**
	 * *set value to an element
	 * @param string $element_id
	 * @param string $value
	 */
	public function property($element_id,$value='',$clear_default=false,$select_text=false)
	{
		$options = array();
		$options['do']  = 'property';
		$options['element_id'] = $element_id;
		$options['clear_text'] = $clear_default;
		$options['select_text'] = $select_text;
		$options['value'] = $value;
		//$options['options'] = $this->mkArray($options);

		return $this->xml($options);
	}

	function select($element, $options = array(), $selected = null,$allow_input = false)
	{
		$select['do'] = 'select';
		$select['element_id'] = $element;
		$select['selected'] = $selected;
		$select['options'] = $options;
		$select['allow_input'] = $allow_input;

		return $this->xml($select);
	}

	public function on($response_type, $actions)
	{
		$actions = CoreEvents::delegateActions($actions);
		$out = array(
			'do' => 'on',
			'type' => $response_type,
			'options' => $actions
		);

		$this->xmlItem($this->xml($out),'on','api');

		return $this;
	}

	/**
	 * Submit a form
	 *
	 * @param require string $url  url where the request will be sent to
	 * @param require string $form_id  the form id
	 * @param optional string $container_id = null  alternative element where to load the response
	 * @param optional string $confirm  ask before sending the request
	 * @return unknown
	 */
	public function form($url, $form_id = null,$container_id = null,$confirm=null)
	{
		$ajax = ajax();

		$out = array();

		$out['do'] = '_form';

		if(is_array($url)) {
			$out['options'] = array();
			$url = $this->urlAccess($url, $out['options']);
		}
		$out['url'] = $url;
		if($form_id) $out['form_id'] = $form_id;
		if(!is_null($container_id)) {
			$out['container'] = $container_id;
		}

		if(!is_null($ajax->text)) {
			$out['text'] = $ajax->text;
		} elseif($ajax->text===false) {
			$out['text'] = 'Loading...';
		}

		if($confirm) {
			$out['confirm'] = $confirm;
		}

		if(is_array($ajax->post)) {
			$args = http_build_query($ajax->post);
			$out['args'] = $args;
			$out['post'] = true;
		} else {
			$out['post'] = 1;
		}

		$xml = $this->xmlItem($this->xml($out),'form','api');

		return $xml;
	}


	/**
	 * assign styles to an element
	 *
	 * @param unknown_type $style
	 */
	function style($element_id,$style = array() )
	{
		$data['do'] = 'style';
		$data['element'] = $element_id;
		$data['style'] = $this->mkArray($style);
		return $this->xml($data);
	}

	private static $overLay = array();
	/**
	 *
	 * overlay url
	 * @param $url
	 * @param $use_cahe
	 * @param $options
	 * Accepted  $options Example
	 *  $options['top'] = '50px';
	$options['left'] = '100px';
	$options['transparent'] = '60%'; // from 1 transparent to 100 solid, how transparent should it be? default is 80.
	$options['color'] = '#FF8040'
	 */
	function overlay($url = null, $options = array(), $use_cahe = false)
	{
		if(is_array($url)) {
			$url = $this->urlAccess($url);
		}
		$data['do'] = 'overLay';
		if(!isset($options['click_close'])) {
			$options['click_close'] = true;
		}
		if($options && is_array($options)) {
			foreach($options as $k => $v) {
				if(is_a($v,'plugin')) {
					$xml = $v->xmlObject();
					$_data = $xml->pack();
					$xml->delete();
				} else {
					$_data = $v;
				}
				$data[$k] = $_data;
			}
			$data['options'] = $options;
		}
		$data['url'] = $url;
		$data['cache'] = $use_cahe;
		if($url) {
			$data['message'] = $this->template('overlay.html');
		}

		return $this->xmlItem($this->xml($data),'overlay','api');
	}

	/**
	 *
	 * Display an overlay with supplied html.
	 *
	 * Options -
	 * Examples:
	$options['transparent']	=	10;
	$options['color']	=	'#425769';
	$options['top'] = 200;
	$options['left'] = "50%";
	 * @param $content
	 * @param $options
	 */
	function overlayContent($content = null,$options = array())
	{
		$data['do'] = 'overLayContent';
		if(!isset($options['click_close'])) {
			$options['click_close'] = true;
		}

		if($options && is_array($options)) {
			foreach($options as $k => $v ) {
				$data[$k] = $v;
			}
			$data['options'] = $options;
		}
		$data['message'] =  $this->encode($this->template('overlay.html'));
		$data['content'] = $this->encode($content,true);

		return $this->xmlItem($this->xml($data),'overlayContent','api');
	}

	/**
	 * Display a message in the middle of the screen
	 *
	 * @param string $data
	 * @param integer $seconds if specified, this is the number of seconds the message will appear in the screen
	 * then it will dissapear.
	 */
	public function message($message,$seconds=3,$container_id='cjax_message')
	{
		$data['do'] = '_message';
		$data['message'] = $message;
		$data['time'] =  $seconds;
		$data['message_id'] = $container_id;
		return $this->xml($data);
	}

	/**
	 *
	 * import css and javascript files
	 * @param mixed_type $file
	 * @param unknown_type $max_time
	 */
	public function import($file , $load_time = 0)
	{
		$data['do'] = '_import';
		$data['time'] = (int) $load_time;
		$data['is_import'] = 1;
		if(!is_array($file)) {
			$data['file'] = $file;
		} else  {
			$data = array_merge($data , $file);
		}

		return $this->xml($data);
		return $this->xmlItem($this->xml($data), 'import') ;
	}

	/**
	 *
	 * import more than one file, waiting for the previous to load.
	 * @param mixed_type $file
	 * @param unknown_type $max_time
	 */
	public function imports($files = array() , &$data = array())
	{
		$data['do'] = '_imports';
		$data['files'] = $this->xmlIt($files,'file');
		$data['is_import'] = 1;

		$this->first();
		return $this->xml($data);
	}

	/**
	 * Update any element on the page by specifying the element ID
	 * Usage:  $ajax->update('element_id',$content);
	 * @param string $obj
	 * @param string $data
	 */
	public function update($element_id, $data=null)
	{
		return $this->property($element_id, $data);
	}

	/**
	 * Add event to elements
	 * --
	 * AddEventTo();
	 *
	 * @param string $element
	 * @param string $event
	 * @param string $method
	 */
	public function AddEventTo($element,$actions,$event='onclick')
	{
		$data['do'] = 'AddEventTo';
		$data['element_id'] = $element;
		$data['event'] = $event;
		$data['options'] = $actions;

		return $this->xmlItem($this->xml($data),'AddEventTo','api');
	}

	/**
	 * Will execute a command in a specified amouth of time
	 * e.g $ajax->wait(5);
	 * Will wait 5 seconds before executes the next CJAX command
	 *
	 *
	 * @param integer $seconds
	 * @param boolean $expand  - make other commands wait for this timeout and if there is a timeout add to it.
	 */

	public function wait($seconds, $milliseconds = false,$expand = true)
	{
		$data['timeout'] = $seconds;
		if(is_float($seconds)) {
			$milliseconds = true;
		}
		$data['ms'] = $milliseconds;
		if(!$seconds) {
			$data['no_wait'] = 1;
		} else {
			$data['expand'] = $expand;
		}
		$this->_flag = $data;
		return $this;
	}

	/**
	 *
	 * Removes waiting times
	 */
	public function waitReset()
	{
		$data['do'] = '_wait';

		$data['time_reset'] = 1;

		return $this->xml($data);
	}

	/**
	 * Flag function
	 *
	 * Set command execution in high  priority preload mode.
	 */
	public function preload()
	{
		$this->flag('first');
	}

	/**
	 * Will remove an specified element from the page
	 *
	 * @param string $obj
	 */
	public function remove($obj)
	{
		$data['do'] = 'remove';
		$data['element_id'] = $obj;
		$this->xml($data);
	}

	/**
	 * Redirect the page.
	 * this is a recommended alternative to the built-in php function Header();
	 *
	 * @param string $where [URL]
	 */
	public function location($url = null)
	{
		$data['do'] = 'location';
		$data['url'] = $url;

		return self::xml($data);
	}


}