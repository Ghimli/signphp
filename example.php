<?php
require_once("BitmaszynaApi.php");

function bitmaszyna_api($method, $params = array()){
	$key='';
	$secret='';
	$params["nonce"] = time();
	$post = http_build_query($params, "", "&");
	$sign = hash_hmac("sha512", $post, $secret);
	$bitmaszynaApi = new BitmaszynaApi();
	$headers = array("Rest-Key: " . $key, "Rest-Sign: " . $bitmaszynaApi->signature($post,$secret));
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_URL, "https://bitmaszyna.pl/api/".$method);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	$ret = curl_exec($curl);
	var_dump($ret);
	return json_decode($ret, true);
}

bitmaszyna_api("funds","");
?>
