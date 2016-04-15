<?php

namespace Examples\Controllers;
use CJAX\Core\AJAXController;
use CJAX\Event\MouseEvent;

class Mouse extends AJAXController{
	
	public function over(){
	    $this->ajax->image = "resources/images/mars.png";
	}

    public function out(){
	    $this->ajax->image = "resources/images/earth.png";
    }

	public function up(){
	    $this->ajax->image = ['width' => 250, 'height'=> 250]; 
	}

    public function down(){
	    $this->ajax->image = ['width' => 500, 'height'=> 500]; 
    }
    
    public function right(){
        $this->ajax->image = "resources/images/mars.png";
    }

    public function double(){
        $this->ajax->image = "resources/images/venus.jpg";
    }
    
    public function point(MouseEvent $event){
        $point = $event->getLocation();
        $this->ajax->alert("You have clicked on point: ({$point[0]}, {$point[1]})");
    }
    
    public function map(MouseEvent $event){
        $point = $event->getLocation(); 
        if(($point[0] > 0 && $point[0] < 75) && ($point[1] > 20 && $point[1] < 320)) $this->ajax->result = "You are on the star Sun, how is this possible?";
        elseif(($point[0] > 97 && $point[0] < 122) && ($point[1] > 102 && $point[1] < 127)) $this->ajax->result = "You are on planet Mercury, hot hot, hot!";
        elseif(($point[0] > 113 && $point[0] < 151) && ($point[1] > 264 && $point[1] < 302)) $this->ajax->result = "You are on planet Venus, so many greenhouse gases.";
        elseif(($point[0] > 178 && $point[0] < 218) && ($point[1] > 135 && $point[1] < 175)) $this->ajax->result = "You are on planet Earth, it's our home.";
        elseif(($point[0] > 200 && $point[0] < 228) && ($point[1] > 62 && $point[1] < 90)) $this->ajax->result = "You are on planet Mars, the nearest neibhbor to Earth.";
        elseif(($point[0] > 240 && $point[0] < 355) && ($point[1] > 168 && $point[1] < 283)) $this->ajax->result = "You are on planet Jupiter, largest planet in our solar system.";
        elseif(($point[0] > 294 && $point[0] < 440) && ($point[1] > 57 && $point[1] < 142)) $this->ajax->result = "You are on planet Saturn, it's very beautiful!";
        elseif(($point[0] > 417 && $point[0] < 480) && ($point[1] > 143 && $point[1] < 204)) $this->ajax->result = "You are on planet Uranus, it's a bit further away from us.";
        elseif(($point[0] > 470 && $point[0] < 530) && ($point[1] > 240 && $point[1] < 300)) $this->ajax->result = "You are on planet Neptune, you must have been frozen solid.";
        else $this->ajax->result = "You have clicked on nothing more than an empty space in our Universe.";
    }
}