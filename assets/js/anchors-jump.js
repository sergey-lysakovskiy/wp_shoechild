jQuery(document).ready(function($){
    var navbar_height = $("#banner-header").height();
    
    $('.waypoint-block').waypoint(function(direction) {
        if ( $(this).attr('id') && direction === 'down') {
            $(".navigation a").removeClass("active");
            $(".navigation a[href='"+window.location+"#"+$(this).attr('id')+"']").addClass("active");
        }
    }, { offset: navbar_height }).waypoint(function(direction) {
        if ( $(this).attr('id') && direction === 'up') {
            $(".navigation a").removeClass("active");
            $(".navigation a[href='"+window.location+"#"+$(this).attr('id')+"']").addClass("active");
        }
    }, { offset: -navbar_height });    
    
    
    $('a[href*=#]:not([href=#]:not([data-toggle=tab])').click(function(e) {
        e.preventDefault();
        jumpToAnchor(this);
    });
    
    var a_name = getAnchor();
    
    $(window).load(function() {
        target = $('#'+a_name);
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top-navbar_height
          }, 500);
        }
        
    });    
    
    // removing anchor from URL
    window.location.replace("#");

    // slice off the remaining '#' in HTML5:    
    if (typeof window.history.replaceState == 'function') {
      history.replaceState({}, '', window.location.href.slice(0, -1));
    }

    
    function jumpToAnchor (link) {
        if (location.pathname.replace(/^\//,'') == link.pathname.replace(/^\//,'') && location.hostname == link.hostname) {
          var target = $(link.hash);
          target = target.length ? target : $('[name=' + link.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top - navbar_height
            }, 500);
          }
        }
    }     

    function getAnchor() {  
        var currentUrl = document.URL,
        urlParts   = currentUrl.split('#');

        return (urlParts.length > 1) ? urlParts[1] : null;
    }    
})