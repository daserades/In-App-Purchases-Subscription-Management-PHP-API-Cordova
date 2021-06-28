PhpApi = {
			URL: "http://localhost/api/",
			Register: {
				Check: function(){
					/* 
					if(Cache["App"]["Uid"]==0 || Cache["App"]["AppId"]==0 || Cache["App"]["Language"]==0 || Cache["App"]["OperatingSystem"]==0){return 0;} 
					*/
					/* Register API = PhpApi.URL+"register" */ 
					PostQueries = {
					"uid":Cache["App"]["Uid"],
					"appid":Cache["App"]["AppId"],
					"language":Cache["App"]["Language"],
					"operatingsystem":Cache["App"]["OperatingSystem"]
					};  
					 
					Functions.HttpRequest(PhpApi.URL+"register","POST",PostQueries,PhpApi.Register.Check_Callback);
				},
				Check_Callback: function(ResponseData=0){ 
					if(ResponseData==0){return 0;}
					if(ResponseData["ClientToken"]!=null){ 
					Cache["ClientToken"]=ResponseData["ClientToken"]; 
					Functions.Text("clienttoken",0,"Client Token: "+ResponseData["ClientToken"]);
					}
					if(ResponseData["Register"]!=null){
					    Functions.Text("register",0,ResponseData["Register"]);
					}
					if(ResponseData["ApiStatus"]!=null){
					    Functions.Text("apistatus",0,ResponseData["ApiStatus"]);
					}  
				}
				
			},
			Purchase: {
				Subscription: function(ProductId=0,Action=0){
					if(ProductId==0){return 0;}
					/* 
					if(Cache["App"]["Uid"]==0 || Cache["App"]["AppId"]==0 || Cache["App"]["Language"]==0 || Cache["App"]["OperatingSystem"]==0){return 0;} 
					*/
					/* Register API = PhpApi.URL+"register" */ 
					ProductCheck = Store.Subscriptions;
					if(Cache["ClientToken"]==null){
						return Functions.Notification("Client Token is not found.");
					}
					if(ProductCheck[ProductId]!=null || ProductId==1){
						PostQueries = {
						"type":"Subscription",
						"uid":Cache["App"]["Uid"],
						"appid":Cache["App"]["AppId"],
						"language":Cache["App"]["Language"],
						"operatingsystem":Cache["App"]["OperatingSystem"],
						"client-token":Cache["ClientToken"],
						"store":ProductCheck[ProductId],
						"action":Action
						};  
						 
						Functions.HttpRequest(PhpApi.URL+"purchase","POST",PostQueries,PhpApi.Purchase.Subscription_Callback);
					}else{
						Functions.Notification("Product is not found.");
					}
					
				},
				Subscription_Callback: function(ResponseData=0){ 
					if(ResponseData==0){return 0;}
					console.log(ResponseData);
					if(ResponseData["response"]!=null){
					Functions.Notification(ResponseData["response"]);
					}
					if(Cache.Products.Subscription["subscription_check"]==0){
					if(ResponseData["status"]==true){
					/* Check Subscription Screena */
					App.Start(3,"screena"); 
					}
					}
					if(Cache.Products.Subscription["subscription_check"]==1){
					if(ResponseData["status"]==false){
					/* Check Subscription Screena */
					App.Start(3,"screena"); 
					}
					}
					document.getElementById("myTextarea").value = JSON.stringify(ResponseData);
				}
			},
			CheckSubscription: {
				Get: function(){
						PostQueries = {
						"type":"Subscription",
						"uid":Cache["App"]["Uid"],
						"appid":Cache["App"]["AppId"],
						"language":Cache["App"]["Language"],
						"operatingsystem":Cache["App"]["OperatingSystem"],
						"client-token":Cache["ClientToken"]
						};
						Functions.HttpRequest(
						PhpApi.URL+"checksubscription",
						"POST",
						PostQueries,
						PhpApi.CheckSubscription.Callback
						);
					
					
				},
				Callback: function(ResponseData=0){
				if(ResponseData["response"]!=null){Functions.Notification(ResponseData["response"]);}
				console.log(ResponseData);
				
				if(Cache.Products.Subscription["subscription_check"]==0){
				if(ResponseData["status"]==true){
				/* Check Subscription Screena */
				App.Start(3,"screena"); 
				}
				}
				if(Cache.Products.Subscription["subscription_check"]==1){
				if(ResponseData["status"]==false){
				/* Check Subscription Screena */
				App.Start(3,"screena"); 
				}
				}
				
				if(ResponseData["status"]===true){ 
				Cache.Products.Subscription["subscription_check"]=1;
				Cache.Products.Subscription["subscription_lasttime"]=ResponseData["expire-date"];
				}else{
				Cache.Products.Subscription["subscription_check"]=0;
				Cache.Products.Subscription["subscription_lasttime"]=0;
				}
				}
			
			}
		};