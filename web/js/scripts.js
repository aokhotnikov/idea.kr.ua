jQuery(document).ready(function () {



    $('form .inputPhone').mask("+7 (999) 999-99-99");

    //Fancybox

    $('.fancybox').fancybox({

        helpers: {overlay: {locked: true}}

    });

    $('.fancybox-media').fancybox({

        helpers: {media: true, overlay: {locked: true}}

    });





    //Fixed header

    function FixedHeader() {

        var sticky = $('.header');

        $(window).scrollTop() >= 50 ? sticky.addClass('header-fixed') : sticky.removeClass('header-fixed');

    }



    FixedHeader();

    $(window).scroll(function () {

        FixedHeader();

    });





    $('.navi > li').hover(

        function () {

            $(this).addClass('active');

        },

        function () {

            $(this).removeClass('active');

        }

    );





    //Main slider

    $('#mainpage-slider').royalSlider({

        transitionType: 'fade',

        arrowsNav: false,

        fadeinLoadedSlide: true,

        controlNavigationSpacing: 0,

        controlNavigation: 'thumbnails',

        thumbs: {

            autoCenter: false,

            fitInViewport: true,

            orientation: 'vertical',

            spacing: 0,

            paddingBottom: 0

        },

        keyboardNavEnabled: true,

        imageScaleMode: 'fill',

        imageAlignCenter: true,

        slidesSpacing: 0,

        loop: false,

        loopRewind: true,

        numImagesToPreload: 2,

    });





    //Special scroll

    $.mCustomScrollbar.defaults.scrollButtons.enable = true;

    $.mCustomScrollbar.defaults.axis = "y";

    $('.special-news').mCustomScrollbar({theme: "dark-thin"});





    //Main feedbacks

    $('.feedback-block .bxslider').bxSlider({

        controls: false,

        adaptiveHeight: true,

        onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {

            $('.feedback-block .active-slide').removeClass('active-slide');

            $('.feedback-block .bxslider>li').eq(currentSlideHtmlObject + 1).addClass('active-slide')

        },

        onSliderLoad: function () {

            $('.feedback-block .bxslider>li').eq(1).addClass('active-slide')

        }

    });

    $('.feedbtn').click(function () {

        $('#Feedback_image').click();

    })

    $('#Feedback_image').change(function () {

        $('.fotochoose').css('display', 'block');

    })





    //Crowdfunding slider

    //$('.crowdfund-bxslider').bxSlider({

    //pagerCustom: '#bx-pager2',

    //mode: 'vertical',

    //controls: false

    //});





    $('.album-slider').bxSlider({

        minSlides: 3,

        maxSlides: 3,

        slideWidth: 340,

        slideMargin: 30,

        pager: false,

        infiniteLoop: false,

        hideControlOnEnd: true

    });



    $('.news-slider').bxSlider({

        minSlides: 2,

        maxSlides: 2,

        slideWidth: 300,

        slideMargin: 30,

        pager: false,

        infiniteLoop: false,

        hideControlOnEnd: true

    });





    //Tender button

    $('.btn-tender').click(function () {

        if ($(this).hasClass('collapsed')) {

            $(this).html('Скрыть тендер');

        } else {

            $(this).html('Раскрыть тендер');

        }

        ;

    });



    //Vacancies button

    $('.btn-vacancy').click(function () {

        if ($(this).hasClass('collapsed')) {

            $(this).html('Скрыть вакансию');

        } else {

            $(this).html('Раскрыть вакансию');

        }

        ;

    });




    //3D tour
    $('.tour-link').click(function (e) {
		e.preventDefault();
		var target_3d = $(this).attr('href');
		$(target_3d).addClass('visible');
    });
    $('.btn-close-3d').click(function () {
		$('.tour').removeClass('visible');
    });





    //Scroll to top, croudfund button, scroll down

    $(window).scroll(function () {

        var sticky = $('.btn-scroll-top');

        var sticky2 = $('.btn-croudfund');

        $(window).scrollTop() >= 250 ? sticky.addClass('scroll-top-visible') : sticky.removeClass('scroll-top-visible');

        $(window).scrollTop() >= 250 ? sticky2.addClass('btn-croudfund-visible') : sticky2.removeClass('btn-croudfund-visible');

    });



    $('.btn-scroll-top').click(function (e) {

        e.preventDefault();

        $("html,body").animate({scrollTop: $("body").offset().top}, 600);

    });



    $(document).on("click", ".pager a", function () {

        $("html,body").animate({scrollTop: $("body").offset().top}, 400);

    });





    //Video show

    $('.video-item').fancybox({

        openEffect: 'none',

        closeEffect: 'none',

        helpers: {

            media: {}

        }

    });





});





$(window).resize(function () {

    //Special scroll

    $('.special-news').mCustomScrollbar("update");

});





$(function () {

    $(".vote_up, .vote_down").click(function (e) {

        e.preventDefault();



        var self = $(this);

        var voted = self.hasClass('voted-thumb');

        var idea_id = self.data('idea-id');

        var vote_id = self.data('vote-id');

        var href = "/api/vote/" + idea_id + "/";



        var idea_id = self.data('idea-id');

        var vote_id = self.data('vote-id');



        if (voted) {

            href = href + '0'

        } else {

            href = href + vote_id;

        }



        $.ajax({

            url: href,

            type: "GET",

            dataType: "json",

            success: function (response) {

                self.parent().find(".votes-count").html(response.count);

                if (voted) {

                    self.parent().find(".votes").removeClass('voted-thumb');

                } else {

                    self.parent().find(".votes").removeClass('voted-thumb');

                    self.addClass('voted-thumb');

                }

            }

        });

    });

});