// Sticky Plugin v1.0.0 for jQuery
!function(t){var e={topSpacing:0,bottomSpacing:0,className:"is-sticky",wrapperClassName:"sticky-wrapper",center:!1,getWidthFrom:""},n=t(window),i=t(document),a=[],s=n.height(),o=function(){for(var e=n.scrollTop(),o=i.height(),r=o-s,c=e>r?r-e:0,p=0;p<a.length;p++){var l=a[p],d=l.stickyWrapper.offset().top,m=d-l.topSpacing-c;if(m>=e)null!==l.currentTop&&(l.stickyElement.css("position","").css("top",""),l.stickyElement.parent().hasClass(l.className)&&l.stickyElement.parent().animate({},{queue:!1,duration:250,easing:"linear",complete:function(){l.stickyElement.parent().removeClass(l.className)}}),l.currentTop=null);else{var u=o-l.stickyElement.outerHeight()-l.topSpacing-l.bottomSpacing-e-c;0>u?u+=l.topSpacing:u=l.topSpacing,l.currentTop!=u&&(l.stickyElement.css("position","fixed").css("top",u),"undefined"!=typeof l.getWidthFrom&&l.stickyElement.css("width",t(l.getWidthFrom).width()),l.stickyElement.parent().hasClass(l.className)||l.stickyElement.parent().animate({},{queue:!1,duration:250,easing:"linear",complete:function(){l.stickyElement.parent().addClass(l.className)}}),l.currentTop=u)}}},r=function(){s=n.height()},c={init:function(n){var i=t.extend(e,n);return this.each(function(){var e=t(this),n=e.attr("id"),s=t("<div></div>").attr("id",n+"-sticky-wrapper").addClass(i.wrapperClassName);e.wrapAll(s),i.center&&e.parent().css({width:e.outerWidth(),marginLeft:"auto",marginRight:"auto"}),"right"==e.css("float")&&e.css({"float":"none"}).parent().css({"float":"right"});var o=e.parent();o.css("height",e.outerHeight()),a.push({topSpacing:i.topSpacing,bottomSpacing:i.bottomSpacing,stickyElement:e,currentTop:null,stickyWrapper:o,className:i.className,getWidthFrom:i.getWidthFrom})})},update:o};window.addEventListener?(window.addEventListener("scroll",o,!1),window.addEventListener("resize",r,!1)):window.attachEvent&&(window.attachEvent("onscroll",o),window.attachEvent("onresize",r)),t.fn.sticky=function(e){return c[e]?c[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?void t.error("Method "+e+" does not exist on jQuery.sticky"):c.init.apply(this,arguments)},t(function(){setTimeout(o,0)})}(jQuery);

// To Top Jquery
(function($){$.fn.UItoTop=function(options){var defaults={text:'To Top',min:200,inDelay:600,outDelay:400,containerID:'toTop',containerHoverID:'toTopHover',scrollSpeed:1200,easingType:'linear'},settings=$.extend(defaults,options),containerIDhash='#'+settings.containerID,containerHoverIDHash='#'+settings.containerHoverID;$('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');$(containerIDhash).hide().on('click.UItoTop',function(){$('html, body').animate({scrollTop:0},settings.scrollSpeed,settings.easingType);$('#'+settings.containerHoverID,this).stop().animate({'opacity':0},settings.inDelay,settings.easingType);return false;}).prepend('<span id="'+settings.containerHoverID+'"></span>').hover(function(){$(containerHoverIDHash,this).stop().animate({'opacity':1},600,'linear');},function(){$(containerHoverIDHash,this).stop().animate({'opacity':0},700,'linear');});$(window).scroll(function(){var sd=$(window).scrollTop();if(typeof document.body.style.maxHeight==="undefined"){$(containerIDhash).css({'position':'absolute','top':sd+$(window).height()-50});}
if(sd>settings.min)
$(containerIDhash).fadeIn(settings.inDelay);else
$(containerIDhash).fadeOut(settings.Outdelay);});};})(jQuery);

// Easing jquery
jQuery.extend(jQuery.easing,{easeInQuad:function(n,t,e,u,a){return u*(t/=a)*t+e},easeOutQuad:function(n,t,e,u,a){return-u*(t/=a)*(t-2)+e},easeInOutQuad:function(n,t,e,u,a){return(t/=a/2)<1?u/2*t*t+e:-u/2*(--t*(t-2)-1)+e},easeInCubic:function(n,t,e,u,a){return u*(t/=a)*t*t+e},easeOutCubic:function(n,t,e,u,a){return u*((t=t/a-1)*t*t+1)+e},easeInOutCubic:function(n,t,e,u,a){return(t/=a/2)<1?u/2*t*t*t+e:u/2*((t-=2)*t*t+2)+e},easeInQuart:function(n,t,e,u,a){return u*(t/=a)*t*t*t+e},easeOutQuart:function(n,t,e,u,a){return-u*((t=t/a-1)*t*t*t-1)+e},easeInOutQuart:function(n,t,e,u,a){return(t/=a/2)<1?u/2*t*t*t*t+e:-u/2*((t-=2)*t*t*t-2)+e},easeInQuint:function(n,t,e,u,a){return u*(t/=a)*t*t*t*t+e},easeOutQuint:function(n,t,e,u,a){return u*((t=t/a-1)*t*t*t*t+1)+e},easeInOutQuint:function(n,t,e,u,a){return(t/=a/2)<1?u/2*t*t*t*t*t+e:u/2*((t-=2)*t*t*t*t+2)+e},easeInSine:function(n,t,e,u,a){return-u*Math.cos(t/a*(Math.PI/2))+u+e},easeOutSine:function(n,t,e,u,a){return u*Math.sin(t/a*(Math.PI/2))+e},easeInOutSine:function(n,t,e,u,a){return-u/2*(Math.cos(Math.PI*t/a)-1)+e},easeInExpo:function(n,t,e,u,a){return 0==t?e:u*Math.pow(2,10*(t/a-1))+e},easeOutExpo:function(n,t,e,u,a){return t==a?e+u:u*(-Math.pow(2,-10*t/a)+1)+e},easeInOutExpo:function(n,t,e,u,a){return 0==t?e:t==a?e+u:(t/=a/2)<1?u/2*Math.pow(2,10*(t-1))+e:u/2*(-Math.pow(2,-10*--t)+2)+e},easeInCirc:function(n,t,e,u,a){return-u*(Math.sqrt(1-(t/=a)*t)-1)+e},easeOutCirc:function(n,t,e,u,a){return u*Math.sqrt(1-(t=t/a-1)*t)+e},easeInOutCirc:function(n,t,e,u,a){return(t/=a/2)<1?-u/2*(Math.sqrt(1-t*t)-1)+e:u/2*(Math.sqrt(1-(t-=2)*t)+1)+e},easeInElastic:function(n,t,e,u,a){var r=1.70158,i=0,s=u;if(0==t)return e;if(1==(t/=a))return e+u;if(i||(i=.3*a),s<Math.abs(u)){s=u;var r=i/4}else var r=i/(2*Math.PI)*Math.asin(u/s);return-(s*Math.pow(2,10*(t-=1))*Math.sin((t*a-r)*(2*Math.PI)/i))+e},easeOutElastic:function(n,t,e,u,a){var r=1.70158,i=0,s=u;if(0==t)return e;if(1==(t/=a))return e+u;if(i||(i=.3*a),s<Math.abs(u)){s=u;var r=i/4}else var r=i/(2*Math.PI)*Math.asin(u/s);return s*Math.pow(2,-10*t)*Math.sin((t*a-r)*(2*Math.PI)/i)+u+e},easeInOutElastic:function(n,t,e,u,a){var r=1.70158,i=0,s=u;if(0==t)return e;if(2==(t/=a/2))return e+u;if(i||(i=a*(.3*1.5)),s<Math.abs(u)){s=u;var r=i/4}else var r=i/(2*Math.PI)*Math.asin(u/s);return 1>t?-.5*(s*Math.pow(2,10*(t-=1))*Math.sin((t*a-r)*(2*Math.PI)/i))+e:s*Math.pow(2,-10*(t-=1))*Math.sin((t*a-r)*(2*Math.PI)/i)*.5+u+e},easeInBack:function(n,t,e,u,a,r){return void 0==r&&(r=1.70158),u*(t/=a)*t*((r+1)*t-r)+e},easeOutBack:function(n,t,e,u,a,r){return void 0==r&&(r=1.70158),u*((t=t/a-1)*t*((r+1)*t+r)+1)+e},easeInOutBack:function(n,t,e,u,a,r){return void 0==r&&(r=1.70158),(t/=a/2)<1?u/2*(t*t*(((r*=1.525)+1)*t-r))+e:u/2*((t-=2)*t*(((r*=1.525)+1)*t+r)+2)+e},easeInBounce:function(n,t,e,u,a){return u-jQuery.easing.easeOutBounce(n,a-t,0,u,a)+e},easeOutBounce:function(n,t,e,u,a){return(t/=a)<1/2.75?u*(7.5625*t*t)+e:2/2.75>t?u*(7.5625*(t-=1.5/2.75)*t+.75)+e:2.5/2.75>t?u*(7.5625*(t-=2.25/2.75)*t+.9375)+e:u*(7.5625*(t-=2.625/2.75)*t+.984375)+e},easeInOutBounce:function(n,t,e,u,a){return a/2>t?.5*jQuery.easing.easeInBounce(n,2*t,0,u,a)+e:.5*jQuery.easing.easeOutBounce(n,2*t-a,0,u,a)+.5*u+e}});


// Visual Nav jQuery
;(function(c){c.visualNav=function(h,k){var b,a=this;a.$el=c(h);a.$el.data("visualNav",a);a.init=function(){var d;a.initialized=!1;a.options=b=c.extend({},c.visualNav.defaultOptions,k);a.winLoc=window.location;a.history="replaceState"in window.history?window.history:null;a.$win=c(window);a.$doc=c(document);a.$body=c("html, body");a.curHash="";a.$lastItem=[null];a.namespace=".visualNav";c.each(b.easing,function(a,d){c.isFunction(c.easing[d])||(b.easing[a]="swing")});b.stopOnInteraction&&a.$body.bind("scroll mousedown DOMMouseScroll mousewheel keyup ".split(" ").join(a.namespace+
" "),function(b){(0<b.which||"mousedown"===b.type||"mousewheel"===b.type)&&a.$body.stop()});a.$win.bind(["scroll","resize",""].join(a.namespace+" "),function(){a.throttle()});a.update();b.useHash&&a.winLoc.hash&&a.animate(a.winLoc.hash);a.findLocation();b.scrollOnInit?(d=a.$el.find("."+b.selectedClass+(b.selectedAppliedTo===b.link?"":" "+b.link)),a.animate(d.attr(b.targetAttr)||d.attr("href"),!0)):a.completed(!0)};a.update=function(){a.$content=c("."+b.contentClass);a.leftMargin=parseInt(a.$content.css("margin-left"),
10);a.rightMargin=parseInt(a.$content.css("margin-right"),10);var d,e="."+b.externalLinks;a.$links=c(a.$el.find(b.selectedAppliedTo+(b.selectedAppliedTo===b.link?"":" "+b.link)).map(function(a,b){d=c(b);return d.hasClass(e)||d.closest(e).length?null:b}));e="."+b.contentLinks;a.$links.add(c(e+","+e+" a")).unbind("click.visualNav").bind("click.visualNav",function(d,e){var l=c(this);a.animate(l.attr(b.targetAttr)||l.attr("href"),e);return!1});a.$items=b.selectedAppliedTo===b.link?a.$links:c(a.$links.map(function(){return c(this).closest(b.selectedAppliedTo)[0]}));
a.initialized&&a.findLocation()};a.animate=function(d,e){var f,g,l;g=c(d);"#"!==d&&g.length&&(f=c(d).eq(0).closest("."+b.contentClass),f.length&&(g=f),g.length&&(a.curHash=g[0].id||"",a.$curContent=g,a.initialized&&"function"===typeof b.beforeAnimation&&b.beforeAnimation(a,g),f=g.offset(),l=Math.min(f.top,a.$doc.height()-a.$win.height())-b.offsetTop,g="function"===typeof b.animationTime?b.animationTime(Math.abs(a.$body.scrollTop()-l))||1200:b.animationTime,a.$body.stop().animate({scrollLeft:Math.min(f.left,
a.$doc.width()-a.$win.width())-a.leftMargin,scrollTop:l},{queue:!1,duration:a.initialized?g:0,easing:b.easing[0],specialEasing:{scrollLeft:b.easing[0]||"swing",scrollTop:b.easing[1]||b.easing[0]||"swing"},complete:function(){a.completed(e)}})))};a.throttle=function(){a.flag||(a.flag=!0,a.timer=setTimeout(function(){a.flag=!1;a.findLocation()},100))};a.updateHash=function(){var d,e;e=b.selectedAppliedTo===b.link?a.$curItem.attr(b.targetAttr)||a.$curItem.attr("href"):a.$curItem.find(b.link).attr(b.targetAttr)||
a.$curItem.find(b.link).attr("href");var f=(e||"").replace(/^#/,"");e&&""!==f&&f!==a.curHash&&(e=c("#"+f),a.curHash=f,e.length&&(e.attr("id",""),d=c("<div></div>").css({position:"absolute",visibility:"hidden",top:c(document).scrollTop()+"px"}).attr("id",f).appendTo(document.body)),a.setHash("#"+f),e.length&&(d.remove(),e.attr("id",f)))};a.setHash=function(b){a.winLoc.hash!==b&&"#"!==b&&(a.winLoc.replace?null!==a.history?a.history.replaceState({},"",b):a.winLoc.replace(b):a.winLoc.hash=b)};a.completed=
function(c){b.useHash&&a.setHash("#"+a.curHash);a.initialized?"function"===typeof b.complete&&b.complete(a,a.$curContent):c&&("function"===typeof b.initialized&&b.initialized(a,a.$curContent),a.initialized=!0);a.flag=!1};a.findLocation=function(){var d,e,f,g,l,h,k,p,m=a.$win.width(),q=a.$win.scrollLeft(),r=a.$win.scrollTop(),t=q+m,n=r+a.$win.height(),u=a.$doc.height();a.$items.removeClass(b.inViewClass);b.fitContent&&a.$content.width(m-a.leftMargin-a.rightMargin);a.$links.each(function(m){g=c(this).attr(b.targetAttr);
d="#"===g||1>=g.length?"":c(g);d.length&&(f=Math.ceil(d.offset().top),e=Math.ceil(d.offset().left),h=d.outerHeight(),l=f+h+b.bottomMargin,k=d.outerWidth(),p=e+k,f<n&&(f+h-b.bottomMargin>r||l>n)&&e<t&&(e+k-b.bottomMargin>q||p>t)&&a.$items.eq(m).addClass(b.inViewClass))});g=n+b.bottomMargin>=u?":last":":first";a.$items.removeClass(b.selectedClass);a.$curItem=a.$items.filter("."+b.inViewClass+g).addClass(b.selectedClass);a.$curItem[0]!==a.$lastItem[0]&&(a.$lastItem=a.$curItem,a.$content.removeClass(b.currentContent),
g="."+b.selectedClass+(b.selectedAppliedTo===b.link?"":" "+b.link),d=a.$el.find(g).attr(b.targetAttr),a.$curContent=c(d).closest("."+b.contentClass).addClass(b.currentContent),a.initialized&&"function"===typeof b.changed&&b.changed(a,a.$curContent));b.useHash&&a.initialized&&a.updateHash()};a.init()};c.visualNav.defaultOptions={link:"a",targetAttr:"href",selectedAppliedTo:"li",contentClass:"content",contentLinks:"visualNav",externalLinks:"external",useHash:!0,inViewClass:"inView",selectedClass:"selected",
currentContent:"current",bottomMargin:100,fitContent:!1,offsetTop:0,scrollOnInit:!1,animationTime:1200,stopOnInteraction:!0,easing:["swing","swing"],initialized:null,beforeAnimation:null,complete:null,changed:null};c.fn.visualNav=function(h){return this.each(function(){var k=c(this).data("visualNav");(typeof h).match("object|undefined")?k?k.update():new c.visualNav(this,h):"string"===typeof h&&/^(#|\.)/.test(h)&&k.animate(h)})};c.fn.getvisualNav=function(){return this.data("visualNav")}})(jQuery);
