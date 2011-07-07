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
		$form_id = $instance['form_id'];
		
		global $wpdb;
		$fields = $wpdb->get_results("SELECT * FROM offercalc_fields where offer_slug = '$form_id';");

		include_once('widget_view.tpl');
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['form_id'] = strip_tags($new_instance['form_id']);
        return $instance;
    }
	
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'form_id' => 'Form Slug ID');
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'form_id' ); ?>">Form ID:</label>
			<input id="<?php echo $this->get_field_id( 'form_id' ); ?>" name="<?php echo $this->get_field_name( 'form_id' ); ?>" value="<?php echo $instance['form_id']; ?>" style="width:100%;" />
		</p>

	<?php 
	}
}

add_action( 'widgets_init', 'load_offercalc_widget' );

function load_offercalc_widget() {
	register_widget( 'OfferCalc_Widget' );
}