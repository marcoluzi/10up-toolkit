<?php
// phpcs:ignoreFile
/**
 * This file is generated by 10up-toolkit and copied into your dist folder, do not modifies this file directly.
 */
namespace TenUpToolkit;

if ( ! defined( 'SCRIPT_DEBUG' ) || ! SCRIPT_DEBUG ) {
	// This is development environment with a detected fast-refresh-file
	wp_die(
		sprintf(
			"You're using <a href='%s' target='_blank'>10up-toolkit</a>'s
			Hot Module Reloading but don't have <code>SCRIPT_DEBUG</code> enabled.<br/>
			Learn more about <a href='%s' target='_blank'>enabling HMR</a>.",
			"https://github.com/10up/10up-toolkit/tree/develop/packages/toolkit",
			"https://github.com/10up/10up-toolkit/tree/develop/packages/toolkit#hmr-and-fast-refresh"
		)
	);
}

if ( ! function_exists( __NAMESPACE__ . '\\set_dist_url_path' ) ) {
	$registry = [];

	function set_dist_url_path( $key, $url, $path ) {
		global $registry;

		$registry[ $key ] = [
			'dist_url' => $url,
			'dist_path' => $path,
		];

		global $dist_url, $dist_path;
	}

	function get_dist_url_path( $key ) {
		global $registry;

		return $registry[ $key ];
	}
}

add_action( 'init',
	/**
	 * Register HMR & React Fast Refresh scripts
	 *
	 * @return void
	 */
	function() {
		$project = basename( dirname( __DIR__ ) );
		$vars = get_dist_url_path( $project );

		$dist_path = $vars['dist_path'];
		$dist_url = $vars['dist_url'];

		if ( ! $dist_url || ! $dist_path ) {
			wp_die( '10up-toolkit error: you must defined call TenUpToolkit\set_dist_url_path with the URL and path to dist folfer to get fast refresh to work' );
		}

		$react_fast_refresh_entry   = $dist_url . 'fast-refresh/react-refresh-entry/index.min.js';
		$react_fast_refresh_runtime = $dist_url . 'fast-refresh/react-refresh-runtime/index.min.js';
		$hmr_runtime                = $dist_url . 'fast-refresh/hmr-runtime.js';

		$react_fast_refresh_entry_path   = $dist_path . 'fast-refresh/react-refresh-entry/index.min.js';
		$react_fast_refresh_runtime_path = $dist_path . 'fast-refresh/react-refresh-runtime/index.min.js';
		$hmr_runtime_path                = $dist_path . 'fast-refresh/hmr-runtime.js';

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

		// the hmr runtime is unique to a 10up-toolkit build
		$prefix          = $project . '-';
		$hmr_runtime_key = $prefix . 'tenup-toolkit-hmr-runtime';

		wp_register_script(
			$hmr_runtime_key,
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

			if( !in_array( $hmr_runtime_key, $script->deps ) ){
				$script->deps[] = $hmr_runtime_key;
			}
		}
	},
	1
);


add_action(
	'wp_enqueue_scripts',
	function() {
		$prefix          = basename( dirname( __DIR__ ) ) . '-';
		$hmr_runtime_key = $prefix . 'tenup-toolkit-hmr-runtime';

		wp_enqueue_script( 'tenup-toolkit-react-refresh-runtime' );
		wp_enqueue_script( $hmr_runtime_key );
	},
	1
);

add_action(
	'admin_enqueue_scripts',
	function() {
		$prefix          = basename( dirname( __DIR__ ) ) . '-';
		$hmr_runtime_key = $prefix . 'tenup-toolkit-hmr-runtime';

		wp_enqueue_script( 'tenup-toolkit-react-refresh-runtime' );
		wp_enqueue_script( $hmr_runtime_key );
	},
	1
);


