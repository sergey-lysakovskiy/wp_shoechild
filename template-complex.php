<?php
/*
Template Name: Complex page
*/

global $ss_framework, $ss_settings, $wp_config;

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
<div class="row-fluid <?php if($anchor): ?>waypoint-block<?php endif; ?> <?php if($columns_count>1): ?>max-width-wrapper<?php endif; ?>" <?php if($anchor): ?>id="<?php echo sanitize_title($anchor_name) ?>"<?php endif; ?>>
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
                            
                            $wp_config['t_vars'] = '';
                            
                            $wp_config['t_vars']['title'] = get_sub_field('title');
                            $wp_config['t_vars']['san_title'] = ($title) ? sanitize_title($title) : 'content-part-'.$index;
                            
                            
                            $opts = get_sub_field('options');
                            if(is_array($opts)) {
                                $wp_config['t_vars']['opts'] = array_shift($opts);
                            }
                            
                            $templates = array(
                                'userdata/templates/'.$layout.'-'.$san_title.'.php',
                                'templates/'.$layout.'-'.$san_title.'.php',
                                'userdata/templates/'.$layout.'.php',
                                'templates/'.$layout.'.php'
                            );
                            
                            switch ($layout):
                                case 'text_block':
                                    $wp_config['t_vars']['content'] = get_sub_field('content');
                                    $wp_config['t_vars']['classes'][] = $wp_config['t_vars']['opts']['css_class'];
                                    $wp_config['t_vars']['classes'][] = $wp_config['t_vars']['san_title'];
                                    if($wp_config['t_vars']['opts']['anchor'])
                                        $wp_config['t_vars']['classes'][] = 'waypoint-block';
                                    
                                    if($wp_config['t_vars']['opts']['height'])
                                        $wp_config['t_vars']['classes'][] = 'slide';
                                break;
                                case 'image_block':
                                    $wp_config['t_vars']['image'] = get_sub_field('image');
                                break;
                                case 'entries_block':
                                    $cpt_opts = array_shift(get_sub_field('post_type_options'));
                                    $wp_config['t_vars']['post_type'] = $cpt_opts['post_type'];
                                    $wp_config['t_vars']['pre'] = 'pt_'.$wp_config['t_vars']['post_type'].'_'.$index;
                                    $wp_config['t_vars']['posts_count'] = $cpt_opts['posts_count'];
                                    
                                    $use_opt = get_sub_field('individual_settings');
                                    
                                    $layout_opts = array_shift(get_sub_field('layout_options'));
                                    $wp_config['t_vars']['layout_type'] = ($use_opt) ? $layout_opts['layout_type'] : $ss_settings[$wp_config['t_vars']['post_type'].'_layout_type'];
                                    $column_padding = ($use_opt) ? $layout_opts['column_padding'] : $ss_settings[$wp_config['t_vars']['post_type'].'_column_padding'];
                                    
                                    
                                    $columns_num = array_shift(get_sub_field('columns_num'));
                                    foreach ($media_sizes as $size => $value) {
                                        $col_num[$size] = ($use_opt) ? $columns_num[$size] : $ss_settings[$wp_config['t_vars']['post_type'].'_columns_num_'.$size];
                                    }
                                    
                                    if ($wp_config['t_vars']['layout_type']==1) $wp_config['t_vars']['type'] = 'masonry';
                                    elseif ($wp_config['t_vars']['layout_type']==2) $wp_config['t_vars']['type'] = 'fitRows';
                                    
                                    if ($wp_config['t_vars']['layout_type']):
                                        $custom_css = '';
                                    
                                        $wp_config['t_vars']['column_padding'] /= 2;


                                        $custom_css .= "#".$wp_config['t_vars']['pre'].".entries-wrapper { margin: 0 -".$column_padding."px; }";
                                        $custom_css .= "#".$wp_config['t_vars']['pre'].".entries-wrapper article { padding: 0 ".$column_padding."px; box-sizing:border-box }";

                                        foreach ($media_sizes as $size => $value) {
                                            $width = 100 / $col_num[$size];
                                            $custom_css .= "\n @media ({$media_sizes[$size]}) { #".$wp_config['t_vars']['pre'].".entries-wrapper article { width: ".$width."% }  }";
                                        }

                                        echo '<style type="text/css">' . $custom_css . '</style>';
                                    endif;
                                break;
                                case 'features_block':
                                    $columns_num = array_shift(get_sub_field('columns_num'));
                                    $wp_config['t_vars']['items'] = get_sub_field('items');
                                    $wp_config['t_vars']['numbered'] = $opts['numbered'];
                                    $column_padding = $opts['column_padding'];
                                    
                                    $custom_css = '';
                                    
                                    $custom_css .= ".features-wrapper .feature-item { padding: 0 {$column_padding}px; box-sizing:border-box }";
                                    
                                    foreach ($media_sizes as $size => $value) {
                                        $width = 100 / $columns_num[$size];
                                        $custom_css .= "\n @media ({$media_sizes[$size]}) { .features-wrapper .feature-item { width: {$width}% }  }";
                                        
                                    }
                                    
                                    
                                ?>
                                <style type="text/css"><?php echo $custom_css ?></style>
                                <?php
                                break;
                                /*case 'tabs':
                                    $items = get_sub_field('items');
                                ?>
                                <section <?php if($opts['anchor']): ?>id="<?php echo $san_title ?>"<?php endif; ?> class="content-part entries-block post-type-<?php echo $post_type ?> <?php if($opts['anchor']): ?>waypoint-block<?php endif; ?>">
                                    <div class="layout-wrapper">
                                    <?php if($opts['is_title']): ?>
                                    <header>
                                        <h3 class="content-part-title"><?php echo $title ?></h3>
                                    </header>
                                    <?php endif; ?>
                                    
                                    <ul class="nav nav-tabs" role="tablist">
                                        <?php foreach ($items as $i => $item): ?>
                                        <li <?php if ($i==0):?>class="active"<?php endif; ?>><a href="#<?php echo sanitize_title($item['title']) ?>" class="hexa" role="tab" data-toggle="tab"><img src="<?php echo $item['image']['url'] ?>"><span class="title"><?php echo $item['title'] ?></span></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <?php foreach ($items as $i => $item): ?>
                                        <div class="tab-pane fade <?php if ($i==0):?>in active<?php endif; ?>" id="<?php echo sanitize_title($item['title']) ?>"><?php echo $item['description'] ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                    </div>
                                </section>
                                <?php
                               
                                break;
                                case 'woocommerce_products':
                                    $args = array(
                                        'post_type' => 'product',
                                        'posts_per_page' => 12
                                        );
                                    $loop = new WP_Query( $args );
                                    if ( $loop->have_posts() ):                                    
                                ?>
                                <section <?php if($opts['anchor']): ?>id="<?php echo $san_title ?>"<?php endif; ?> class="content-part entries-block post-type-<?php echo $post_type ?> <?php if($opts['anchor']): ?>waypoint-block<?php endif; ?>">
                                    <?php if($opts['is_title']): ?>
                                    <header>
                                        <h3 class="content-part-title"><?php echo $title ?></h3>
                                    </header>
                                    <?php endif; ?>
                                    <div class="entries-wrapper post-type-products row">
                                        <?php
                                            while ( $loop->have_posts() ) : $loop->the_post();
                                                    woocommerce_get_template_part( 'templates/content', 'product' );
                                            endwhile;
                                        ?>
                                    </div>
                                </section>  
                                <?php
                                    endif;
                                    wp_reset_postdata();                                
                                break;  */                              
                                case 'separator':
                                    $break = true;
                                break;
                            endswitch;

                            $template = locate_template($templates,true,false);

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