<?php

$cminds_plugin_config = array(
	'plugin-is-pro'					 => FALSE,
	'plugin-has-addons'				 => FALSE,
	'plugin-version'				 => '1.1.8',
	'plugin-abbrev'					 => 'cmpopfly',
	'plugin-short-slug'				 => 'cmpopfly',
	'plugin-parent-short-slug'		 => '',
	'plugin-affiliate'				 => '',
	'plugin-redirect-after-install'	 => admin_url( 'admin.php?page=cm-popupflyin-settings' ),
	'plugin-settings-url'			 => admin_url( 'admin.php?page=cm-popupflyin-settings' ),
	'plugin-show-guide'				 => TRUE,
	'plugin-guide-text'				 => '    <div style="display:block">
        <ol>
            <li>Go to <strong>"Add New Campaign"</strong></li>
            <li>Fill the <strong>"Title"</strong> of the campaign and <strong>"Content"</strong> of one or many Advertisement Items</li>
            <li>Click <strong>"Add Advertisement Item"</strong> to dynamically add more items</li>
            <li>Check <strong>"Show on every page"</strong></li>
            <li>Pick the <strong>"Selected banner"</strong> near the "Display method"</li>
            <li>Click <strong>"Publish" </strong> in the right column.</li>
            <li>Go to any page of your website</li>
            <li>Watch the banner with Advertisement Item</li>
            <li>Close the banner clicking "X" icon</li>
        </ol>
    </div>',
	'plugin-guide-video-height'			 => 240,
	'plugin-guide-videos'			 => array(
		array( 'title' => 'Installation tutorial', 'video_id' => '157541754' ),
	),
	'plugin-file'					 => CMPOPFLY_PLUGIN_FILE,
	'plugin-dir-path'				 => plugin_dir_path( CMPOPFLY_PLUGIN_FILE ),
	'plugin-dir-url'				 => plugin_dir_url( CMPOPFLY_PLUGIN_FILE ),
	'plugin-basename'				 => plugin_basename( CMPOPFLY_PLUGIN_FILE ),
	'plugin-icon'					 => '',
	'plugin-name'					 => CMPOPFLY_NAME,
	'plugin-license-name'			 => CMPOPFLY_NAME,
	'plugin-slug'					 => '',
	'plugin-menu-item'				 => CMPOPFLY_SLUG_NAME,
	'plugin-textdomain'				 => CMPOPFLY_SLUG_NAME,
	'plugin-userguide-key'			 => '350-cm-pop-up-banners-cmpb',
	'plugin-store-url'				 => 'https://www.cminds.com/wordpress-plugins-library/cm-pop-up-banners-plugin-for-wordpress/',
	'plugin-review-url'				 => 'https://wordpress.org/support/view/plugin-reviews/cm-pop-up-banners',
	'plugin-changelog-url'			 => 'https://www.cminds.com/wordpress-plugins-library/cm-pop-up-banners-plugin-for-wordpress/#changelog',
	'plugin-licensing-aliases'		 => array(),
	'plugin-compare-table'			 => '<div class="pricing-table" id="pricing-table">
                <ul>
                    <li class="heading">Current Edition</li>
                    <li class="price">$0.00</li>
                    <li class="noaction"><span>Free Download</span></li>
                    <li>Define campaign with banner</li>
                    <li>Choose between PopUp and Fly-in</li>
                    <li>Choose the width/height</li>
                    <li>Choose the basic styling options</li>
                     <li>Responsive support</li>
                     <li>X</li>
                     <li>X</li>
                     <li>X</li>
                     <li>X</li>
                     <li>X</li>
                    <li>X</li>
                    <li>X</li>
                     <li>X</li>
                     <li>X</li>
                     <li>X</li>
                     <li>X</li>
                  <li class="price">$0.00</li>
                    <li class="noaction"><span>Free Download</span></li>
                </ul>

                <ul>
                    <li class="heading">Pro</li>
                    <li class="price">$29.00</li>
                    <li class="action"><a href="https://www.cminds.com/wordpress-plugins-library/cm-pop-up-banners-plugin-for-wordpress/" style="background-color:darkblue;" target="_blank">More Info</a> &nbsp;&nbsp;<a href="https://www.cminds.com/?edd_action=add_to_cart&download_id=41966&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1" target="_blank">Buy Now</a></li>
                    <li>Define campaign with banner</li>
                    <li>Choose between PopUp and Fly-in</li>
                    <li>Choose the width/height</li>
                    <li>Advanced styling options</li>
                  <li>Advanced Responsive support</li>
                       <li>Ad Designer support</li>
                    <li>Statistics and reports</li>
                    <li>Restrict by Page/Post/Url</li>
                    <li>Restrict to group of pages</li>
                    <li>Restrict by time period</li>
                    <li>Random campaigns</li>
                    <li>Custom effects</li>
                    <li>Option to add delay</li>
                    <li>Option to setup the display interval</li>
                    <li>Activate on JS event</li>
                    <li>Show once per user session</li>
                   <li class="price">$29.00</li>
                   <li class="action"><a href="https://www.cminds.com/wordpress-plugins-library/cm-pop-up-banners-plugin-for-wordpress/" style="background-color:darkblue;" target="_blank">More Info</a> &nbsp;&nbsp;<a href="https://www.cminds.com/?edd_action=add_to_cart&download_id=41966&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1" target="_blank">Buy Now</a></li>
                 </ul>

            </div>',
);
