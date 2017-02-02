<?php

$metas['author'] = sprintf( 
	'<span class="ui--meta-author">'. cloudfw_translate( 'by_author' ) .'</span>',
	'<a class="vcard author" href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'"><span class="fn">' . get_the_author() . '</span></a>'
);