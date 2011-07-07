<?php

class OfferCalc_Widget extends WP_Widget {
	public function OfferCalc_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'offercalc_widget', 'description' => 'The Offer Calc Widget for calculation' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'offercalc-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'offercalc-widget', 'Offer Calc Widget', $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
			
		echo $before_widget;
		echo $before_title;
		echo $after_title;
		$this->outputWidget($args, $instance);
		echo $after_widget;
	}

	private function outputWidget($args, $instance) {
		$offer_slug = $instance['offer_slug'];
		
		global $wpdb;
		$fields = $wpdb->get_results("SELECT * FROM offercalc_fields where offer_slug = '$offer_slug';");

		$widget_id = $this->number;
		include_once('widget_view.tpl');
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['offer_slug'] = strip_tags($new_instance['offer_slug']);
        return $instance;
    }
	
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'offer_slug' => 'Offer Slug');
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'offer_slug' ); ?>">Offer slug:</label>
			<input id="<?php echo $this->get_field_id( 'offer_slug' ); ?>" name="<?php echo $this->get_field_name( 'offer_slug' ); ?>" value="<?php echo $instance['offer_slug']; ?>" style="width:100%;" />
		</p>

	<?php 
	}
}

add_action( 'widgets_init', 'load_offercalc_widget' );

function load_offercalc_widget() {
	register_widget( 'OfferCalc_Widget' );
}