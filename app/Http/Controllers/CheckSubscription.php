<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CheckSubscription extends Controller
{
    public $json = array();
    public function index()
    {
        /* Client Token Check */
        $this->json["ClientToken"]=$this->ClientToken(array(
        $_POST["uid"],
        $_POST["appid"],
        $_POST["language"],
        $_POST["operatingsystem"]
        ));
        if($_POST["client-token"] != $this->json["ClientToken"]){
            $this->json["response"]="Invalid Client Token"; 
            return $this->Screen();
        }
        $CheckSubscription = (array) DB::table('subscriptions')->where('uid', $_POST["uid"])->first(); 
        
        if(!empty($CheckSubscription["expire-date"])){
            $timecheck = strtotime($CheckSubscription["expire-date"]);
            if(time()>$timecheck){
                /* Time is over */
                DB::table('subscriptions')->where('uid', $_POST["uid"])->delete();
                $this->json["response"]="Abonelik Süreniz Dolmuş"; 
                $this->json["Subscription"]=0;
                $this->json["expire-date"]=0;
                $this->json["status"]=false;
            }else{ 
                $this->json["response"]="Abone Olduğunuz İçin Teşekkürler"; 
                $this->json["Subscription"]=1;
                $this->json["expire-date"]=$CheckSubscription["expire-date"];
                $this->json["timestamp"]=$timecheck;
                $this->json["status"]=true;
            }
        }else{
            $this->json["response"]="Abonelik Bulunamadı"; 
            $this->json["Subscription"]=0;
            $this->json["expire-date"]=0;
            $this->json["status"]=false;
        }
        return $this->Screen();
    }
    public function ClientToken($post){
		$query="";
		foreach($post as $val){
			$query .= $val."*";
		}
		return hash('sha256', $query);
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
