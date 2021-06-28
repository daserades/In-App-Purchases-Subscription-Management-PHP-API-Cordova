<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleAPI extends Controller
{
	
    public function index()
    {
		if($_POST["q"] == "purchase"){
			$check = intval(substr($_POST["receipt"], -1));
			if($check %2 != 0)
			{
				echo "OK";
			}
		}elseif($_POST["q"] == "expiredate"){
			$check = intval(substr($_POST["receipt"], -2));
			if($check % 6 == 0)
			{
				echo "OK";
			}else{
				echo "Rate-Limit Error";
			}
		
		}
    }

}
