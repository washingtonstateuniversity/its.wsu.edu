<?php

add_action( 'after_setup_theme', 'its_add_shortcodes' );
/**
 * Adds supported shortcodes after the theme has been loaded.
 *
 * @since 0.0.1
 */
function its_add_shortcodes() {
	add_shortcode( 'itsforms_iframe', 'its_display_itsforms_iframe_shortcode' );
}

/**
 * Embeds an iframe specified by the itsforms_iframe shortcode.
 *
 * Only iframes from itsforms.wsu.edu are allowed.
 *
 * @since 0.0.1
 *
 * @param array $atts List of attributes passed with the shortcode.
 *
 * @return string HTML to output.
 */
function its_display_itsforms_iframe_shortcode( $atts ) {
	$default_atts = array(
		'url' => '',
		'width' => '100%',
		'height' => '100%',
		'min_height' => '400px',
	);
	$atts = shortcode_atts( $default_atts, $atts );

	preg_match( '/https\:\/\/(?:statements.it|itsforms)\.wsu\.edu\/(.+)/i', $atts['url'], $matches );

	if ( 2 !== count( $matches ) ) {
		return '';
	}

	ob_start();
	?>
	<div class="itsforms-embed-wrapper">
		<iframe class="itsforms-embed"
		        src="https://itsforms.wsu.edu/<?php echo esc_attr( $matches[1] ); ?>"
		        scrolling="auto"
		        frameborder="no"
		        style="width: <?php echo esc_attr( $atts['width'] ); ?>; height: <?php echo esc_attr( $atts['height'] ); ?>; min-height: <?php echo esc_attr( $atts['min_height'] ); ?>;"
		        ></iframe>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
