<?php

$metas[] = sprintf( 
	'<span class="datetime"><time class="entry-date date updated" datetime="%3$s" itemprop="datePublished" pubdate>%1$s</time></span>', 
	get_the_date(), esc_attr( get_the_time() ), get_the_date('c')
);