<?php  
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Register extends Controller
{
    public $json = array(); 
    public function index(){     
		 $CheckDevice = DB::table('registers')->where('uid', $_POST["uid"])->where('appId', $_POST["appid"])->first(); 
        if($CheckDevice!==null){
            $this->json["Response"]="OK"; 
            $this->json["ApiStatus"]="Online";
            $this->json["Register"]="The device is already registered.";
        }else{ 
			DB::table('registers')->insert(array(
			'uid' => $_POST["uid"],
            'appId' => $_POST["appid"],
            'language' => $_POST["language"],
            'operating-system' => $_POST["operatingsystem"]
			));
            $this->json["Response"]="OK"; 
            $this->json["ApiStatus"]="Online";
            $this->json["Register"]="The device is now registered.";
        }
        $this->json["ClientToken"]=$this->ClientToken(array($_POST["uid"],$_POST["appid"],$_POST["language"],$_POST["operatingsystem"]));
        $this->json["POST"] = $_POST;
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
