<?php 

if ( !class_exists('CloudFw_Walker_Top_Menu') ) {
    /**
     *  CloudFw Custom Navigation Menu Walker
     *
     *  @since 1.0
    **/
    class CloudFw_Walker_Top_Menu extends Walker_Nav_Menu {

        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {

            $hide_item = false;
            $condition_result_login = cloudfw_get_post_meta($element->ID, 'menu_logical_condition_result', 'show');
            $condition_login = cloudfw_get_post_meta($element->ID, 'menu_logical_condition');

            if( ! empty( $condition_result_login ) ) {
                switch ($condition_login) {
                    case 'is_logged_in':

                        if ( $condition_result_login == 'hide' && is_user_logged_in() ) {
                            $hide_item = true;
                        } elseif ( $condition_result_login == 'show' && !is_user_logged_in() ) {
                            $hide_item = true;
                        }

                        break;

                    case 'is_not_logged_in':

                        if ( $condition_result_login == 'hide' && !is_user_logged_in() ) {
                            $hide_item = true;
                        } elseif ( $condition_result_login == 'show' && is_user_logged_in() ) {
                            $hide_item = true;
                        }

                        break;
                }
            }

            $condition_result_roles = cloudfw_get_post_meta($element->ID, 'menu_logical_condition_roles_result', 'show');
            $condition_roles = cloudfw_get_post_meta($element->ID, 'menu_logical_condition_roles');

            if( $hide_item !== true && ! empty( $condition_result_roles ) && ! empty( $condition_roles ) ) {
                if ( $condition_result_roles == 'hide' && current_user_can( $condition_roles ) ) {
                    $hide_item = true;
                } elseif ( $condition_result_roles == 'show' && !current_user_can( $condition_roles ) ) {
                    $hide_item = true;
                }
            }

            if ( isset($hide_item) && $hide_item === true ) {
                $this->unset_children( $element, $children_elements );
                return false;
            }

            $element->has_children = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }


        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
           $class_names = $value = '';
            
           $classes = empty( $item->classes ) ? array() : (array) $item->classes;
           $classes[] = 'depth-'.$depth;

           if ( $depth === 0 )
                $classes[] = 'ui--gradient ui--gradient-grey on--hover';       
                                          
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = ' class="'. esc_attr( $class_names ) . '"';


            $output .= $indent . '<li ';
            $output .= $item->ID ? 'id="menu-item-' . $item->ID .'"' : ''; 
            $output .= $value . $class_names .'>';
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

            $item_output = $args->before;
            
            $item_output .= $args->link_before;            
            $item_output .= '<a'. $attributes .'>';
            $item_output .= apply_filters( 'the_title', $item->title, $item->ID );

            if ( $depth === 0 )
                if ( isset($item->has_children) && $item->has_children && $args->caret )
                    $item_output .= $args->caret;

            $item_output .= '</a>';
            $item_output .= $args->link_after;
            
            $item_output .= $args->after;
            
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

    }

}

    
    $menu_id = cloudfw_get_option('topbar_widget_custom_menu', 'menu_id'); 

    if ( ! empty( $menu_id ) ) {
        
        wp_nav_menu( array( 
                'fallback_cb'     => '__return_false', 
                'menu'            => $menu_id,
                'container'       => false,
                'menu_class'      => cloudfw_visible( $device, 'widget--language-selector ui--widget ui--custom-menu opt--on-hover opt--menu-direction-right unstyled-all'), 
                'menu_id'         => 'navigation-menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'caret'           => '<i class="fontawesome-angle-down px14"></i>',
                'depth'           => 3,
                'walker'          => new CloudFw_Walker_Top_Menu(),
            ) 
        );

    }
 ?>