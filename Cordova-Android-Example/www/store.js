Store = {
			Subscriptions:{
				minute1:{
				id:"minute1",
				title:"1 Minute Subscription",
				description:"1 Minute Vip Member",
				time:60
				},
				minute30:{
				id:"minute30",
				title:"30 Minute Subscription",
				description:"30 Minute Vip Member",
				time:(30*60)
				},
				minute60:{
				id:"minute60",
				title:"60 Minute Subscription",
				description:"60 Minute Vip Member",
				time:(60*60)
				}
			},
			List: function(){
				write='<h3>Subscriptions</h3><div class="part"><div class="subscriptions"><div class="desc"><span class="subscription_check">__</span> <span class="subscription_lasttime">__</span></div></div></div><div class="row">';
				StoreList = Store.Subscriptions;
				for (var key in StoreList) {
					var productinfo = StoreList[key];
					write+='<div class="col m12 s12"><div class="row"> <div class="col m12 s12"> <div class="card blue-grey lighten-5"> <div class="card-content"> <span class="card-title">'+productinfo["title"]+'</span> <p>'+productinfo["description"]+'</p> </div>';
					if(Cache.Products.Subscription["subscription_check"]==0){
					write+='<div class="card-action"> <a class="waves-effect waves-light btn" href="javascript:PhpApi.Purchase.Subscription(\''+key+'\')">Subscription</a> </div>';
					}else{
					write+='<div class="card-action"> <a class="waves-effect waves-light btn" href="javascript:PhpApi.Purchase.Subscription(\''+key+'\')">Subscription</a> </div>';
					}
					
					write+='</div> </div> </div></div>';
				}
				write+='</div>';
				Functions.Text("storescreen",0,write);
				
				if(Cache.Products.Subscription["subscription_check"]==1){
					Functions.Text("subscription_check",0,"Abone Olduğunuz İçin Teşekkürler. ");
					Functions.Text("subscription_lasttime",0,"Aboneliğinizin Bitiş Tarihi: "+Cache.Products.Subscription["subscription_lasttime"]+" (UTC -6) (<a href=\"javascript:PhpApi.Purchase.Subscription(1,\'delete\')\">Aboneliği Sonlandır.</a>) ");
				}else{
					Functions.Text("subscription_check",0,"Uygulamaya Abone Değilsiniz...");
					Functions.Text("subscription_lasttime",0,"");
				}
			}
		};