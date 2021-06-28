<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Worker extends Controller
{
	public function checkGoogleAPI(){
		/* Check Google API HTTP Request */
		$PostQuery=array(
		"q"=>"expiredate",
		"receipt"=>uniqid().rand(10,99)
		);
		/* Controller.php CURL */
		$GoogleAPIResponse = $this->curl(array(
		"url"=>"http://localhost/api/googleapi",
		"POSTFIELDS"=>http_build_query($PostQuery),
		"REQUEST"=>"POST"
		));
		return $GoogleAPIResponse["data"];
	}
    public function index()
    {
		/* Control */
		$workercheck = (__DIR__)."/workercheck.txt";
		if(!file_exists($workercheck) || file_exists($workercheck) && (time()-filemtime($workercheck))>5 ){
			/* Sort old times */
			$ALLSubscriptions = DB::table('subscriptions')
			->orderBy('expire-date', 'asc')
			->get();  
			/* Check each time according to server capacity. */
			foreach($ALLSubscriptions as $key => $val){ 
				$checkcount = 0;
				$Result = $this->checkGoogleAPI();
				if($Result=="OK"){
				$CheckSubscription=(array) $val;
				$timecheck = strtotime($CheckSubscription["expire-date"]);
				if(time()>$timecheck){
					/* Subscription Expired */
					DB::table('subscriptions')
					->where('uid', $CheckSubscription["uid"])
					->delete();
				}
				}
				/* SERVER Limit */
				usleep(25000);
				if($key>10000){ break; } 	
			}
			file_put_contents($workercheck, time());
			echo "OK";
		}else{
			echo "Wait Please";
		}
    }
}
