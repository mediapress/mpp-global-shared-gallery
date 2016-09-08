<?php

/**
 * Plugin Name: MediaPress Global Shared Gallery
 * Plugin URI:  https://buddydev.com
 * Description: Allow user to share their gallery as global so that anyone can upload
 * Version:     1.0.0
 * Author:      BuddyDev Team
 * Author URI:  https://buddydev.com
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 * Text Domain: mpp-global-shared-gallery
 **/

//exit if access directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MPP_Global_Shared_Gallery {

	/**
	 * @var null take care of class instantiate only once
	 */
	private static $instance = null;

	/**
	 * @var string Plugin directory path
	 */
	private $path;

	/**
	 * private constructor
	 *
	 * MPP_Global_Shared_Gallery constructor.
	 */
	private function __construct() {
		$this->setup();
	}

	/**
	 * return a copy of object of the class if instance is null otherwise return the same object
	 *
	 * @return MPP_Global_Shared_Gallery|null
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * function initialize functionality by load file, assets and on activate create database table
	 */
	private function setup() {

		$this->path = plugin_dir_path( __FILE__ );

		add_action( 'plugins_loaded', array( $this, 'load' ) );
		add_action( 'init', array( $this, 'load_text_domain' ) );
	}

	public function load() {

		//load all the necessary files here
		$files = array(
			'class-mpp-gsg-permission-helper.php',
		);
		//load admin files when user in backend
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			$files[] = 'class-mpp-gsg-metabox-helper.php';
		}

		foreach ( $files as $file ) {
			require_once $this->path . $file;
		}

	}

	public function load_text_domain() {
		load_plugin_textdomain( 'mpp-global-shared-gallery', false, basename( dirname( __FILE__ ) ) . 'languages/' );
	}

}
MPP_Global_Shared_Gallery::get_instance();