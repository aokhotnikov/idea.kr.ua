jQuery(document).ready(function () {

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


    $('#tags').select2({
        language: "ru",
        placeholder: "Можете ввести категорию или выбрать из списка...",
        maximumSelectionLength: 5,
        //tokenSeparators: [',', ' '],
        tags: true
    });

});

function addVote(vote,post_id){
    $.ajax({
        url: 'main/add-vote?vote='+vote,
        type: "GET",
        //dataType: "json",
        success: function (response) {
            if (response){
                $('.vote-up-'+post_id).notify("Ваш голос принят", {
                    className: "success",
                    autoHideDelay: 1000,
                    position : "right"
                })
            }else {
                $('.vote-down-'+post_id).notify("Ваш голос принят", {
                    className: "success" ,
                    autoHideDelay: 1000
                });
            }
        }
    });
}



