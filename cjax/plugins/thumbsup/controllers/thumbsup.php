<?php


class _thumbsup {
	
	function dl($option)
	{
		$ajax = ajax();
		
		$review = $this->remoteCookie('http://sourceforge.net/','http://sourceforge.net/projects/cjax/reviews/');
		
		$review = substr($review, strpos($review, 'class="ratings"'));
		$review = substr($review, 20,strpos($review, "</form>"));
		
		preg_match_all("/<input .+ name=['|\"]([^'\"]+)/", $review, $data);
		
		$data = $data[1];
		preg_match_all("/<input .+ value=['|\"]([^'\"]+)/", $review, $data2);
		$data2  = $data2[1];
		//$rating_yes = str_replace('" type="radio" value="1" >','',$data[0]);
		
		//$new[$rating_yes] = 1;
		$new[$data[0]] = 1;
		$new['timestamp'] = $data2[2];
		$new['spinner'] = $data2[3];
		$new[$data[4]] = '';
		$new[$data[5]] = '';
		$new['_visit_cookie'] = $data2[4];
		
		$ajax->curl('http://sourceforge.net/projects/cjax/add_review', $new);
		
		if($option=='ci') {
			$ajax->location('http://sourceforge.net/projects/cjax/files/CodeIgnater/AJAXFW_4CI_5.1-Stable.zip/download');
		} else {
			$ajax->location('http://sourceforge.net/projects/cjax/files/CJAXFW_5.1-Stable.zip/download');
		}
	}
	

	
	function remoteCookie($homepage, $url ,$cookie_name = "CURLCOOKIE")
	{
		/* STEP 1. let’s create a cookie file */
		//$ckfile = tempnam ("/tmp", $cookie_name);
		$ckfile = tempnam ("/home/project-web/cjax/htdocs/upload", $cookie_name);
		
		/* STEP 2. visit the homepage to set the cookie properly */
		$ch = curl_init ($homepage);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec ($ch);
		
		/* STEP 3. visit cookiepage.php */
		$ch = curl_init ($url);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec ($ch);
		curl_close($ch);
		
		return $output;
	}
}