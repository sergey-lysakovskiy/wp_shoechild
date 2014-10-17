jQuery(document).ready(function($){
    /*var $container = $('.entries-wrapper');
    // init
    $container.isotope({
        // options
        itemSelector: 'article',
        layoutMode: 'fitRows'
    });*/    
    
    $('a[data-toggle=tab]').click(function(){
        console.log($(this).parents('.nav-tabs'));
       $(this).parents('.nav-tabs').removeClass('li-1');
       $(this).parents('.nav-tabs').removeClass('li-2');
       $(this).parents('.nav-tabs').addClass('li-'+$(this).parent().index());
    })
})