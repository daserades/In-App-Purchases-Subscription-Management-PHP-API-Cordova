<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Purchase extends Controller
{
   public $json = array();
   
   public function index(){     
   
	  /* Client Token Check */
	  $this->json["ClientToken"]=$this->ClientToken(array(
	  $_POST["uid"],
	  $_POST["appid"],
	  $_POST["language"],
	  $_POST["operatingsystem"]
	  ));
	  if($_POST["client-token"] != $this->json["ClientToken"]){
		$this->json["Response"]="Invalid Client Token"; 
		return $this->Screen();
	  }
      if(!empty($_POST["type"])){
	      if($_POST["type"]=="Subscription"){
		      return $this->Subscription();
		  }
      }
	}
	public function Subscription(){
		$CheckSubscription = DB::table('subscriptions')->where('uid', $_POST["uid"])->where('appId', $_POST["appid"])->first(); 
		if($CheckSubscription!==null){ 
			if($_POST["action"]=="delete"){
				/* Delete Subscription */
				DB::table('subscriptions')->where('uid', $_POST["uid"])->where('appId', $_POST["appid"])->delete();
				$this->json["response"]="Your subscription has been cancelled."; 
				$this->json["Check"]="Subscription"; 
				$this->json["status"]=false;
				return $this->Screen();
			}
			$this->json["response"]="You are now subscribed to the application."; 
			$this->json["Check"]="Subscription"; 
		}else{
			/* Check Google API HTTP Request */
			$PostQuery=array(
			"q"=>"purchase",
			"client-token"=>$this->json["ClientToken"],
			"receipt"=>uniqid().rand(10,99)
			);
			/* Controller.php CURL */
			$GoogleAPIResponse = $this->curl(array(
			"url"=>"http://localhost/api/googleapi",
			"POSTFIELDS"=>http_build_query($PostQuery),
			"REQUEST"=>"POST"
			));
			$Result = $GoogleAPIResponse["data"];
			if($Result=="OK"){
				$time = date("Y-m-d H:i:s",(time()+intval($_POST["store"]["time"])));
				DB::table('subscriptions')->insert(array(
					'uid' => $_POST["uid"],
					'appId' => $_POST["appid"],
					"status"=>true,
					"expire-date"=>$time
				));
				$this->json["response"]="Successful, Your google payment payment has been confirmed."; 
				$this->json["Check"]="Subscription"; 
				$this->json["status"]=true; 
				
				return $this->Screen();
			}else{
				$this->json["response"]="Error, Your google payment payment has been not confirmed."; 
				$this->json["status"]=false; 
			}
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
