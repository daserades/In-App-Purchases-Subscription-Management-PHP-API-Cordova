<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report extends Controller
{
	public $json = array(); 
    public function index()
    {
		if(empty($_GET["minId"]) || empty($_GET["maxId"]) || empty($_GET["appId"])){
			return 0;
		}
		$minid=$_GET["minId"];
		$maxid=$_GET["maxId"];
		$app=$_GET["appId"];
		if($maxid<$minid){
			return 0;
		}
		if(($maxid-$minid)>10000){
			return 0;
		}
		$ALLSubscriptions = DB::table('subscriptions')
			->orderBy('expire-date', 'desc')
			->where('id', '>=', $minid)
			->where('id', '<=', $maxid)
			->where('appId', '=', $app)
			->get(); 
		foreach($ALLSubscriptions as $key => $val){
			$val=(array) $val; 
			$deviceID = (array) DB::table('registers')->where('uid', $val["uid"])->first();
			if($deviceID===null){
				continue;
			}
			$timecheck = strtotime($val["expire-date"]);
			$time = $timecheck-time();
			if($time>0){
				$status=1;
			}else{
				$status=0;
			}
			$this->json[$key]=array(
			"id"=>$val["id"],
			"uid"=>$val["uid"],
			"operating-system"=>$deviceID["operating-system"],
			"expire-date"=>$val["expire-date"],
			"time"=>$time,
			"status"=>$status
			);
		}
		return $this->Screen();
    }
	public function Screen(){
        if(is_array($this->json) && count($this->json)>0){
            $this->json["error"]=0;
            return response(json_encode($this->json))
                  ->header('Content-Type', 'application/json'); 
        }else{
            $this->json["error"]=1;
            return response(json_encode($this->json))
                   ->header('Content-Type', 'application/json'); 
        }
    }
}
