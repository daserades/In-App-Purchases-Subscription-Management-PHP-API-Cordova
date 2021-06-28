App = {
			Load: function(){
				/* Start App */
				$.getScript('https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js', function() {
				/* Materialize UI Load */ 
				App.Start(0,"screena");
				});
			},
			Start: function(i=0,q=0){
			if(q=="screena"){ 
			/* Screen A */
			console.log(i);
			switch(i) {
				case 0:
					/* 
					  Start App
					*/
					M.AutoInit();
					Functions.Notification("Hoşgeldiniz");
					Functions.Text("process",0,"Materialize UI loaded.");
					Functions.Sleep(function(){
						App.Start(1,"screena"); 
					},1000);
					break;
				case 1:
					/* 
					Get Device ID and Check Apı 
					*/
					Functions.Text("process",0,"GET Device ID");
					Functions.Sleep(function(){  
						Functions.Text("device_uid",0,Cache["App"]["Uid"]); 
						Functions.Text("device_appId",0,Cache["App"]["AppId"]); 
						Functions.Text("device_Language",0,Cache["App"]["Language"]); 
						Functions.Text("device_OperatingSystem",0,Cache["App"]["OperatingSystem"]);  
						App.Start(2,"screena"); 
					},1000);
				break;
				case 2:
				Functions.Text("process",0,"GET API ID");
				Functions.Sleep(function(){ 
					PhpApi.Register.Check();
					App.Start(3,"screena"); 
				},1000);
				break;
				
			    case 3:
				Functions.Text("process",0,"Checking Subscriptions or Products");
				Functions.Sleep(function(){ 
					PhpApi.CheckSubscription.Get();
					App.Start(4,"screena"); 
				},1000);	
				break;
				case 4:
				Functions.Text("process",0,"Checking Store");
				Functions.Sleep(function(){ 
					Store.List();
					if(Cache["Ready"]==0){
						App.Start(5,"screena"); 
					}else{
						Functions.Text("process",0,"Ready...");
					}
				},1000);
				break;
				case 5:
				Functions.Text("process",0,"Ready...");
				Functions.Sleep(function(){  
				Client.SubscriptionCheck();
				},1000);				
				break;
				default:
				console.log("Screena");
			} 
			}
			
			}
		};