<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function curl($array=0) {
	$url = $array["url"];
	$ch = curl_init($url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_ENCODING, '');
	if(!empty($array["REQUEST"]) && !empty($array["POSTFIELDS"])){
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $array["REQUEST"]);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $array["POSTFIELDS"]);
	}
	$data = curl_exec($ch);
	$headers = curl_getinfo($ch, CURLINFO_HEADER_OUT);
	curl_close($ch);
	return array("data"=>$data,"headers"=>$headers);
	}
}
