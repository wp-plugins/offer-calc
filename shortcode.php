<?php 

/**
 * 
 * Registering the shortcode via the widget
 * 10x to http://digwp.com/2010/04/call-widget-with-shortcode/
 * 
 * @param widget_name expected
 * 
 */

function ofc_shortcode($atts) {
    ob_start();
    $widget_name = 'OfferCalc_Widget';
    $instance['offer_slug'] = $atts['offer_slug'];
    $shortcode_widget_id = rand(200, 3255200);
    $instance['shortcode_widget_id'] = $shortcode_widget_id;
    
    the_widget($widget_name, $instance, array(
        'before_title' => '',
        'after_title' => ''
    ));
    
    
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('ofc_shortcode','ofc_shortcode');