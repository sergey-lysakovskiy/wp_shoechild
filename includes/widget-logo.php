<?php
class LogoWidget extends WP_Widget {

	function LogoWidget() {
		$widget_ops = array('classname' => 'sitelogo', 'description' => 'Shows logo of the site');
		$this->WP_Widget('sitelogo', 'Site logo', $widget_ops);
	}

	function widget( $args, $instance ) {
            global $ss_settings;
            
            $logo = $ss_settings['logo'];
            ?>
<div class="site-logo"><a href="<?php echo site_url() ?>"><img src="<?php echo $logo['url'] ?>" width="<?php echo $logo['width'] ?>" height="<?php echo $logo['height'] ?>"></a></div>
            <?php                
	}

	function update( $new_instance, $old_instance ) {
		return $instance;		
	}

	function form( $instance ) {
            ?>
            <p>No additional options available</p>
            <?php
	}
}