<?php
/* ================================================================================== */
/*      Job Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-job-container uk-text-center'),
    ),
    'animation_target' => '>*',
), vc_map_get_attributes($this->getShortcode(),$atts));

$query = array(
    'post_type' => 'lovelyjob',
    'posts_per_page' => $atts['count'],
);
$atts['cats']=trim(trim($atts['cats']),',');
$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'lovelyjob_cat',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

$lvly_query = new WP_Query( $query );

$output = '';
if ($lvly_query->have_posts()) {
    
    $output .= '<div class="tw-job-title uk-text-uppercase">';
        $output .= '<div class="uk-grid uk-grid-collapse" data-uk-grid>';
            if (!empty($atts['code'])) {
                $output .= '<div class="uk-width-1-6 uk-visible@l">'.esc_attr($atts['code_title']).'</div>';
            }
            $output .= '<div class="uk-width-expand">'.esc_attr($atts['job_title']).'</div>';
            if (!empty($atts['location'])) {
                $output .= '<div class="uk-width-1-2 uk-width-1-4@l">'.esc_attr($atts['location_title']).'</div>';
            }
            if (!empty($atts['department'])) {
                $output .= '<div class="uk-width-1-6 uk-visible@l">'.esc_attr($atts['department_title']).'</div>';
            }
            if (!empty($atts['close'])) {
                $output .= '<div class="uk-width-1-6 uk-visible@l">'.esc_attr($atts['close_title']).'</div>';
            }
        $output .= '</div>';
    $output .= '</div>';
    $output .= '<div data-uk-accordion>';
        while($lvly_query->have_posts()) { $lvly_query->the_post();
            $options = lvly_metas();
            $output .= '<div class="tw-job-content uk-margin-remove-top">';
                $output .= '<div class="uk-accordion-title tw-job-info uk-grid-collapse" data-uk-grid>';
                    if (!empty($atts['code'])) {
                        $code = isset($options['job_code']) ? $options['job_code'] : '';
                        $output .= '<div class="uk-width-1-6 uk-visible@l">'.esc_attr($code).'</div>';
                    }
                    $output .= '<div class="uk-width-expand">'.get_the_title().'</div>';
                    if (!empty($atts['location'])) {
                        $location = isset($options['job_location']) ? $options['job_location'] : '';
                        $output .= '<div class="uk-width-1-2 uk-width-1-4@l">'.esc_attr($location).'</div>';
                    }
                    if (!empty($atts['department'])) {
                        $department = isset($options['job_department']) ? $options['job_department'] : '';
                        $output .= '<div class="uk-width-1-6 uk-visible@l">'.esc_attr($department).'</div>';
                    }
                    if (!empty($atts['close'])) {
                        $close = isset($options['job_close']) ? $options['job_close'] : '';
                        $output .= '<div class="uk-width-1-6 uk-visible@l">'.esc_attr($close).'</div>';
                    }
                $output .= '</div>';
                $output .= '<div class="uk-accordion-content tw-job-desc uk-text-left"><div>';
                    $output .= apply_filters('the_content', get_the_content() );
                $output .= '</div></div>';
            $output .= '</div>';
        }
    $output .= '</div>';
    wp_reset_postdata();
}

$output = lvly_item($atts)[0].$output ."</div>";
/* ================================================================================== */
echo ($output);