<?php 

//core file, reference..
require_once "ajax.php";
//initiate CJAX..

//								/controllers/search.php:string()
$ajax->keyup('search', $ajax->call('ajax.php?search/string/|search|','search_result'));

?>
<html>
<head>
<?php echo $ajax->init();?>
</head>
<body>
<h2>Search</h2>
<br />
Try typing a letter, it should find all finding starting with that letter.
This is just a  demonstration, functionality is intended to be adapted with a database. The backend controller is test data only.
<br /><br />
Type Something <input type='text' id='search' />
<div id='search_result'>
</div>
<br />
<br />
Code Used:
<?php 
echo $ajax->code("
//first bild text element search to the ajax request
//pass |search|, passes the value of search field.
//search_result is the contained div
//keyup is the event (see: \$ajax->exec() in API table)
\$ajax->keyup('search',\$ajax->call('ajax.php?search/string/|search|','search_result'));
");?>
Controller:
<?php 
echo $ajax->Code("
//controllers/search.php
namespace Examples\\Controllers;
use CJAX\\Core\\AJAXController;

class Search extends AJAXController{
		
	public function string(\$string){
		// Fill up array with some data
		\$a[]=\"Anna\";
		\$a[]=\"Amanda\";
		\$a[]=\"Amelia\";
		\$a[]=\"Armando\";
		\$a[]=\"Brittany\";
		\$a[]=\"Bob\";
		\$a[]=\"Bill\";
		\$a[]=\"Cinderella\";
		\$a[]=\"Cindy\";
		\$a[]=\"Carlos\";
		\$a[]=\"Diana\";
		\$a[]=\"Doris\";
		\$a[]=\"Eva\";
		\$a[]=\"Eve\";
		\$a[]=\"Evita\";
		\$a[]=\"Fiona\";
		\$a[]=\"Gunda\";
		\$a[]=\"Hege\";
		\$a[]=\"Inga\";
		\$a[]=\"Johanna\";
		\$a[]=\"Kitty\";
		\$a[]=\"Linda\";
		\$a[]=\"Nina\";
		\$a[]=\"Ophelia\";
		\$a[]=\"Petunia\";
		\$a[]=\"Raquel\";
		\$a[]=\"Sunniva\";
		\$a[]=\"Tove\";
		\$a[]=\"Unni\";
		\$a[]=\"Violet\";
		\$a[]=\"Liza\";
		\$a[]=\"Liz\";
		\$a[]=\"Elizabeth\";
		\$a[]=\"Ellen\";
		\$a[]=\"Wenche\";
		\$a[]=\"Vicky\";
		\$a[]=\"Quinton\";
		\$a[]=\"Yancy\";
		\$a[]=\"Yakecan\";
		
		
		\$out = [];
		
		foreach(\$a as \$v) {
			if(substr(strtolower(\$v), 0, strlen(\$string)) == strtolower(\$string)) {
				\$out[] = \$v;
			}
		}
		
		die('<pre>'.print_r(\$out,1).'<pre>');
		
	}
	
}
");
?>
</body>
</html>