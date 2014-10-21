<?php global $wp_config ?>

<section <?php if($wp_config['t_vars']['opts']['anchor']): ?>id="<?php echo $wp_config['t_vars']['san_title'] ?>"<?php endif; ?> class="content-part entries-block post-type-<?php echo $wp_config['t_vars']['post_type'] ?> <?php if($wp_config['t_vars']['opts']['anchor']): ?>waypoint-block<?php endif; ?>">
    <div class="max-width-wrapper">
        <?php if($wp_config['t_vars']['opts']['is_title']): ?>
        <header>
            <h3 class="content-part-title"><?php echo $title ?></h3>
        </header>
        <?php endif; ?>
        <div id="<?php echo $wp_config['t_vars']['pre'] ?>" class="entries-wrapper post-type-<?php echo $wp_config['t_vars']['post_type'] ?> <?php if($wp_config['t_vars']['layout_type']): ?>wrapper-isotope<?php endif; ?>" layout-type="<?php echo $wp_config['t_vars']['type'] ?>">
        <?php 
            // WP_Query arguments
            $args = array (
                    'post_type'              => $wp_config['t_vars']['post_type'],
                    'posts_per_page'         => $wp_config['t_vars']['posts_count'],
            );

            // The Query
            $query = new WP_Query( $args );

            // The Loop
            if ( $query->have_posts() ):
                while ( $query->have_posts() ):
                    $query->the_post();
                    get_template_part('templates/loop',$wp_config['t_vars']['post_type']);
                endwhile;
            endif;
        ?>
        </div>
        <?php if($wp_config['t_vars']['opts']['is_archive_link']): ?>
            <div class="content-part-link"><a href="<?php echo get_post_type_archive_link( $wp_config['t_vars']['post_type'] ); ?>" rel="bookmark">See all</a></div>
        <?php endif; ?>
    </div>        
</section>

<?php
    // Restore original Post Data
    wp_reset_postdata();
