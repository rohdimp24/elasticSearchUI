<?php
#require_once('login.php');
/* get querystring parameter */
$param = urlencode($_GET['query']);

#$param="pump";
//return $param;

if(strlen($param)>0)
{

	/*protect from sql injections */

	/* query the database */
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "http://localhost:9200/autocomplete_test/_search?q=suggestions:".$param."&pretty=True");
	#curl_setopt($ch, CURLOPT_URL, "http://localhost:9200/autocomplete_test/_search?q=suggestions:".$param."&pretty=True");
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);





	#$headers = array();
	#$headers[] = "Content-Type: application/x-www-form-urlencoded";
	#curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	

	//print_r($result);

	//$tagArrayString=implode(";",$tagArray);
	#echo $result;
	$resultObj=json_decode($result);
	#print_r($resultObj->hits);
	$hits=$resultObj->hits->hits;
	print_r($hits->hits);
	$arrWords=array();
	foreach ($hits as $key) {
		#print_r($key->_source->word);
		array_push($arrWords,$key->_source->suggestions);
	}

	$final=implode(";",$arrWords);
	echo $final;
	


}
?>
