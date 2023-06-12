<?php
/* ================================================================================== */
/*      Pricing List Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-menu'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

list($output,$font_styles)=lvly_item($atts);
    $tw_pricinglist_items = (array) vc_param_group_parse_atts( $atts['tw_pricinglist_items'] );
        foreach($tw_pricinglist_items as $tw_pricinglist_item) {
            $tw_pricinglist_item = shortcode_atts( array(
                'featured' => '',
                'image' => '',
                'price' => '',
                'title' => '',
                'content' => '',
                'link' => '',
            ),$tw_pricinglist_item);
            $img=wp_get_attachment_image_src($tw_pricinglist_item['image'],'thumbnail');
            $img=isset($img[0])?$img[0]:'';
            $image=$class=$data=$height='';
            if (!$img) {
                $class=' no-image';
            }
            if ($tw_pricinglist_item['featured']) {
                $class.=' featured';
            }

            $output .= '<div class="tw-menu-container uk-grid-collapse'.$class.'" data-uk-grid>';
                if ($img) {
                    $output .= '<div class="tw-menu-image uk-width-auto">';
                        $output .= '<img class="uk-border-circle" src="' . esc_url($img) . '" />';
                    $output .= '</div>';
                }
                $output .= '<div class="tw-content uk-flex uk-flex-column uk-flex-center  uk-width-expand">';
                    $output .= '<h4 class="uk-text-uppercase"'.(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).'>';
                        if (!empty($tw_pricinglist_item['link'])) { $output .= '<a class="tw-menu-title" href="'.esc_url($tw_pricinglist_item['link']).'" title="'.esc_attr($tw_pricinglist_item['title']).'" target="_blank">'; }
                            $output .= esc_html($tw_pricinglist_item['title']);
                        if (!empty($tw_pricinglist_item['link'])) { $output .= '</a>'; }
                    $output .= '</h4>';
                    if (!empty($tw_pricinglist_item['content'])) {
                        $output .= '<div class="tw-description">';
                            $output .= $tw_pricinglist_item['content'];
                        $output .= '</div>';
                    }
                $output .= '</div>';
                $output .= '<div class="tw-menu-price uk-width-auto">';
                    $output .= '<h4 class="uk-text-uppercase">';
                        $output .= esc_html($tw_pricinglist_item['price']);
                    $output .= '</h4>';
                $output .= '</div>';

            $output .= '</div>';

        }


$output .= "</div>";
/* ================================================================================== */
echo ($output);