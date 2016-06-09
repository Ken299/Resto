(function(){
	"use strict";
	
	var Login = function(){
		if(Login.instance){
			return Login.instance;
		}
		Login.instance = this;
		this.routes = Login.routes;
		
		this.init();
	};
	
	Login.routes = {
		"login-view" : {
			render: function(){
				console.log("login lehel");
				$('#register-view').stop().slideUp(500);
				$('#login-view').slideDown(500);
			},
			norender: function(){
				$('#register-view').hide();
				$('#login-view').show();
			}
		},
		"register-view" : {
			render: function(){
				console.log("register lehel");
				$('#register-view').slideDown(500);
				$('#login-view').stop().slideUp(500);
			},
			norender: function(){
				$('#register-view').show();
				$('#login-view').hide();
			}
		}
	};
	
	Login.prototype = {
		init: function(){
			window.addEventListener('hashchange', this.routeChange.bind(this));
			if(!window.location.hash){
				window.location.hash = "login-view";
			}else{
				this.routeChange();
			}
		},
		routeChange: function(event){
			this.prevRoute = this.currentRoute
			this.currentRoute=window.location.hash.slice(1);
			if(this.routes[this.currentRoute]){
				if(this.prevRoute == null){
					this.routes[this.currentRoute].norender();
				}else{
					this.routes[this.currentRoute].render();
				}
			}else{window.location.hash = 'login-view';}
		}
	};
	window.onload = function(){
		var app = new Login();
	}
})();