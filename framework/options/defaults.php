<?php
/* Image Sizes It's our Theme Option Tab */
 $options_image_size=array(
    array(
        'id'    => 'information_size',
        'type'  => 'info',
        'style' => 'critical',
        'title'    => __('NOTE: Read the Description Carefully!', 'lvly'),
        'desc'  => sprintf( wp_kses( __('You can customize the size but after you have changed then you need to Install the <a href="%s">Regenerate Thumbnails plugin</a> and Regenerate it only once', 'lvly'), array(  'a' => array( 'href' => array() ) ) ), 'https://wordpress.org/plugins/regenerate-thumbnails/'),
        'icon'  => '',
    ),
    array(
        'id'       => 'lvly_thumb',
        'type'     => 'dimensions',
        'units'    => array('px'),
        'title'    => __('Blog Featured Image Size', 'lvly'),
        'subtitle' => __('Standard Layout Blog Thumbnail Size', 'lvly'),
        'desc'     => __('Default is the recommended size however you can change it to your own value but Read the Above Note', 'lvly'),
        'default'  => array(
            'width'   => '800',
            'height'  => '450'
        ),
    ),
    array(
        'id'       => 'lvly_grid_col2',
        'type'     => 'dimensions',
        'units'    => array('px'),
        'title'    => __('Grid 2 Columns', 'lvly'),
        'subtitle' => __('Blog and Portfolio Element Grid Type Image Size', 'lvly'),
        'desc'     => __('Default is the recommended size however you can change it to your own value but Read the Above Note', 'lvly'),
        'default'  => array(
            'width'   => '720',
            'height'  => '465'
        ),
    ),
    array(
        'id'       => 'lvly_grid_col3',
        'type'     => 'dimensions',
        'units'    => array('px'),
        'title'    => __('Grid 3 Columns', 'lvly'),
        'subtitle' => __('Blog and Portfolio Element Grid Type Image Size', 'lvly'),
        'desc'     => __('Default is the recommended size however you can change it to your own value but Read the Above Note', 'lvly'),
        'default'  => array(
            'width'   => '640',
            'height'  => '410'
        ),
    ),
    array(
        'id'       => 'lvly_grid_col4',
        'type'     => 'dimensions',
        'units'    => array('px'),
        'title'    => __('Grid 4 Columns', 'lvly'),
        'subtitle' => __('Blog and Portfolio Element Grid Type Image Size', 'lvly'),
        'desc'     => __('Default is the recommended size however you can change it to your own value but Read the Above Note', 'lvly'),
        'default'  => array(
            'width'   => '560',
            'height'  => '360'
        ),
    ),
    array(
        'id'       => 'lvly_port_promo',
        'type'     => 'dimensions',
        'units'    => array('px'),
        'title'    => __('Promo Portfolio', 'lvly'),
        'desc'     => __('Default is the recommended size however you can change it to your own value but Read the Above Note', 'lvly'),
        'default'  => array(
            'width'   => '460',
            'height'  => '280'
        ),
    ),
    array(
        'id'       => 'lvly_slider_app',
        'type'     => 'dimensions',
        'units'    => array('px'),
        'title'    => __('App Slide Size', 'lvly'),
        'desc'     => __('Default is the recommended size however you can change it to your own value but Read the Above Note', 'lvly'),
        'default'  => array(
            'width'   => '280',
            'height'  => '496'
        ),
    ),
);
lvly_set_atts(array('CONST_image_sizes'=>$options_image_size));

/* Redux Custom Fonts */
add_filter( 'redux/' . LVLY_OPTIONS_NAME . '/field/typography/custom_fonts', 'lvly_redux_custom_fonts_filter' );
if ( ! function_exists( 'lvly_redux_custom_fonts_filter' ) ) { 
    function lvly_redux_custom_fonts_filter( $fonts_list ) {
        /* Typekit Fonts */
        $api_key            = lvly_get_option( 'typekit_api_token' );
        $kit_id             = lvly_get_option( 'typekit_kit_ID' );
        $kit_cache_time     = intval( lvly_get_option( 'typekit_kit_cache_time' ) );
        
        if ( $api_key && $kit_id ) {
            if ( is_admin() && ( $kit_cache_time <=0 || false === ( $kit_fonts_list = get_transient( 'lvly_custom_fonts' ) ) ) ) {
                $url = 'https://typekit.com/api/v1/json/kits/' . trim( $kit_id ) . '?token=' . trim( $api_key );
                $curl_args = array(
                    'sslverify' => false,
                    'timeout' => 20000,
                );
                $response = wp_remote_request( $url, $curl_args);

                if ( ! is_wp_error( $response ) ) {
                    $response = wp_remote_retrieve_body( $response );
                    $response = json_decode( $response );
                    if ( isset( $response->kit ) ) {
                        $kit = $response->kit;
                        if ( isset( $kit->name ) ) {
                            if( isset( $kit->families ) && is_array( $kit->families ) ) {
                                $font_group_name = esc_html__( 'Typekit', 'lvly' );
                                $kit_fonts_list = array(
                                    $font_group_name => array()
                                );
                                foreach( $kit->families as $family ) {
                                    $kit_fonts_list[ $font_group_name ][ $family->css_stack ] = $family;
                                }

                                set_transient( 'lvly_custom_fonts', $kit_fonts_list, HOUR_IN_SECONDS * $kit_cache_time );
                            }
                        }
                    }
                }
            }
            
            if ( ! isset( $kit_fonts_list ) || ! is_array( $kit_fonts_list ) ) {
                $kit_fonts_list = array();
            }

            if ( count( $kit_fonts_list ) ) {
                update_option( 'lvly_custom_fonts', $kit_fonts_list );
            } else {
                $kit_fonts_list  = get_option( 'lvly_custom_fonts', array());
            }
            
            $fonts_list = array_merge( $kit_fonts_list, $fonts_list );
        } else {
            delete_transient( 'lvly_custom_fonts' );
            delete_option( 'lvly_custom_fonts' );
        }

        return $fonts_list;
    }
}

add_filter( 'redux/field/' . LVLY_OPTIONS_NAME . '/output_css', 'lvly_redux_output_css_filter' );
if ( ! function_exists( 'lvly_redux_output_css_filter' ) ) { 
    function lvly_redux_output_css_filter( $field ) {
        if ( $field['type'] == 'typography' && ! empty( $field['id'] ) ) {
            $typography_fields = lvly_get_att( 'typography_fields' );
            if ( ! is_array( $typography_fields ) ) {
                $typography_fields = array();
            }
            $typography_fields[ $field['id'] ] = lvly_get_option( $field['id'] );
            lvly_set_att( 'typography_fields', $typography_fields );
        }
        return $field;
    }
}