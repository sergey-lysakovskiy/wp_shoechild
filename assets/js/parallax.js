jQuery( document ).ready( function( $ ) {
    if($('body').hasClass('parallax')) {
        $('body').css('background-attachment', 'fixed');

        $(window).scroll(function () {
            document.body.style.backgroundPosition = "0px " + (0 - (Math.max(document.documentElement.scrollTop, document.body.scrollTop) / 4)) + "px";
        });
    }
});

