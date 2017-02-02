<?php

if( ! defined('WPSEO_VERSION') && ! class_exists('wpSEO') ) return;

if( ! function_exists( 'cloudfw_wpseo_pre_analysis_post_content_fix' ) ) {
    function cloudfw_wpseo_pre_analysis_post_content_fix( $content, $post ) {
        
        if( is_admin() && !empty( $post->ID ) ) {
            $content = cloudfw_composer_the_content( $content, $post->ID );
        }

        return $content;
    }

    add_filter('wpseo_pre_analysis_post_content','cloudfw_wpseo_pre_analysis_post_content_fix', 10, 2);
}