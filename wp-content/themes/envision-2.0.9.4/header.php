<?php
/**
 * The header for the theme
 * 
 * @author Orkun GURSEL (support@cloudfw.net)
 * @package WordPress
 * @subpackage CloudFw
 */

/** Get Logo Images */
$logo_image               = cloudfw_get_option('logo', 'image');
$logo_image_retina        = cloudfw_get_option('logo', 'image@2x');
$logo_image_tablet        = cloudfw_get_option('logo-tablet', 'image');
$logo_image_tablet_retina = cloudfw_get_option('logo-tablet', 'image@2x');
$logo_image_phone         = cloudfw_get_option('logo-phone', 'image');
$logo_image_phone_retina  = cloudfw_get_option('logo-phone', 'image@2x');

$sticky_mode_enabled       = cloudfw_check_onoff( 'header', 'sticky' );
$logo_image_sticky         = $sticky_mode_enabled ? cloudfw_get_option('logo-sticky', 'image') : '';
$logo_image_sticky_retina  = $sticky_mode_enabled ? cloudfw_get_option('logo-sticky', 'image@2x') : '';

/**
 * Check the visual set for custom logo image
 */
    /** Desktop */
    if ( $custom_logo = cloudfw_get_visual_option("custom-logo") ) {
        $logo_image = $custom_logo;
    }

    if ( $custom_logo_retina = cloudfw_get_visual_option("custom-logo-retina") ) {
        $logo_image_retina = $custom_logo_retina;
    }

    /** Tablet */
    if ( $custom_logo_tablet = cloudfw_get_visual_option("custom-logo-tablet") ) {
        $logo_image_tablet = $custom_logo_tablet;
    }

    if ( $custom_logo_tablet_retina = cloudfw_get_visual_option("custom-logo-tablet-retina") ) {
        $logo_image_tablet_retina = $custom_logo_tablet_retina;
    }

    /** Phone */
    if ( $custom_logo_phone = cloudfw_get_visual_option("custom-logo-phone") ) {
        $logo_image_phone = $custom_logo_phone;
    }

    if ( $custom_logo_phone_retina = cloudfw_get_visual_option("custom-logo-phone-retina") ) {
        $logo_image_phone_retina = $custom_logo_phone_retina;
    }

/**
 * Logo image callbacks for tablets and phones
 */
    
    /** Tablet */
    if ( ! $logo_image_tablet ) {
        $logo_image_tablet = $logo_image;
    }

    /** Phone */
    if ( ! $logo_image_phone ) {
        $logo_image_phone = $logo_image;
    }

/**
 * Logo image retina callbacks
 */
    
    /** Desktop */
    if ( ! $logo_image_retina ) {
        $logo_image_retina = $logo_image;
    }

    /** Tablet */
    if ( ! $logo_image_tablet_retina ) {
        $logo_image_tablet_retina = $logo_image_retina;
    }

    /** Phone */
    if ( ! $logo_image_phone_retina ) {
        $logo_image_phone_retina = $logo_image_tablet_retina;
    }

    /** Sticky */
    if ( ! $logo_image_sticky_retina ) {
        $logo_image_sticky_retina = $logo_image_sticky;
    }

/**
 * Logo offsets
 */
$logo_margin_top = cloudfw_get_option( 'logo', 'margin-top', NULL, 0 );  
$logo_margin_top_tablet = cloudfw_get_option( 'logo-tablet', 'margin-top', $logo_margin_top, -1 );  
$logo_margin_top_phone = cloudfw_get_option( 'logo-phone', 'margin-top', $logo_margin_top, -1 );  

$logo_margin_bottom = cloudfw_get_option( 'logo', 'margin-bottom', NULL, 0 );  
$logo_margin_bottom_tablet = cloudfw_get_option( 'logo-tablet', 'margin-bottom', $logo_margin_bottom, -1 );  
$logo_margin_bottom_phone = cloudfw_get_option( 'logo-phone', 'margin-bottom', $logo_margin_bottom, -1 ); 

$hide_on_stuck_class = ''; 
if ( ! empty( $logo_image_sticky ) ) {
    $hide_on_stuck_class = 'hide-on-stuck'; 
}

$logo_link = cloudfw_get_option( 'logo', 'link', get_bloginfo("url") );

$html_classes = array();  
if ( cloudfw_is_responsive() ) {
    $html_classes[] = 'responsive';
} else {
    $html_classes[] = 'no-responsive';
}

$html_classes = cloudfw_make_class( $html_classes, false );
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js html-loading wf-active ie old-browser lt-ie10 lt-ie9 lt-ie8 lt-ie7 <?php echo $html_classes; ?>" <?php cloudfw_html_tag_schema(); ?><?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js html-loading wf-active ie old-browser ie7 lt-ie10 lt-ie9 lt-ie8 <?php echo $html_classes; ?>" <?php cloudfw_html_tag_schema(); ?><?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js html-loading wf-active ie old-browser ie8 lt-ie10 lt-ie9 <?php echo $html_classes; ?>" <?php cloudfw_html_tag_schema(); ?><?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="no-js html-loading wf-active ie modern-browser ie9 lt-ie10 <?php echo $html_classes; ?>" <?php cloudfw_html_tag_schema(); ?><?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js html-loading wf-active modern-browser <?php echo $html_classes; ?>" <?php cloudfw_html_tag_schema(); ?><?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta name="google-site-verification" content="CUOJxhXEPT4iaISBckzQxneAD-UgI1I_LDOjVqel0Ks" />
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php cloudfw_device_viewport(); ?>

<title itemprop="name"><?php cloudfw('title'); ?></title>

<!-- W3TC-include-js-head -->
<?php do_action( 'cloudfw_head' ); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action('cloudfw_after_body_starting'); ?>

<div id="side-panel-pusher">

<div id="main-container">

    <div id="page-wrap">

        <?php $disable_header = cloudfw( 'get', 'disable_header' ); ?>
        <?php if ( ! isset( $disable_header ) || $disable_header !== true ): ?>

        <header id="page-header" class="clearfix">

            <?php $topbar_sticky = cloudfw_check_onoff( 'topbar', 'sticky' ); ?>
            <?php if ( ! $topbar_sticky ) include( TMP_MODULES . '/module.topbar/topbar.php' ); ?>

            <?php 
                /** Header Layout */
                $header_style = cloudfw_get_option('header', 'style');
                $header_logo_position = cloudfw_get_option('header', 'logo_position');
                $header_navigation_position = cloudfw_get_option('header', 'navigation_position');
                $header_blocking = '';
                $is_normal_header_block = false;
                $is_sticky_header_block = false;

                if ( $header_style == '2' || $header_logo_position == 'center' || $header_navigation_position == 'center' ) {
                    $is_normal_header_block = true;
                    $header_blocking .= ' header-layout-blocking';
                } elseif ( ( $header_logo_position == 'left' && $header_navigation_position == 'left' ) || ( $header_logo_position == 'right' && $header_navigation_position == 'right' ) ) {
                    $is_normal_header_block = true;
                    $header_blocking .= ' header-layout-blocking';
                }

                /** Sticky Header Layout */
                $sticky_header_logo = cloudfw_check_onoff('sticky_header', 'logo');
                $sticky_header_logo_position = cloudfw_get_option('sticky_header', 'logo_position', $header_logo_position == 'left' || $header_logo_position == 'right' ? $header_logo_position : 'left' );
                $sticky_header_navigation_position = cloudfw_get_option('sticky_header', 'navigation_position', $header_navigation_position == 'left' || $header_navigation_position == 'right' ? $header_navigation_position : 'right' );

                if ( $sticky_header_logo_position == 'center' || $sticky_header_navigation_position == 'center' ) {
                    $is_sticky_header_block = true;
                    $header_blocking .= ' sticky-header-layout-blocking';
                } elseif ( ( $sticky_header_logo_position == 'left' && $sticky_header_navigation_position == 'left' ) || ( $sticky_header_logo_position == 'right' && $sticky_header_navigation_position == 'right' ) ) {
                    $is_sticky_header_block = true;
                    $header_blocking .= ' sticky-header-layout-blocking';
                }

                if ( ! $sticky_header_logo ) {
                    if( ! $is_sticky_header_block ) {
                        $header_blocking .= ' sticky-header-layout-blocking';
                    }
                    $header_blocking .= ' sticky-hidden-logo';
                }

            ?>

            <div id="header-container" class="header-style-<?php echo $header_style; ?><?php echo $header_blocking; ?> logo-position-<?php echo $header_logo_position; ?> navigation-position-<?php echo $header_navigation_position; ?> sticky-logo-position-<?php echo $sticky_header_logo_position; ?> sticky-navigation-position-<?php echo $sticky_header_navigation_position; ?> no-stuck clearfix" <?php 
                cloudfw_responsive_options(array( 
                        'css' => array(
                            'padding-bottom' => array( 
                                'phone'         => (int) $logo_margin_bottom_phone,
                                'tablet'        => (int) $logo_margin_bottom_tablet,
                                'widescreen'    =>  $is_normal_header_block && $header_style == '1' ? (int) $logo_margin_bottom_tablet : 0,
                                //'widescreen'    => 0,
                            ),
                        )
                )); ?>>
                <div id="header-container-background"></div>
                <?php if ( $topbar_sticky ) include( TMP_MODULES . '/module.topbar/topbar.php' ); ?>
                <div class="container relative">        
                    <div id="logo">
                        <a href="<?php echo __url( $logo_link ); ?>">
                            
                            <?php 

                                /** Destop Logo */
                                echo "<img ". 
                                    cloudfw_make_id( 'logo-desktop' ) .
                                    cloudfw_make_class( cloudfw_visible('desktop', $hide_on_stuck_class) , true) .
                                    cloudfw_make_attribute( array( 
                                        'src'           => $logo_image,
                                        'data-at2x'     => $logo_image_retina,
                                        'alt'           => get_bloginfo( 'name', 'display' ),
                                    ), FALSE ) .
                                    cloudfw_make_style_attribute( array(
                                        'margin-top'    => $logo_margin_top,
                                        'margin-bottom' => $logo_margin_bottom
                                    ), FALSE, TRUE )

                                ."/>";

                                if ( cloudfw_is_responsive() ) {

                                    /** Tablet Logo */
                                    echo "\n<img ". 
                                        cloudfw_make_id( 'logo-tablet' ) .
                                        cloudfw_make_class( cloudfw_visible('tablet', $hide_on_stuck_class) , true) .
                                        cloudfw_make_attribute( array( 
                                            'src'           => $logo_image_tablet,
                                            'data-at2x'     => $logo_image_tablet_retina,
                                            'alt'           => get_bloginfo( 'name', 'display' ),
                                        ), FALSE ) .
                                        cloudfw_make_style_attribute( array(
                                            'margin-top'    => $logo_margin_top_tablet,
                                            'margin-bottom' => $logo_margin_bottom_tablet
                                        ), FALSE, TRUE )

                                    ."/>";

                                    /** Phone Logo */
                                    echo "\n<img ". 
                                        cloudfw_make_id( 'logo-phone' ) .
                                        cloudfw_make_class( cloudfw_visible('phone', $hide_on_stuck_class) , true) .
                                        cloudfw_make_attribute( array( 
                                            'src'           => $logo_image_phone,
                                            'data-at2x'     => $logo_image_phone_retina,
                                            'alt'           => get_bloginfo( 'name', 'display' ),
                                        ), FALSE ) .
                                        cloudfw_make_style_attribute( array(
                                            'margin-top'    => $logo_margin_top_phone,
                                            'margin-bottom' => $logo_margin_bottom_phone
                                        ), FALSE, TRUE )

                                    ."/>";

                                }

                                if ( !empty( $logo_image_sticky ) ) {

                                    /** Sticky Logo */
                                    echo "\n<img ". 
                                        cloudfw_make_id( 'logo-sticky' ) .
                                        cloudfw_make_class( 'show-on-stuck' , true) .
                                        cloudfw_make_attribute( array( 
                                            'src'           => $logo_image_sticky,
                                            'data-at2x'     => $logo_image_sticky_retina,
                                            'alt'           => get_bloginfo( 'name', 'display' ),
                                        ), FALSE ) .
                                        cloudfw_make_style_attribute( array(
                                            'margin-top'    => $logo_margin_top,
                                            'margin-bottom' => $logo_margin_bottom
                                        ), FALSE, TRUE )

                                    ."/>";
                                }

                             ?>
                        </a>
                    </div><!-- /#logo -->

                    <?php if ( cloudfw( 'get', 'disable_menu' ) !== true ): ?>

                        <?php if ( $header_style == "2" ): ?>
                            <nav id="navigation" class="with-navigation-holder fullwidth-container">
                                <div id="navigation-holder" class="relative clearfix"><?php do_action( 'cloudfw_primary_navigation' ); ?></div>
                            </nav><!-- /nav#navigation -->
                        <?php else: ?>
                            <nav id="navigation" class="without-navigation-holder">
                               <?php do_action( 'cloudfw_primary_navigation' ); ?>
                            </nav><!-- /nav#navigation -->
                        <?php endif; ?>
                        
                    <?php endif; ?>

                </div>
            </div><!-- /#header-container -->

        </header>
        <?php endif; ?>
        <?php cloudfw( 'header' ); ?>