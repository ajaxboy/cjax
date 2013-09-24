<?php

class plugin_test extends plugin {
	
	
	
	public function remote($url)
	{
		$ajax = ajax();
		
		$html = $ajax->remote($url);
		
		//preg_match("/<head>\n\r\t.+/s", $data, $out);
		
		$doc = new DOMDocument();
		@$doc->loadHTML($html);
		$nodes = $doc->getElementsByTagName('title');
		
		//get and display what you need:
		$title = $nodes->item(0)->nodeValue;
		
		$metas = $doc->getElementsByTagName('meta');
		
		for ($i = 0; $i < $metas->length; $i++) {
		    $meta = $metas->item($i);
		    if($meta->getAttribute('name') == 'description') {
		        $description = $meta->getAttribute('content');
		    }
		    if($meta->getAttribute('name') == 'keywords') {
		        $keywords = $meta->getAttribute('content');
		    }
		}
		
		return array('title' => $title, 'description'=> $description,'keywords'=> $keywords);
	}
}