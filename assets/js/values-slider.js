(function($){
    $(document).on('acf/conditional_logic/show', function( e, $target, item ){
        var el = new Array ();
        $('[data-field_name^="columns_scheme"]:visible input').each(function(){
            el.push($(this).val());
        });
    });
})(jQuery);
