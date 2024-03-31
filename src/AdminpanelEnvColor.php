<?php
/**
 * Colorize WordPress admin-panel for different environment.
 * It helps to highlight environments in color.
 * Developers, Content Managers and others will never confuse the environment where they work.
 *
 * Author: Andrei Pisarevskii
 * Author Email: renakdup@gmail.com
 * Author Site: https://wp-yoda.com/en/
 *
 * Version: 1.0.0
 * Licence: MIT License
 */

namespace Renakdup\AdminpanelEnvColor;

class AdminpanelEnvColor {
	public static function init() {
		add_action( 'admin_head', [ __CLASS__, 'add_admin_bar_style' ] );
		add_action( 'wp_head', [ __CLASS__, 'add_admin_bar_style' ] );
		add_action( 'admin_bar_menu', [ __CLASS__, 'add_admin_bar_env_item' ], 100 );
	}

	public static function add_admin_bar_style() {
		$adminpanel_colors = apply_filters(
			'renakdup/adminpanel_env_color/colors',
			[
				'local'       => null, // default wp color
				'development' => '#2271b1', // blue
				'staging'     => '#cc6f00', // orange
				'production'  => '#6d0d0f', // red
			]
		);

		if ( $color = $adminpanel_colors[ wp_get_environment_type() ] ) {
			echo '<style>
				#wpadminbar { background-color: ' . $color . '!important; }
				#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu { background-color: ' . $color . '!important; }
			</style>';
		}
		// phpcs:enable

		echo '<style>.rd_adminpanel_env_color a {
			box-shadow: inset 0 32px 5px rgba(0, 0, 0, 0.5) !important;
			padding-left: 30px !important;
			padding-right: 30px !important;
			}
		</style>';
	}

	/**
	 * @param $wp_admin_bar \WP_Admin_Bar
	 *
	 * @return void
	 */
	public static function add_admin_bar_env_item( $wp_admin_bar ) {
		$args = [
			'id'     => 'rd_adminpanel_env_color',
			'parent' => 'top-secondary',
			'title'  => 'ENV: ' . ucfirst( wp_get_environment_type() ),
			'href'   => '#',
			'meta'   => [
				'class' => 'rd_adminpanel_env_color',
				'title' => 'Your environment',
			],
		];
		$wp_admin_bar->add_node( $args );
	}
}