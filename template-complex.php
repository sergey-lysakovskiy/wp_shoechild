<?php
/*
Template Name: Complex page
*/

global $ss_framework, $ss_settings;

while ( have_posts() ) : the_post();
        if(get_field('show_title'))
            shoestrap_title_section();
	do_action( 'shoestrap_page_pre_content' );
        
        
        
        if( have_rows('blocks') ): 
            $index = 0;
            while ( have_rows('blocks') ) : the_row(); $index++;
                $columns_count = get_sub_field('columns_count');
                $anchor = get_sub_field('anchor');
                $anchor_name = get_sub_field('anchor_name');
                if ($columns_count == 1)
                    $columns_scheme = array (12);
                elseif($columns_count == 6)
                    $columns_scheme = array (2,2,2,2,2,2);
                else
                    $columns_scheme = explode('_',get_sub_field('columns_scheme_'.$columns_count));
?>
<div class="row-fluid <?php if($anchor): ?>waypoint-block<?php endif; ?>" <?php if($anchor): ?>id="<?php echo sanitize_title($anchor_name) ?>"<?php endif; ?>>
<?php
                $end_of_blocks = false;
                $layout_count = count(get_sub_field('layout'));
                $layout_index = 0;

                for ($column=0;$column<count($columns_scheme);$column++):
?>
    <div class="col-md-<?php echo $columns_scheme[$column] ?> no-padding">
<?php                    
                    if ( have_rows('layout') &&  $layout_index < $layout_count ):
                        while ( have_rows('layout') ) : the_row(); 
                            $break = false;
                            $layout = get_row_layout();
                            
                            $title = get_sub_field('title');
                            $san_title = ($title) ? sanitize_title($title) : 'content-part-'.$index;
                            $opts = get_sub_field('options');
                            
                            switch ($layout):
                                case 'text_block':
                                    $content = get_sub_field('content');
                                    $height = get_sub_field('height') ? 'height:'.get_sub_field('height') . 'px' : '';
                                ?>
                                <section <?php if($opts['anchor']): ?>id="<?php echo $san_title ?>"<?php endif; ?> class="content-part text-block <?php echo $san_title ?> <?php if($opts['anchor']): ?>waypoint-block<?php endif; ?>" style="<?php echo $height; ?>">
                                    <div class="layout-wrapper">
                                    <?php if($opts['is_title']): ?>
                                    <header>
                                        <h3 class="content-part-title"><?php echo $title ?></h3>
                                    </header>
                                    <?php endif; ?>
                                    <?php if($content): ?>
                                    <div class="content-part-text">
                                        <?php echo $content ?>
                                    </div>
                                    <?php endif; ?>
                                    </div>
                                </section>
                                <?php
                                break;
                                case 'image_block':
                                    $image = get_sub_field('image');
                                    $height = get_sub_field('height');
                                    $window_effect = get_sub_field('window_effect');
                                    $overlay = get_sub_field('overlay');
                                ?>
                                <section class="content-part fullwidth-image <?php if($overlay): ?>absolute<?php endif; ?>" style="background-image: url('<?php echo $image['url'] ?>'); height:<?php echo $height ?>px; background-size: cover; <?php if($window_effect): ?>background-attachment: fixed<?php endif; ?>;"></section>
                                <?php
                                break;
                                case 'entries_block':
                                    $cpt_opts = array_shift(get_sub_field('post_type_options'));
                                    $post_type = $cpt_opts['post_type'];
                                    $pre = 'pt_'.$post_type.'_'.$index;
                                    $posts_count = $cpt_opts['posts_count'];
                                    
                                    $use_opt = get_sub_field('individual_settings');
                                    
                                    $layout_opts = array_shift(get_sub_field('layout_options'));
                                    $layout_type = ($use_opt) ? $layout_opts['layout_type'] : $ss_settings[$post_type.'_layout_type'];
                                    $column_padding = ($use_opt) ? $layout_opts['column_padding'] : $ss_settings[$post_type.'_column_padding'];
                                    
                                    
                                    $columns_num = array_shift(get_sub_field('columns_num'));
                                    foreach ($media_sizes as $size => $value) {
                                        $col_num[$size] = ($use_opt) ? $columns_num[$size] : $ss_settings[$post_type.'_columns_num_'.$size];
                                    }
                                    
                                    if ($layout_type==1) $type = 'masonry';
                                    elseif ($layout_type==2) $type = 'fitRows';
                                    
                                    if ($layout_type):
                                        $custom_css = '';
                                    
                                        $column_padding /= 2;


                                        $custom_css .= "#${pre}.entries-wrapper { margin: 0 -{$column_padding}px; }";
                                        $custom_css .= "#${pre}.entries-wrapper article { padding: 0 {$column_padding}px; box-sizing:border-box }";

                                        foreach ($media_sizes as $size => $value) {
                                            $width = 100 / $col_num[$size];
                                            $custom_css .= "\n @media ({$media_sizes[$size]}) { #{$pre}.entries-wrapper article { width: {$width}% }  }";
                                        }

                                        echo '<style type="text/css">' . $custom_css . '</style>';
                                    endif;

                                ?>
                                <section <?php if($opts['anchor']): ?>id="<?php echo $san_title ?>"<?php endif; ?> class="content-part entries-block post-type-<?php echo $post_type ?> <?php if($opts['anchor']): ?>waypoint-block<?php endif; ?>">
                                    <?php if($opts['is_title']): ?>
                                    <header>
                                        <h3 class="content-part-title"><?php echo $title ?></h3>
                                    </header>
                                    <?php endif; ?>
                                    <div id="<?php echo $pre ?>" class="entries-wrapper post-type-<?php echo $post_type ?> <?php if($layout_type): ?>wrapper-isotope<?php endif; ?>" layout-type="<?php echo $type ?>">
                                    <?php 
                                        // WP_Query arguments
                                        $args = array (
                                                'post_type'              => $post_type,
                                                'posts_per_page'         => $posts_count,
                                        );

                                        // The Query
                                        $query = new WP_Query( $args );

                                        // The Loop
                                        if ( $query->have_posts() ):
                                            while ( $query->have_posts() ):
                                                $query->the_post();
                                                get_template_part('templates/loop',$post_type);
                                            endwhile;
                                        endif;
                                    ?>
                                    </div>
                                    <?php if($opts['is_archive_link']): ?>
                                        <div class="content-part-link"><a href="<?php echo get_post_type_archive_link( $post_type ); ?>" rel="bookmark">See all</a></div>
                                    <?php endif; ?>
                                </section>
                                <?php
                                    // Restore original Post Data
                                    wp_reset_postdata();
                                break;
                                case 'features_block':
                                    $columns_num = array_shift(get_sub_field('columns_num'));
                                    $items = get_sub_field('items');
                                    $numbered = get_sub_field('numbered');
                                    $column_padding = get_sub_field('column_padding');
                                    
                                    $custom_css = '';
                                    
                                    $custom_css .= ".features-wrapper .feature-item { padding: 0 {$column_padding}px; box-sizing:border-box }";
                                    
                                    foreach ($media_sizes as $size => $value) {
                                        $width = 100 / $columns_num[$size];
                                        $custom_css .= "\n @media ({$media_sizes[$size]}) { .features-wrapper .feature-item { width: {$width}% }  }";
                                        
                                    }
                                    
                                    
                                ?>
                                <style type="text/css"><?php echo $custom_css ?></style>
                                <script type="text/javascript">
                                    var slider = new MasterSlider();
                                    slider.setup('masterslider' , {
                                            width:800,    // slider standard width
                                            height:350,   // slider standard height
                                            space:5,
                                            fullwidth:true,
                                            autoHeight:true,
                                            view:"mask"
                                            // more slider options goes here...
                                        });
                                    // adds Arrows navigation control to the slider.
                                    slider.control('arrows');
                                </script>
                                <section <?php if($opts['anchor']): ?>id="<?php echo $san_title ?>"<?php endif; ?> class="content-part entries-block post-type-<?php echo $post_type ?> <?php if($opts['anchor']): ?>waypoint-block<?php endif; ?>">
                                    <?php if($opts['is_title']): ?>
                                    <header>
                                        <h3 class="content-part-title"><?php echo $title ?></h3>
                                    </header>
                                    <?php endif; ?>
                                    <div class="features-wrapper wrapper-isotope" layout-type="fitRows">
                                        <?php foreach ($items as $i => $item): ?>
                                        <article class="feature-item">
                                            <?php if($numbered): ?><div class="item-position"><?php echo $i+1 ?></div><?php endif; ?>
                                            <?php if($item['image']): ?><div class="item-image"><img src="<?php echo $item['image']['url'] ?>"></div><?php endif; ?>    
                                            <?php if($item['title']): ?><h3 class="item-title"><?php echo $item['title'] ?></h3><?php endif; ?>    
                                            <?php if($item['subtitle']): ?><h4 class="item-subtitle"><?php echo $item['subtitle'] ?></h4><?php endif; ?>    
                                            <?php if($item['description']): ?><div class="item-description"><?php echo $item['description'] ?></div><?php endif; ?>    
                                        </article>
                                        <?php endforeach; ?>
                                    </div>
                                </section>
                                <?php
                                break;
                                case 'separator':
                                    $break = true;
                                break;
                            endswitch;

                            $layout_index++;
                            if($break) break;
                        endwhile;
                    endif;  
?>
        </div><!-- .col-md-<?php echo $columns_scheme[$column] ?> -->
<?php  
                endfor;
?>
            <div class="clearfix"></div>
    </div><!-- .row-fluid -->
<?php            
            endwhile;
        endif;
	echo $ss_framework->clearfix();
	do_action( 'shoestrap_page_after_content' );
endwhile;