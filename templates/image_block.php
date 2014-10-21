<?php global $wp_config ?>

<section class="content-part fullwidth-image <?php if($wp_config['t_vars']['opts']['overlay']): ?>absolute<?php endif; ?> <?php if($wp_config['t_vars']['opts']['parallax']): ?>parallax<?php endif; ?>" style="background-image: url('<?php echo $wp_config['t_vars']['image']['url'] ?>'); height:<?php echo $wp_config['t_vars']['opts']['height'] ?>px; background-size: cover; <?php if($wp_config['t_vars']['opts']['window_effect']): ?>background-attachment: fixed;<?php endif; ?>;"></section>
