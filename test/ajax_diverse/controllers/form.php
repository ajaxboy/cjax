<?php

use CJAX\Core\CJAX;

class Form {
	
	function username($username)
	{
		$ajax = CJAX::getInstance();
		$ajax->user_label = array('style' => array('color' => 'green'));
		$ajax->user_label = "<b>$username</b> is available";
	}
	
	function country($selected_value)
	{
        $ajax = CJAX::getInstance();
        
        $data = [];
        $selected = null;
        
        switch ($selected_value) {
        	case 'us':
        		$data = array('tx'=>'Texas', 'fl'=>'Florida', 'ca' => 'California','other' => 'Other..');
        		//$ajax->label_5 = "United States";
        		$selected = 'other';
        	break;
        	case 'in':
        		//$ajax->label_5 = "India";
        	break;
        	case 'ch':
        		//$ajax->label_5 = "China";
        	break;
        	case 'uk':
        		//$ajax->label_5 = "United Kingdom";
        	break;
        	case 'other':
        		//$ajax->label_5 = "Other";
        	default:
        	
        }
        //propagate data to dropdown
        $ajax->select('state', $data, $selected, true);  //propagate data
        $ajax->flush('state'); //if any, clears previous 'change' event set
        $ajax->change('state', $ajax->call('../../ajax.php?form/state/|state|'));//add event
	}
	
	function state($selected)
	{
		$ajax = CJAX::getInstance();
		
		$data = [];
		
		switch($selected){
			case 'tx':
				$data  = array('Dallas','Houston', 'San Antonio','other'=>'Other');
			break;
			case 'fl':
				$data  = array('Miami','Miami Beach', 'Palm Beach','other'=>'Other');
			break;
			case 'ca':
				$data  = array('Los Angeles','San Diego', 'San Francisco','other'=>'Other');
			break;
			case 'other':
				$data = array();
			default:
			
		}
		$ajax->select('city', $data, 'other',true);
		$ajax->change('city', $ajax->call('../../ajax.php?form/city/|city|'));
	}
	
	function city($selected)
	{
		if($selected=='other') {
			$ajax = CJAX::getInstance();;
			$ajax->select('city', array(), 'other',true);
		}
	}
	
    function submit($post_data)
    {
        $ajax = CJAX::getInstance();;
        $ajax->debug($post_data);
    }
    
    function dropdown($selected_value)
    {
        $ajax = CJAX::getInstance();;
        
        switch ($selected_value) {
        	case 'classes':
        		$data = get_declared_classes();
        		$ajax->label_4 = "PHP Classes Loaded";
        	break;
        	case 'files':
        		$data = get_required_files();
        		$ajax->label_4 = "PHP Files";
        	break;
        	case 'ext':
        		$data = get_loaded_extensions();
        		$ajax->label_4 = "PHP Extensions";
        }
        $data += array('classes'=>'PHP Clases','files'=>'PHP Files Loaded','ext'=>'PHP Extensions Loaded');
        //propagate data to dropdown
        $ajax->select('dropdown', $data);
    }
}