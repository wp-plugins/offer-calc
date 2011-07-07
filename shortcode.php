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
    the_widget($widget_name, $instance, array(
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('ofc_shortcode','ofc_shortcode');