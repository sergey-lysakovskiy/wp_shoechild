jQuery(document).ready(function($){
    $(document).on('change',".product input[name=quantity]",function(){
        var quant = $(this).val();
        $(this).parents('.product').find('.add_to_cart_button').attr('data-quantity',quant);
    });
});