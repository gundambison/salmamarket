<?php

add_filter('cloudfw_post_types_for_core_metaboxes',   'cloudfw_module_activate_shortcodes_on_events');
function cloudfw_module_activate_shortcodes_on_events( $post_types ) {
    $post_types[] = 'events';
    $post_types[] = 'ai1ec_event';
    $post_types[] = 'ajde_events';
    return $post_types;
}

/**
 *	Register Module Metaboxes
 *
 *	@package CloudFw
 *	@since 	 1.0
 */
add_filter( 'cloudfw_metaboxes', 'cloudfw_module_metaboxes_evetns', 10, 2 );
function cloudfw_module_metaboxes_evetns( $metaboxes, $post_id ) {
    $slugs = array(
    	'events',
    	'ai1ec_event',
    	'ajde_events',
    ); 

	$metaboxes[ cloudfw_id_for_sequence( $metaboxes, 1 ) ] = array(
        'type'  => 'metabox',
        'id'    => 'cloudfw_metabox_events_settings',
        'title' => __('Event Page Settings', 'cloudfw'),
        'pages' => $slugs,
        'context' => 'normal',
        'priority' => 'high',
        'data'  => array(

            array(
                'type'      =>  'module',
                'title'     =>  __('Page Template','cloudfw'),
                'data'      =>  array(
                    ## Element
                    array(
                        'type'      =>  'select',
                        'id'        =>  '_wp_page_template',
                        'value'     =>  get_post_meta($post_id, '_wp_page_template', true),
                        'source'    =>  array(
                            'type'      =>  'function',
                            'function'  =>  'cloudfw_admin_loop_page_templates'
                        ),
                        'class'     =>  'select',
                        'main_class'=>  'input input_300',
                    ), // #### element: 0
                        
                )
            ),
                
        )

    );

	return $metaboxes;
}