<?php
// phpcs:ignoreFile
/**
 * This file is generated by 10up-toolkit and copied into your dist folder, do not modifies this file directly.
 */
namespace TenUpToolkit;

add_action( 'init', __NAMESPACE__ . '\\register_react_fast_refresh', 1 );
add_action( 'wp_enqueue_scripts',  __NAMESPACE__  . '\\scripts', 1 );

/**
 * Register React Fast Refresh scripts
 *
 * @return void
 */
function register_react_fast_refresh() {
	if ( ! defined( 'TENUP_TOOLKIT_DIST_URL' ) || ! defined( 'TENUP_TOOLKIT_DIST_PATH' ) ) {
		trigger_error( '10up-toolkit error: you must defined both TENUP_TOOLKIT_DIST_URL and TENUP_TOOLKIT_DIST_PATH to get fast refresh to work' );
		return;
	}

	$react_fast_refresh_entry   = TENUP_TOOLKIT_DIST_URL . 'fast-refresh/react-refresh-entry/index.min.js';
	$react_fast_refresh_runtime = TENUP_TOOLKIT_DIST_URL . 'fast-refresh/react-refresh-runtime/index.min.js';
	$hmr_runtime                = TENUP_TOOLKIT_DIST_URL . 'fast-refresh/hmr-runtime.js';

	$react_fast_refresh_entry_path   = TENUP_TOOLKIT_DIST_PATH . 'fast-refresh/react-refresh-entry/index.min.js';
	$react_fast_refresh_runtime_path = TENUP_TOOLKIT_DIST_PATH . 'fast-refresh/react-refresh-runtime/index.min.js';
	$hmr_runtime_path                = TENUP_TOOLKIT_DIST_PATH . 'fast-refresh/hmr-runtime.js';


	if ( 
		! file_exists( $react_fast_refresh_entry_path ) 
		|| ! file_exists( $react_fast_refresh_runtime_path )
		|| ! file_exists( $hmr_runtime_path )
	) {
		return;
	}

	wp_register_script(
		'tenup-toolkit-react-fast-refresh-entry',
		$react_fast_refresh_entry,
		[],
		filemtime( $react_fast_refresh_entry_path ),
	);

	wp_register_script(
		'tenup-toolkit-react-refresh-runtime',
		$react_fast_refresh_runtime,
		[],
		filemtime( $react_fast_refresh_runtime_path ),
	);

	wp_register_script(
		'tenup-toolkit-hmr-runtime',
		$hmr_runtime,
		[],
		filemtime( $react_fast_refresh_runtime_path ),
	);

	global $wp_scripts;
	$script = $wp_scripts->query( 'react', 'registered' );

	if ( $script ) {
		// remove default react-refresh-entry by default
		if ( in_array( 'wp-react-refresh-entry', $script->deps ) ) {
			unset( $script->deps[ array_search( 'wp-react-refresh-entry', $script->deps ) ] );
		}

		if( !in_array( 'tenup-toolkit-react-refresh-runtime', $script->deps ) ){
			$script->deps[] = 'tenup-toolkit-react-refresh-runtime';
		}

		if( !in_array( 'tenup-toolkit-react-fast-refresh-entry', $script->deps ) ){
			$script->deps[] = 'tenup-toolkit-react-fast-refresh-entry';
		}

		if( !in_array( 'tenup-toolkit-hmr-runtime', $script->deps ) ){
			$script->deps[] = 'tenup-toolkit-hmr-runtime';
		}
	}
}

function scripts() {
	wp_enqueue_script( 'tenup-toolkit-hmr-runtime' );
	wp_enqueue_script( 'tenup-toolkit-react-fast-refresh-entry' );
	wp_enqueue_script( 'tenup-toolkit-react-refresh-runtime' );
}