<div class="my_meta_control cm-help-items-options">

	<?php
	wp_print_styles( 'editor-buttons' );

	ob_start();
	wp_editor( '', 'content', array(
		'dfw'		 => true,
		'tinymce'	 => array(
			'resize'			 => true,
			'add_unload_trigger' => false,
			'relative_urls'		 => false,
			'remove_script_host' => false,
			'convert_urls'		 => false
		),
	) );
	$content = ob_get_contents();
	ob_end_clean();

	$args = array(
		'post_type'			 => 'page',
		'show_option_none'	 => CMPopUpFlyIn::__( 'None' ),
		'option_none_value'	 => '',
	);

	global $wp_version;
	if ( version_compare( $wp_version, '4.3', '<' ) ) {
		add_filter( 'the_editor_content', 'wp_richedit_pre' );
	} else {
		add_filter( 'the_editor_content', 'format_for_editor' );
	}
	$switch_class = 'tmce-active';

	$defaultWidgetType	 = CMPOPFLY_Settings::getOption( CMPOPFLY_Settings::OPTION_DEFAULT_WIDGET_TYPE );
	$widgetType			 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_DEFAULT_WIDGET_TYPE );
	$displayMethod		 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_DISPLAY_METHOD );
	$widgetDisplayMethod = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_DISPLAY_METHOD );
	$widgetShape		 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_CUSTOM_WIDGET_SHAPE );
	$widgetShowEffect	 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_CUSTOM_WIDGET_SHOW_EFFECT );
	$widgetInterval		 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_CUSTOM_WIDGET_INTERVAL );
	$underlayType		 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_CUSTOM_WIDGET_UNDERLAY_TYPE );
	$selectedBanner		 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_CUSTOM_WIDGET_SELECTE_BANNER );
	$clicksCountMethod	 = CMPOPFLY_Settings::getOptionConfig( CMPOPFLY_Settings::OPTION_CUSTOM_WIDGET_CLICKS_COUNT_METHOD );
	if ( isset( $_GET[ 'post' ] ) ) {
		$activityDates = get_post_meta( $_GET[ 'post' ], CMPopUpFlyInShared::CMPOPFLY_CUSTOM_ACTIVITY_DATES_META_KEY );
	}
	if ( !empty( $activityDates ) ) {
		$activityDates = maybe_unserialize( $activityDates[ 0 ] );
	} else {
		$activityDates = false;
	}
	?>

    <div id="cmpopfly-options-group">

        <div class="cmpopfly-options-group">
            <label>Type</label>
            <p>
				<?php $mb->the_field( 'cm-campaign-widget-type' ); ?>
                <select name="<?php $mb->the_name(); ?>" id="cm-campaign-widget-type">
					<?php
					$fieldValue = $mb->get_the_value();
//            echo '<option value="0" ' . selected('0', $fieldValue, false) . '>' . CMPopUpFlyIn::__('Default') . ' (' . $widgetType['options'][$defaultWidgetType] . ') </option>';
					foreach ( $widgetType[ 'options' ] as $key => $value ) {
						echo '<option value="' . $key . '" ' . selected( $key, $fieldValue, false ) . '>' . $value . '</option>';
					}
					?>
                </select><br />
                <span class='field-info'>You can choose the different type for the current campaign.</span>
            </p>

			<?php $mb->the_field( 'cm-campaign-display-method' ); ?>
			<input type="hidden" name="<?php $mb->the_name(); ?>" value="selected"/>

			<?php $mb->the_field( 'cm-campaign-widget-selected-banner' ); ?>
			<input type="hidden" id="campaign-selected-banner-back" value="0"/>
			<input type="hidden" name="<?php $mb->the_name(); ?>" id="cm-campaign-widget-selected-banner" value="0"/>

            <label>Width</label>
            <p>
				<?php $mb->the_field( 'cm-campaign-widget-width' ); ?>
                <input type="text" name="<?php $mb->the_name(); ?>" placeholder="400px" value="<?php echo $metabox->get_the_value(); ?>"/>
                <span class='field-info'>campaign width. If blank defaults to 400px. Please input value in pixels.</span>
            </p>
            <label>Height</label>
            <p>
				<?php $mb->the_field( 'cm-campaign-widget-height' ); ?>
                <input type="text" name="<?php $mb->the_name(); ?>" placeholder="600px" value="<?php echo $metabox->get_the_value(); ?>"/>
                <span class='field-info'>campaign height. If blank defaults to 600px. Please input value in pixels.</span>
            </p>
            <label>Background color</label>
            <p>
				<?php $mb->the_field( 'cm-campaign-widget-background-color' ); ?>
                <input type="text" name="<?php $mb->the_name(); ?>" placeholder="#f0f1f2" value="<?php echo $metabox->get_the_value(); ?>"/>
                <span class='field-info'>Campaign background color. Please enter it in hexadecimal color format (eg. #abc123) or "transparent". If blank defaults to #f0f1f2 (grey).</span>
            </p>
            <label>Shape</label>
            <p>
				<?php $mb->the_field( 'cm-campaign-widget-shape' ); ?>
                <select name="<?php $mb->the_name(); ?>">
					<?php
					$fieldValue = $mb->get_the_value();
					if ( empty( $fieldValue ) ) {
						$fieldValue = $widgetShape[ 'default' ];
					}
					foreach ( $widgetShape[ 'options' ] as $key => $value ) {
						echo '<option value="' . $key . '" ' . selected( $key, $fieldValue, false ) . '>' . $value . '</option>';
					}
					?>
                </select>
                <br />
                <span class='field-info'>You can choose the different shape for the current campaign.</span>
            </p>
			<label>Center content vertically
				<p>
					<?php
					$mb->the_field( 'cm-campaign-widget-center-vertically' );
					$value		 = $mb->get_the_value();
					$checked	 = is_string( $value ) ? $value : '1';
					?>
					<input type="hidden" name="<?php $mb->the_name(); ?>" value="0"/>
					<input type="checkbox" name="<?php $mb->the_name(); ?>" value="1" <?php checked( '1', $checked ); ?> class="<?php $mb->the_name(); ?>"/>
					<span class='field-info'>If this checkbox is selected then this campaign's banner content will be centered verically</span>
				</p>
			</label>
			<label>Center content horizontally
				<p>
					<?php
					$mb->the_field( 'cm-campaign-widget-center-horizontally' );
					$value		 = $mb->get_the_value();
					$checked	 = is_string( $value ) ? $value : '1';
					?>
					<input type="hidden" name="<?php $mb->the_name(); ?>" value="0"/>
					<input type="checkbox" name="<?php $mb->the_name(); ?>" value="1" <?php checked( '1', $checked ); ?> class="<?php $mb->the_name(); ?>"/>
					<span class='field-info'>If this checkbox is selected then this campaign's banner content will be centered horizontally</span>
				</p>
			</label>
        </div>

        <div class="cmpopfly-options-group">

			<?php $mb->the_field( 'cm-campaign-widget-show-effect' ); ?>
            <input type="hidden" name="<?php $mb->the_name(); ?>" placeholder="0" value="<?php echo $mb->get_the_value(); ?>"/>

            <span id="underlayTypeContainer" style="display: none;">
                <label>Underlay type</label>
                <p>
					<?php $mb->the_field( 'cm-campaign-widget-underlay-type' ); ?>
                    <select name="<?php $mb->the_name(); ?>">
						<?php
						$fieldValue	 = $mb->get_the_value();
						if ( empty( $fieldValue ) ) {
							$fieldValue = $underlayType[ 'default' ];
						}
						foreach ( $underlayType[ 'options' ] as $key => $value ) {
							echo '<option value="' . $key . '" ' . selected( $key, $fieldValue, false ) . '>' . $value . '</option>';
						}
						?>
                    </select>
                    <br />
                    <span class='field-info'>You can choose the different underlay type for current campaign.</span>
                </p>
            </span>
        </div>

        <div class="cmpopfly-options-group">
            <label>Hide on devices with width less than</label>
            <p>
				<?php
				$mb->the_field( 'cm-campaign-min-device-width' );
				?>
                <input type="text" name="<?php $mb->the_name(); ?>" value="<?php echo $mb->get_the_value(); ?>" class="<?php $mb->the_name(); ?>"/>
                <span class='field-info'>Select the minimum width of the device on which the banners should appear (in pixels) e.g. 320px. Leave empty to show on all devices (default).</span>
            </p>

            <label>Show on every page</label>
            <p>
				<?php
				$mb->the_field( 'cm-campaign-show-allpages' );
				$value	 = $mb->get_the_value();
				$checked = is_string( $value ) ? $value : '0';
				?>
                <input type="hidden" name="<?php $mb->the_name(); ?>" value="0"/>
                <input type="checkbox" name="<?php $mb->the_name(); ?>" value="1" <?php checked( '1', $checked ); ?> class="<?php $mb->the_name(); ?>"/>
                <span class='field-info'>If this checkbox is selected then this campaign will be displayed on each post and page of your website</span>
            </p>

			<label>Show on selected posts/pages</label>
			<?php while ( $mb->have_fields_and_multi( 'cm-help-item-options' ) ): ?>

				<?php $mb->the_group_open(); ?>

				<?php $mb->the_field( 'toggle_state' ); ?>
				<input type="checkbox" name="<?php $mb->the_name(); ?>" value="1" <?php checked( '1', $mb->get_the_value() ); ?> class="toggle_state hidden" />

				<?php $mb->the_field( 'title' ); ?>

				<?php
				$mb->the_field( 'cm-help-item-url' );

				$args[ 'name' ]				 = $mb->get_the_name();
				$args[ 'selected' ]			 = $metabox->get_the_value();
				$args[ 'custom_post_types' ] = 1;
				cmpopfly_cminds_dropdown( $args );
				?>

				<?php $mb->the_group_close(); ?>
			<?php endwhile; ?>

        </div>
    </div>

    <p class="meta-save">
		<strong>To save the settings use the "Publish/Update" button in the right column.</strong>
	</p>

</div>