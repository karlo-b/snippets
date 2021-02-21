<?php


// Content Slider

if (!function_exists('carousel_content')) {
	function carousel_content($atts, $content = null){
		extract(shortcode_atts(array(
			'loop' => 'true',
			'slides_per_view' => 1,
			'spacing' => 0,
			'centered' => 'false',
			'arrow_prev' => 'arrow-left',
			'arrow_next' => 'arrow-next',
	), $atts));

		$arrow_prev = ( $atts['arrow_prev'] ) ? $atts['arrow_prev'] : 'arrow-left';
		$arrow_next = ( $atts['arrow_next'] ) ? $atts['arrow_next'] : 'arrow-right';

		$slider_options = array();

		$slider_options['loop'] = ( $atts['loop'] )? $atts['loop'] : false;
		$slider_options['centered'] = ( $atts['centered'] ) ? $atts['centered'] : false;
		$slider_options['spacing'] = ( $atts['spacing'] ) ? $atts['spacing'] : 0;
		$slider_options['slidesPerView'] = ( $atts['slides_per_view'] ) ? $atts['slides_per_view'] : 1;
		$slider_options['mode'] = 'snap';

		$output = '<div class="navigation-wrapper keen-slider-wrap">';
		$output .= '<div class="keen-slider" data-mobile="'.$atts['slides_per_view_mobile'].'" data-tablet="'.$atts['slides_per_view_tablet'].'" data-keen="'.htmlspecialchars(json_encode($slider_options), ENT_QUOTES, 'UTF-8').'">';
		$output .=  do_shortcode($content);
		$output .= '</div>';
		$output .= '<svg class="arrow arrow-prev xt-icon xt-icon-'. $arrow_prev . '" viewBox="0 0 24 24"><use xlink:href="#xt-icon-'. $arrow_prev . '"></use></svg>';
		$output .= '<svg class="arrow arrow-next xt-icon xt-icon-'. $arrow_next . '" viewBox="0 0 24 24"><use xlink:href="#xt-icon-'. $arrow_next . '"></use></svg>';
		$output .= '<div class="dots"></div>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode('carousel_content', 'carousel_content');
}
// Mapping
vc_map(array(
	'name' => __('Carousel Content', 'xstream'),
	'base' => 'carousel_content',
	'as_parent' => array('only' => 'single_carousel_content'),
	'content_element' => true,
	'show_settings_on_create' => false,
	'is_container' => true,
	'js_view' => 'VcColumnView',
	'category' => array('XT', 'Content'),
	'params' => array(
		array(
				'type' => 'checkbox',
				'heading' => __('Loop', 'xstream'),
				'param_name' => 'loop',
				'value'      => array( __( 'Enable', 'xstream' ) => 'true' ),
				'std'              => '',
		),
		array(
				'type' => 'textfield',
				'heading' => __('Slides Per View', 'xstream'),
				'param_name' => 'slides_per_view',
		),
		array(
			'type' => 'textfield',
			'heading' => __('Slides Per View Tablet', 'xstream'),
			'param_name' => 'slides_per_view_tablet',
	),
		array(
			'type' => 'textfield',
			'heading' => __('Slides Per View Mobile', 'xstream'),
			'param_name' => 'slides_per_view_mobile',
	),
		array(
			'type' => 'textfield',
			'heading' => __('Spacing', 'xstream'),
			'param_name' => 'spacing',
	),
		array(
			'type' => 'checkbox',
			'heading' => __('Centered', 'xstream'),
			'param_name' => 'centered',
			'value'      => array( __( 'Enable', 'xstream' ) => 'true' ),
			'std'         => '',
	),
	array(
		'type' => 'textfield',
		'heading' => __( 'Previous Arrow Icon', 'textdomain' ),
		'param_name' => 'arrow_prev',
		'value' => 'arrow-left',
		'description' => __( 'Use svg sprite icon name e.g. arrow-left', 'textdomain' ),
		'std' => 'arrow-left',
	),
	array(
		'type' => 'textfield',
		'heading' => __( 'Next Arrow Icon', 'textdomain' ),
		'param_name' => 'arrow_next',
		'value' => 'arrow-next',
		'description' => __( 'Use svg sprite icon name e.g. arrow-next', 'textdomain' ),
		'std' => 'arrow-right',
	),
),
));

if (!function_exists('single_carousel_content')) {
	function single_carousel_content($atts, $content = null)
	{
		return '<div class="keen-slider__slide">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('single_carousel_content', 'single_carousel_content');
}

vc_map(array(
	'name' => __('Single Carousel Content', 'xstream'),
	'base' => 'single_carousel_content',
	'content_element' => true,
	'as_parent' => array('only'=> 'vc_row,vc_single_image,vc_column_text'),
	'as_child' => array('only' => 'carousel_content'),
	'show_settings_on_create' => true,
	'js_view' => 'VcColumnView',

	'params' => array(
			array(
					'type' => 'textfield',
					'heading' => __('Class', 'xstream'),
					'param_name' => 'class',
			),
	),
));

if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_Carousel_Content extends WPBakeryShortCodesContainer{}
}

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Single_Carousel_Content extends WPBakeryShortCodesContainer{}
}