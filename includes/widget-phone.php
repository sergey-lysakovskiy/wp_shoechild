<?php
class PhoneWidget extends WP_Widget {

	function PhoneWidget() {
		$widget_ops = array('classname' => 'sitephone', 'description' => 'Shows contact phone');
		$this->WP_Widget('sitephone', 'Site contact phone', $widget_ops);
	}

	function widget( $args, $instance ) {
            
            $phone = get_option( 'sitephone', '' );

            ?>
            <div class="widget-phone" id="<?php echo $args['widget_id'] ?>">
                <span class="phone"><?php echo $phone ?></span>
            </div>
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