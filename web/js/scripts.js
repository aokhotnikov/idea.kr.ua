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

    $("#but-comm").click(function (event) {
        //отменяем стандартную обработку нажатия по ссылке
        event.preventDefault();

        //забираем идентификатор бока с атрибута href
        var id  = $(this).attr('href'),

        //узнаем высоту от начала страницы до блока на который ссылается якорь
            top = $(id).offset().top;

        //анимируем переход на расстояние - top за 1500 мс
        $('body,html').animate({scrollTop: top}, 1000);
    });

});

function addVote(vote,post_id){
    $.ajax({
        url: '/add-vote?vote='+vote+'&post_id='+post_id,
        type: "GET",
        //dataType: "json",
        success: function (response) {
            if (response){
                if (vote) {
                    $('.vote-up-' + post_id).notify("Ваш голос принят", {
                        className: "success",
                        autoHideDelay: 1000,
                        position: "right"
                    });
                }else {
                    $('.vote-down-' + post_id).notify("Ваш голос принят", {
                        className: "success",
                        autoHideDelay: 1000
                    });
                }
                var numVotes = $('.votes-count-' + post_id).text();
                $('.votes-count-' + post_id).text(++numVotes);
            }else{
                $('.vote-up-' + post_id).notify("Вы уже проголосовали за эту идею", {
                    className: "info",
                    autoHideDelay: 1000,
                    position: "right"
                });
            }
        }
    });
}



