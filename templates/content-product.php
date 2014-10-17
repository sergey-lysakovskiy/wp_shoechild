<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

?>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
    <article <?php post_class( $classes ); ?>>
        <div class="inside-layer">
            <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                    <div class="product-header">
                        <h3><?php the_title(); ?></h3>
                        <?php
                            woocommerce_template_loop_product_thumbnail();
                        ?>
                    </div>
            
                    <?php
                            /**
                             * woocommerce_after_shop_loop_item_title hook
                             *
                             * @hooked woocommerce_template_loop_rating - 5
                             * @hooked woocommerce_template_loop_price - 10
                             */
                            do_action( 'woocommerce_after_shop_loop_item_title' );
                    ?>
            
                    <div class="review-block">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/userdata/i/stars.png"><br>
                        <a href="#">Read 2 Reviews</a><br>
                        <a href="#">Write a review</a>
                    </div>
                    
                    <div class="quantity-label">quantity</div>
            <?php woocommerce_quantity_input(); woocommerce_template_loop_add_to_cart(); ?>
        </div>
    </article>
</div>