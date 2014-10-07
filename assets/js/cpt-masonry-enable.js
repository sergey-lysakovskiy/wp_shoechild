jQuery(document).ready(function($){
    document.iso_container = $('.wrapper-isotope').imagesLoaded( function() {
        $('.wrapper-isotope article').addClass('isotope');

        $(document.iso_container).isotope({
            // options
            itemSelector: 'article',
            layoutMode: $(document.iso_container).attr('layout-type'),
        });    
    });
    
    // init
})

function infinite_scroll_callback() {
    $ = jQuery;
    if(document.iso_container !== 'undefined') {
        $('.entries-wrapper').imagesLoaded( function() {
            $('.entries-wrapper article').each(function(){
                if($(this).css('position')!=='absolute') {
                    $(this).addClass('isotope');
                    $(document.iso_container).isotope('appended',this);
                }
            });
        });
    }
}