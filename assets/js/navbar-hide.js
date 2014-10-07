jQuery( document ).ready( function( $ ) {
    var navbar_height = $("#banner-header").height();
    var mode = -1;
    $(document).on('scroll', function() {
        var trigger;
        if($('.before-main-wrapper').size())
            trigger = $('.before-main-wrapper').visible(true);
        else if ($(document).scrollTop() === 0) {
            trigger  = true;
        }
        else {
            trigger = false;
        }
        
        if(trigger) {
            if(mode!==0) {
                $("#banner-header").stop();
                mode = 0;
                if($("#banner-header").hasClass('navbar-fixed-bottom')) {
                    $("#banner-header").animate({
                        bottom: -navbar_height+'px'
                    },
                    300,function(){
                        $(this).hide();
                        mode = -1;
                    });
                    
                } else {
                    $("#banner-header").animate({
                        top: -navbar_height+'px'
                    },
                    300,function(){
                        $(this).hide();
                        mode = -1;
                    });
                }
            }
        } else {
            if(mode!==1&&$("#banner-header").css('top')!=='0px'&&$("#banner-header").css('bottom')!=='0px') {
                $("#banner-header").stop();
                mode = 1;
                if($("#banner-header").hasClass('navbar-fixed-bottom')) {
                    $("#banner-header").show().css('bottom',-navbar_height).show().animate({
                        bottom: 0
                    },
                    300,function(){
                        mode = -1;
                    });
                } else {
                    $("#banner-header").show().css('top',-navbar_height).show().animate({
                        top: 0
                    },
                    300,function(){
                        mode = -1;
                    });
                }
            }
        }
    });
});
