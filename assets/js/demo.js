// $(window).on('load', function () {
//  $("#overlay").hide(1000);
// });
$(window).on("load", function() {

    "use strict";
 // setTimeout(function() {
 //        $('.preloader').hide();

 //        $('.cd-transition-layer').addClass('closing').delay(1000).queue(function() {
 //            $(this).removeClass("visible closing opening").dequeue();
 //        });

 //    }, 1000);
  setTimeout(function () {
        $(".loader").fadeOut("slow");
    }, 2000);

});






$(document).ready(function() {
//navbar
           $(window).scroll(function(){
                   if($(this).scrollTop()> 150){
                       $('.navbar.navbar-expand-lg.navbar-fixed-top').addClass('stick navbar-gradient');
                       $('.navbar.navbar-expand-lg.navbar-fixed-top').removeClass('stickAbsolute');
                   }
                   else{
                       $('.navbar.navbar-expand-lg.navbar-fixed-top').removeClass('stick navbar-gradient');
                       $('.navbar.navbar-expand-lg.navbar-fixed-top').addClass('stickAbsolute');
                   }
               });
      // Add minus icon for collapse element which is open by default
                $(".collapse.show").each(function(){
                    $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
                });
                
                // Toggle plus minus icon on show hide of collapse element
                $(".collapse").on('show.bs.collapse', function(){
                    
                    $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
                }).on('hide.bs.collapse', function(){
                    $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
                });
        if ($(window).width() > 991) {

            var wow = new WOW({
                boxClass: 'wow',
                animateClass: 'fade',
                offset: 0,
                mobile: false,
                live: true,
            });
            new WOW().init();
        }
        //NAVBAR ADD ACTIVE CLASS
        $('.navbar-nav a').on('click', function() {
            $(' .navbar-nav').find('li.active').removeClass('active');
            $(this).parent('li').addClass('active');
        });
        if ($('.scroll-to-target').length) {
        $(".scroll-to-target").on('click', function () {
          var target = $(this).attr('data-target');
          // animate
          $('html, body').animate({
            scrollTop: $(target).offset().top
          }, 500);

        });
      }
       // $(".coverflow").flipster();
        var owl = $("#owl-demo");

        owl.owlCarousel({
            items: 5, //10 items above 1000px browser width

            lazyLoad: true,
            navigation: true, // itemsMobile disabled - inherit from itemsTablet option
            loop: true,
            autoplay: true,
            dots: false,

            autoplayTimeout: 1500,
            slideSpeed: 1500,
            itemsDesktop: false,
            itemsDesktopSmall: false,
            itemsTablet: false,
            itemsMobile: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                200: {
                    items: 1,
                    nav: false,
                },
                400: {
                    items: 1,
                    nav: false,
                },
                600: {
                    items: 3,
                    nav: false
                },
                800: {
                    items: 3,
                    nav: false
                },

                1000: {

                    items: 5,
                    nav: false,
                    loop: false
                }
            }

        })

        //back to top
    $(window).on('scroll', function () {
        // checks if window is scrolled more than 500px, adds/removes solid class
        if ($(this).scrollTop() > 58) {
          $('.navbar').addClass('affix');
          $('.scroll-to-target').addClass('open');
        } else {
          $('.navbar').removeClass('affix');
          $('.scroll-to-target').removeClass('open');
        }
      });
});
 
   



 





