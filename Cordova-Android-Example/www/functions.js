Functions = {
			Notification: function(message=0){
				M.toast({html: message});
			},
			Text: function(name=0,count=0,text=0){ 
				document.getElementsByClassName(name)[count].innerHTML = text; 
			},
			HttpRequest: function(Route=0,Method=0,Query=0,Callback=0){  
			/* if(Route==0 || Method==0 || Query==0 || Callback==0){return 0;}  */
				$.ajax({
				url: Route,
				method: Method,
				data: Query,
				async: false,
				success: function (response) {
				document.getElementById("myTextarea").value = JSON.stringify(response);
				setTimeout(Callback(response), 0300); 
				},
				error: function (jqXhr, textStatus, errorMessage) { 
				 /* 
				 document.getElementById("myTextarea").value = "error";
				 document.getElementById("myTextarea").value += textStatus;
				 document.getElementById("myTextarea").value += errorMessage; 
				 */
				}
				});  
				 
				 
			},
			Sleep: function(func,ms){ 
			try {
				setTimeout(func, ms); 
			} catch(err) {
				console.log("hata: ",err);
			}
			}
			
		};