<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'enqueue_styles', 10 );
function enqueue_styles () {
	global $_token, $assets_url, $_version;

	wp_register_style( $_token . '-frontend', esc_url( $assets_url ) . 'css/frontend.css', array(), $_version );

	wp_enqueue_style( $_token . '-frontend' );
} // End enqueue_styles ()

add_action( 'wp_enqueue_scripts','enqueue_scripts', 10 );
function enqueue_scripts () {
	global $_token, $assets_url, $_version, $script_suffix;

	wp_register_script( $_token . '-frontgate', esc_url( $assets_url ) . 'js/frontgate.js', array( 'jquery' ), $_version );
	wp_enqueue_script( $_token . '-frontgate' );

	wp_register_script( $_token . '-cookie', esc_url( $assets_url ) . 'js/cookie.min.js', array( 'jquery' ), $_version );
	wp_enqueue_script( $_token . '-cookie' );

	// WordPress Localise Script for use in JS
	$nona_localized_data = array(
	    'ajaxurl'				=> admin_url( 'admin-ajax.php' )
	);
	wp_localize_script( $_token . '-frontgate', 'nonagate', $nona_localized_data );

} // End enqueue_scripts ()

add_action( 'admin_enqueue_scripts', 'admin_enqueue_styles', 10, 1 );
function admin_enqueue_styles () {
	global $_token, $assets_url, $_version;
	wp_register_style( $_token . '-admin', esc_url( $assets_url ) . 'css/admin.css', array(), $_version );
	wp_enqueue_style( $_token . '-admin' );
} // End admin_enqueue_styles ()

add_action( 'admin_enqueue_scripts', 'admin_enqueue_scripts', 10, 1 );
function admin_enqueue_scripts () {
	global $_token, $assets_url, $_version, $script_suffix;
	wp_register_script( $_token . '-admin', esc_url( $assets_url ) . 'js/admin' . $script_suffix . '.js', array( 'jquery' ), $_version );
	wp_enqueue_script( $_token . '-admin' );
} // End admin_enqueue_scripts ()

add_action( 'init', 'load_localisation', 0 );
function load_localisation () {
	global $dir;
	load_plugin_textdomain( 'nona-site-gate', false, $dir . 'lang/' );
} // End load_localisation ()

// Maybe display the overlay.
add_action( 'wp_footer', 'verify_overlay', 10 );
function verify_overlay() {
	global $assets_url;
	// Disable page caching by W3 Total Cache.
	define( 'DONOTCACHEPAGE', true ); ?>

		<div id="nona-overlay-wrap" class="nona-site-gate-hide">
			<div id="nona-overlay-inner">
				<div id="nona-overlay">
					<div class="nona-overlay-logo"><img src="<?php echo $assets_url; ?>/img/gm-logo.png"></div>
					<?php nona_verify_form(); ?>
				</div>
			</div>
		</div>

		<div id="sera-overlay">

			<h2>Robertson Winery supports responsible drinking. <br>
			<br> This website is meant to be enjoyed by people of legal drinking age.
			</h2>

			<p>Please provide your date of birth</p>

		</div>


	<?php
}

function nona_verify_form() {
	?>
	<form id="sera_verify_form" action="http://robertsonwinery.dev/" method="post">

		<div class="date-inputs">
			<div class="dd">
				<input type="text" name="sera_verify_d" id="sera_verify_d" maxlength="2" value="" placeholder="DD">
			</div>
			<div class="mm">
				<input type="text" name="sera_verify_m" id="sera_verify_m" maxlength="2" value="" placeholder="MM">
			</div>
			<div class="yy">
				<input type="text" name="sera_verify_y" id="sera_verify_y" maxlength="4" value="" placeholder="YYYY">
			</div>
		</div>
		<p class="submit">
			<input type="submit" class="button" name="sera_verify" id="sera_verify" value="Enter">
		</p>

	</form>
	<?php
}

