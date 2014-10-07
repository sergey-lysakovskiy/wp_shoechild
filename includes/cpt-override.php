<?php

add_action('shoestrap_content_override','set_template_for_custom_post_type_archive');

function set_template_for_custom_post_type_archive () {
    ss_get_template_part( 'templates/content', get_post_type() );
}

add_action('template_redirect','before_cpt_archive_settings');

function before_cpt_archive_settings () {
    global $query_string, $ss_settings;
    
    $post_type = get_query_var('post_type');
    if ($post_type && $ss_settings[$post_type.'_posts_per_page'])    
        query_posts( $query_string . '&posts_per_page='.$ss_settings[$post_type.'_posts_per_page'] );
    
}

add_action('wp_enqueue_scripts','masonry_archive_settings',1000);

function masonry_archive_settings () {
    global $ss_settings;
    
    $custom_css = '';

    $post_type = get_query_var('post_type');
    if($post_type && $ss_settings[$post_type.'_layout_type']) {
        $ss_settings[$post_type.'_column_type'];
        
        $column_padding = $ss_settings[$post_type.'_column_padding'] / 2;
        
        if ($ss_settings[$post_type.'_infinite_scroll'])
            $custom_css .= "nav.pagination { display: none }";
        
        $custom_css .= ".entries-wrapper { margin: 0 -{$column_padding}px; }";
        $custom_css .= ".entries-wrapper article { padding: 0 {$column_padding}px; display:none } article.isotope { display: block }";

        if ($ss_settings[$post_type.'_column_type']==0) {
            $custom_css .= ".entries-wrapper article { width: {$ss_settings[$post_type.'_column_width']}px }";

        } elseif ($ss_settings[$post_type.'_column_type']==1) {
            $custom_css .= ".entries-wrapper article { box-sizing:border-box }";
            $xs_width = round ( 100 / $ss_settings[$post_type.'_columns_num_xs'], 3, PHP_ROUND_HALF_DOWN );
            $custom_css .= "@media (max-width: 768px) { .entries-wrapper article { width: $xs_width% } }";
            $sm_width = round ( 100 / $ss_settings[$post_type.'_columns_num_sm'], 3, PHP_ROUND_HALF_DOWN );
            $custom_css .= "@media (min-width: 768px) { .entries-wrapper article { width: $sm_width% } }";
            $md_width = round ( 100 / $ss_settings[$post_type.'_columns_num_md'], 3, PHP_ROUND_HALF_DOWN );
            $custom_css .= "@media (min-width: 992px) { .entries-wrapper article { width: $md_width% } }";
            $lg_width = round ( 100 / $ss_settings[$post_type.'_columns_num_lg'], 3, PHP_ROUND_HALF_DOWN );
            $custom_css .= "@media (min-width: 1200px) { .entries-wrapper article { width: $lg_width% } }";
        }
        
        wp_add_inline_style( 'shoestrap_css', $custom_css );
    }
}

add_action('shoestrap_index_begin','set_loop_wrapper_begin');

function set_loop_wrapper_begin () {
    global $ss_settings;
    $post_type = get_query_var('post_type');
    if ($ss_settings[$post_type.'_layout_type']==1) $type = 'masonry';
    elseif ($ss_settings[$post_type.'_layout_type']==2) $type = 'fitRows';
?>
    <div class="entries-wrapper post-type-<?php echo get_post_type() ?> <?php if($ss_settings[$post_type.'_layout_type']): ?>isotope<?php endif; ?> <?php if($ss_settings[$post_type.'_infinite_scroll']): ?>infinite-scroll<?php endif; ?>" layout-type="<?php echo $type ?>">
<?php
}

add_action('shoestrap_index_end','set_loop_wrapper_end');

function set_loop_wrapper_end () {
    ?>
    </div>
<?php
}

add_action('shoestrap_cpt_entry_meta','cpt_featured_image');

function cpt_featured_image() {
    global $ss_framework, $ss_settings;
    
    $cpt = get_post_type();

    $data = array();

    if ( ! has_post_thumbnail() || '' == get_the_post_thumbnail() ) {
            return;
    }
    
    $data['width']  = Shoestrap_Layout::content_width_px();

    if ( is_singular() && !is_page() ) {
            // Do not process if we don't want images on single posts
            if ( $ss_settings[$cpt.'_feat_img_post'] != 1 ) {
                    return;
            }

            $data['url'] = wp_get_attachment_url( get_post_thumbnail_id() );

            if ( $ss_settings[$cpt.'_feat_img_post_custom_toggle'] == 1 ) {
                    $data['width']  = $ss_settings[$cpt.'_feat_img_post_width'];
            }

            $data['height'] = $ss_settings[$cpt.'_feat_img_post_height'];

    } else {
            // Do not process if we don't want images on post archives
            if ( $ss_settings[$cpt.'_feat_img_archive'] != 1 ) {
                    return;
            }

            $data['url'] = wp_get_attachment_url( get_post_thumbnail_id() );

            if ( $ss_settings[$cpt.'_feat_img_archive_custom_toggle'] == 1 ) {
                    $data['width']  = $ss_settings[$cpt.'_feat_img_archive_width'];
            }

            $data['height'] = $ss_settings[$cpt.'_feat_img_archive_height'];

    }

    $image = Shoestrap_Image::image_resize( $data );

    echo $ss_framework->clearfix() . '<a href="' . get_permalink() . '"><img class="featured-image ' . $ss_framework->float_class('left') . '" src="' . $image['url'] . '" /></a>';
}