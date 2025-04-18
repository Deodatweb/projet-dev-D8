<?php
defined( 'ABSPATH' ) or die( 'Something went wrong.' );

/** --------------------------------------------------------------------------------------------- */
/** VARIOUS ===================================================================================== */
/** --------------------------------------------------------------------------------------------- */

add_filter( 'admin_page_access_denied', 'secupress_is_jarvis', 9 );
/**
 * Easter egg when you visit a "secupress" page with a typo in it, or just don't have access (not under white label).
 *
 * @since 1.0
 * @author Tony Stark
 */
function secupress_is_jarvis() {
	if ( isset( $_GET['page'] ) && 'secupress_settings' === $_GET['page'] ) {
		wp_redirect( secupress_admin_url( 'modules' ) );
		die();
	}
	if ( ! secupress_is_white_label() && isset( $_GET['page'] ) && strpos( $_GET['page'], 'secupress' ) !== false ) { // Do not use SECUPRESS_PLUGIN_SLUG, we don't want that in white label.
		wp_die( '[J.A.R.V.I.S.] You are not authorized to access this area.<br/>[Christine Everhart] Jesus ...<br/>[Pepper Potts] That’s Jarvis, he runs the house.', 403 );
	}
}


add_action( 'secupress.loaded', 'secupress_been_first' );
/**
 * Make SecuPress the first plugin loaded.
 *
 * @since 1.0
 */
function secupress_been_first() {
	if ( ! is_admin() ) {
		return;
	}

	$plugin_basename = plugin_basename( __FILE__ );

	if ( is_multisite() ) {
		$active_plugins = get_site_option( 'active_sitewide_plugins' );

		if ( isset( $active_plugins[ $plugin_basename ] ) && key( $active_plugins ) !== $plugin_basename ) {
			$this_plugin = array( $plugin_basename => $active_plugins[ $plugin_basename ] );
			unset( $active_plugins[ $plugin_basename ] );
			$active_plugins = array_merge( $this_plugin, $active_plugins );
			update_site_option( 'active_sitewide_plugins', $active_plugins );
		}
		return;
	}

	$active_plugins = get_option( 'active_plugins' );

	if ( isset( $active_plugins[ $plugin_basename ] ) && reset( $active_plugins ) !== $plugin_basename ) {
		unset( $active_plugins[ array_search( $plugin_basename, $active_plugins, true ) ] );
		array_unshift( $active_plugins, $plugin_basename );
		update_option( 'active_plugins', $active_plugins );
	}
}


/** --------------------------------------------------------------------------------------------- */
/** DETECT BAD PLUGINS AND THEMES =============================================================== */
/** --------------------------------------------------------------------------------------------- */

if ( secupress_is_expert_mode() ) {
	add_filter( 'secupress.settings.help', '__return_empty_string' );
	add_filter( 'secupress.settings.description', '__return_empty_string' );
}


add_filter( 'pre_http_request', 'secupress_filter_remote_url', 1, 3 );
/**
 * Filter the URL to prevent calls to secupress.me if needed
 *
 * @since 2.0
 * @author Julio Potier
 **/
function secupress_filter_remote_url( $val, $parsed_args, $url ) {
	if ( secupress_is_pro() && 32 !== strlen( secupress_get_consumer_key() ) && 0 === strpos( $url, untrailingslashit( SECUPRESS_WEB_MAIN ) ) ) {
		return new WP_Error();
	}
	return $val;
}


add_filter( 'manage_plugins_custom_column', 'secupress_add_malware_detection_column_content', 10, 3 );
/**
 * Display if the not installed plugin contains malwares
 *
 * @author Julio Potier
 * @since 2.2.6
 * 
 * @param  (string) $column_name
 * @param  (string) $plugin_file
 * @param  (array)  $plugin_data
 * @return (void)
 **/
function secupress_add_malware_detection_column_content( $column_name, $plugin_file, $plugin_data ) {
	if ( 'secupress_malware_detection' !== $column_name ) {
		return;
	}
	if ( ! secupress_is_pro() ) {
	?>
	<span class="secupress-get-pro-version">
		<?php printf( __( 'Available in <a href="%s" target="_blank">Pro Version</a>', 'secupress' ), esc_url( secupress_admin_url( 'get-pro' ) ) ); ?>
	</span>
	<?php
	return;
	}
	$rescan     = '<button class="button-link refreshscan" data-plugin="' . $plugin_file . '" data-muplugin="' . isset( $plugin_data['muplugin'] ) . '" type="button">' . __( 'Re-scan', 'secupress' ) . '</button>';	
	if ( isset( $plugin_data['muplugin'] ) ) {
		$tr_name = 'secupress-check-malware-result-mu-' . md5( $plugin_file );
	} else {
		$root_path  = WP_PLUGIN_DIR . '/' . dirname( $plugin_file );
		$tr_name  = 'secupress-check-malware-result-p-' . md5( $root_path );
	}
	if ( false !== $res = get_transient( $tr_name ) ) {
		echo $res . '<p>' . $rescan . '</p>';
	} else {
		echo '<span data-muplugin="' . isset( $plugin_data['muplugin'] ) . '" data-plugin="' . esc_attr( $plugin_file ) . '"><span class="spinner is-active" style="float:left"></span></span>';
	}
}

// add_filter( 'manage_plugins_columns', 'secupress_add_malware_detection_column' ); // Do not uncomment, let the modules does it.
/**
 * Only keep the "name" and "description" columns on our view.
 *
 * @author Julio Potier
 * @since 2.2.6
 * 
 * @param (array) $columns
 * @return (array) $columns
 **/
function secupress_add_malware_detection_column( $columns ) {
	$columns['secupress_malware_detection'] = __( 'Malware Detection', 'secupress' ) . 
	' <span class="dashicons secupress-dashicon dashicons-editor-expand"></span>';
	
	return $columns;
}
