<?php

if ( $tag_list = get_the_tag_list( NULL, ', ' ) )
	$metas[] = sprintf( 
		'<span class="ui--meta-tags">'. cloudfw_translate( 'meta_tags' ) .'</span>', 
		$tag_list 
	);