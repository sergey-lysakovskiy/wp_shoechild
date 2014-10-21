<?php global $wp_config ?>

<section 
    <?php if($wp_config['t_vars']['opts']['anchor']): ?>id="<?php echo $wp_config['t_vars']['san_title'] ?>"<?php endif; ?> 
    class="content-part text-block <?php echo implode(' ',$wp_config['t_vars']['classes']) ?>" 
    <?php if($wp_config['t_vars']['opts']['height']): ?>style="height:<?php echo $wp_config['t_vars']['opts']['height'] ?>px"<?php endif; ?>>
    <div class="max-width-wrapper <?php if($wp_config['t_vars']['opts']['height']): ?>vertical-middle<?php endif; ?>">
        <?php if($wp_config['t_vars']['opts']['is_title']): ?>
        <header>
            <h3 class="content-part-title"><?php echo $wp_config['t_vars']['title'] ?></h3>
        </header>
        <?php endif; ?>
        <?php if($wp_config['t_vars']['content']): ?>
        <div class="content-part-text">
            <?php echo $wp_config['t_vars']['content'] ?>
        </div>
        <?php endif; ?>
        <?php if($wp_config['t_vars']['opts']['height']): ?>
        <p class="animate-build" data-build="1">Fixed width for large and medium.</p>
        <p class="animate-build" data-build="2">Fluid width for small.</p>
        <?php endif; ?>
    </div>
</section>

