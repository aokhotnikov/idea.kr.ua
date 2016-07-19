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

function addVote(vote){
    $.ajax({
        url: 'main/add-vote?vote='+vote,
        type: "GET",
        //dataType: "json",
        success: function (response) {
             if (response) alert('Ваш голос принят');
        }
    });
}


$('#tags').select2({
    language: "ru",
    placeholder: "Можете ввести категорию или выбрать из списка...",
    maximumSelectionLength: 5,
    //tokenSeparators: [',', ' '],
    tags: true
});