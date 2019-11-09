<?php


if (!function_exists('carousel_content')) {
    function carousel_content($atts, $content = null)
    {
        return '<div class="owl-carousel content-carousel content-slider">' . do_shortcode($content) . '</div>';
    }
    add_shortcode('carousel_content', 'carousel_content');
}

if (!function_exists('single_carousel_content')) {
    function single_carousel_content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => 'Flexible & Customizable',
            'description' => '',
            'url' => '',
            'img' => '',
        ), $atts));

        $url = ($url == '||') ? '' : $url;
        $url = ps_build_link($url);
        $a_link = $url['url'];
        $a_title = ($url['title'] == '') ? '' : 'title="' . $url['title'] . '"';
        $a_target = ($url['target'] == '') ? '' : 'target="' . $url['target'] . '"';
        $button = $a_link ? '<a class="btn btn-md btn-black" href="' . $a_link . '" ' . $a_title . ' ' . $a_target . '>' . $url['title'] . '</a>' : '';

        $image = wp_get_attachment_image_src($img, 'full');
        $image_src = $image['0'];

        $output = '<div class="item">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mb-sm-30">
                                <img src="' . $image_src . '" alt="" />
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <h3>' . $title . '</h3>
                                <div class="spacer-15"></div>
                                ' . $description . '
                                <div class="spacer-15"></div>
                                ' . $button . '
                            </div>
                        </div>
                    </div>
                </div>';

        return $output;
    }
    add_shortcode('single_carousel_content', 'single_carousel_content');
}

// Mapping
vc_map(array(
    "name" => __("Carousel Content", "mozel"),
    "base" => "carousel_content",
    "as_parent" => array('only' => 'single_carousel_content'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "js_view" => 'VcColumnView',
    "category" => array('Mozel', 'Content'),
));

vc_map(array(
    "name" => __("Single Carousel Content", "mozel"),
    "base" => "single_carousel_content",
    "content_element" => true,
    "as_child" => array('only' => 'carousel_content'),
    "show_settings_on_create" => true,
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", "mozel"),
            "param_name" => "title",
        ),
        array(
            "type" => "textarea",
            "heading" => __("Description", "mozel"),
            "param_name" => "description",
        ),
        array(
            'type' => 'vc_link',
            'heading' => __('Button', 'mozel'),
            'param_name' => 'url',
        ),
        array(
            'type' => 'attach_image',
            'heading' => __('Add Image', 'mozel'),
            'param_name' => 'img',
        ),
    ),
));

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Carousel_Content extends WPBakeryShortCodesContainer
    {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Single_Carousel_Content extends WPBakeryShortCode
    {
    }
}
