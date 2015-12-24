<?php
/*
Plugin Name: Pojo Maintenance Mode
Plugin URI: http://pojo.me/
Description: ...
Author: Pojo Team
Author URI: http://pojo.me/
Version: 1.0.0
Text Domain: pojo-maintenance-mode
Domain Path: /languages/
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'POJO_MAINTENANCE_MODE__FILE__', __FILE__ );
define( 'POJO_MAINTENANCE_MODE_BASE', plugin_basename( POJO_MAINTENANCE_MODE__FILE__ ) );
define( 'POJO_MAINTENANCE_MODE_URL', plugins_url( '/', POJO_MAINTENANCE_MODE__FILE__ ) );
define( 'POJO_MAINTENANCE_MODE_ASSETS_PATH', plugin_dir_path( POJO_MAINTENANCE_MODE__FILE__ ) . 'assets/' );
define( 'POJO_MAINTENANCE_MODE_ASSETS_URL', POJO_MAINTENANCE_MODE_URL . 'assets/' );

final class Pojo_Maintenance_Mode {

	/**
	 * @var Pojo_Maintenance_Mode The one true Pojo_Maintenance_Mode
	 * @since 1.0.0
	 */
	private static $_instance = null;

	public function load_textdomain() {
		load_plugin_textdomain( 'pojo-maintenance-mode', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'pojo-maintenance-mode' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'pojo-maintenance-mode' ), '1.0.0' );
	}

	/**
	 * @return Pojo_Maintenance_Mode
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function include_settings() {
		
	}

	public function admin_notices() {
		echo '<div class="error"><p>' . sprintf( __( '<a href="%s" target="_blank">Pojo Theme</a> is not active. Please activate any theme by Pojo.me before you are using "Pojo Maintenance Mode" plugin.', 'pojo-maintenance-mode' ), 'http://pojo.me/' ) . '</p></div>';
	}

	public function print_update_error() {
		echo '<div class="error"><p>' . sprintf( __( 'The Pojo Maintenance Mode is not supported by this version of %s. Please <a href="%s">upgrade the theme to its latest version</a>.', 'pojo-maintenance-mode' ), Pojo_Core::instance()->licenses->updater->theme_name, admin_url( 'update-core.php' ) ) . '</p></div>';
	}

	public function bootstrap() {
		// This plugin for Pojo Themes..
		if ( ! class_exists( 'Pojo_Core' ) ) {
			add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
			return;
		}

		if ( version_compare( '1.5.4', Pojo_Core::instance()->get_version(), '>' ) ) {
			add_action( 'admin_notices', array( &$this, 'print_update_error' ) );
			return;
		}

		add_action( 'pojo_framework_base_settings_included', array( &$this, 'include_settings' ) );
	}

	private function __construct() {
		add_action( 'init', array( &$this, 'bootstrap' ) );
		add_action( 'plugins_loaded', array( &$this, 'load_textdomain' ) );
	}

}

Pojo_Maintenance_Mode::instance();