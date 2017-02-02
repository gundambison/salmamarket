<?php

$services = apply_filters('cloudfw_blog_meta_sharrre_services', 'facebook,twitter,googleplus'); 
$metas[] = sprintf( '<span class="ui--meta-sharrre">%s</span>', do_shortcode("[sharrre type='mini-block' counter='0' services='$services']") );