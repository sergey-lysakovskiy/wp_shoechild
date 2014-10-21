jQuery(document).ready(function($){
    /*var $container = $('.entries-wrapper');
    // init
    $container.isotope({
        // options
        itemSelector: 'article',
        layoutMode: 'fitRows'
    });*/    
    
    $('a[data-toggle=tab]').click(function(){
       $(this).parents('.nav-tabs').removeClass('li-1');
       $(this).parents('.nav-tabs').removeClass('li-2');
       $(this).parents('.nav-tabs').addClass('li-'+$(this).parent().index());
    })
})

jQuery( document ).ready( function( $ ) {
    $(".content-part.parallax").parallax("50%", $(window).height()*1.5,0.1, false);
    
    // smooth scroll init
    var platform = navigator.platform.toLowerCase();
    if (platform.indexOf('win') == 0 || platform.indexOf('linux') == 0) {
        if ($.browser.webkit) {
            $.srSmoothscroll();
        }
    }
    
    var deck = new $.scrolldeck({
            easing: 'easeInOutExpo',
    });
    
});
