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

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MPP_Global_Shared_Gallery
 */
class MPP_Global_Shared_Gallery {

	/**
	 * Class instance
	 *
	 * @var MPP_Global_Shared_Gallery
	 */
	private static $instance = null;

	/**
	 * Plugin directory path
	 *
	 * @var string
	 */
	private $path;

	/**
	 * MPP_Global_Shared_Gallery constructor.
	 */
	private function __construct() {
		$this->setup();
	}

	/**
	 * Return class instance
	 *
	 * @return MPP_Global_Shared_Gallery
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize variable and callbacks to necessary actions.
	 */
	private function setup() {
		$this->path = plugin_dir_path( __FILE__ );

		add_action( 'mpp_loaded', array( $this, 'load' ) );
		add_action( 'mpp_init', array( $this, 'load_text_domain' ) );
	}

	/**
	 * Load plugin files
	 */
	public function load() {

		$files = array( 'class-mpp-gsg-permission-helper.php' );

		// Load admin files when user in backend.
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			$files[] = 'class-mpp-gsg-metabox-helper.php';
		}

		foreach ( $files as $file ) {
			require_once $this->path . $file;
		}
	}

	/**
	 * Load text domain
	 */
	public function load_text_domain() {
		load_plugin_textdomain(
			'mpp-global-shared-gallery',
			false,
			basename( dirname( __FILE__ ) ) . 'languages/'
		);
	}
}
MPP_Global_Shared_Gallery::get_instance();