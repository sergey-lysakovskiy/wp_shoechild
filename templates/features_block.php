<?php global $wp_config ?>

<section <?php if($opts['anchor']): ?>id="<?php echo $san_title ?>"<?php endif; ?> class="content-part entries-block post-type-<?php echo $post_type ?> <?php if($opts['anchor']): ?>waypoint-block<?php endif; ?>">
    <div class="max-width-wrapper">
    <?php if($opts['is_title']): ?>
    <header>
        <h3 class="content-part-title"><?php echo $title ?></h3>
    </header>
    <?php endif; ?>
    <div class="features-wrapper wrapper-isotope" layout-type="fitRows">
        <?php foreach ($wp_config['t_vars']['items'] as $i => $item): ?>
        <article class="feature-item">
            <?php if($wp_config['t_vars']['numbered']): ?><div class="item-position"><?php echo $i+1 ?></div><?php endif; ?>
            <?php if($item['image']): ?><div class="item-image"><img src="<?php echo $item['image']['url'] ?>"></div><?php endif; ?>    
            <?php if($item['title']): ?><h3 class="item-title"><?php echo $item['title'] ?></h3><?php endif; ?>    
            <?php if($item['subtitle']): ?><h4 class="item-subtitle"><?php echo $item['subtitle'] ?></h4><?php endif; ?>    
            <?php if($item['description']): ?><div class="item-description"><?php echo $item['description'] ?></div><?php endif; ?>    
        </article>
        <?php endforeach; ?>
    </div>
    </div>
</section>
