<?php
/**
 * Metabox helper class
 *
 * @package mpp-global-shared-gallery
 */

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MPP_GSG_MetaBox_Helper
 */
class MPP_GSG_MetaBox_Helper {

	/**
	 * MPP_GSG_MetaBox_Helper constructor.
	 */
	public function __construct() {
		$this->setup();
	}

	/**
	 * Callbacks to add and save metabox value.
	 */
	public function setup() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post_' . mpp_get_gallery_post_type(), array( $this, 'save_meta' ) );
	}

	/**
	 * Add MetaBox for making gallery as global shared.
	 */
	public function add_metabox() {
		add_meta_box(
			'share-mpp-members-all-option',
			__( 'Shared Gallery', 'mpp-global-shared-gallery' ),
			array( $this, 'render' ),
			mpp_get_gallery_post_type(),
			'normal'
		);
	}

	/**
	 * Render Metabox content.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function render( $post ) {
		$is_checked = get_post_meta( $post->ID, '_mpp_is_all_upload_allowed', true );
		?>
		<label>
			<input type="checkbox" name="_mpp_is_all_upload_allowed" value="1" <?php checked( 1, $is_checked ); ?> />
			<?php _e( 'Allow everyone to upload.', 'mpp-global-shared-gallery' ) ?></label>
		<?php
	}

	/**
	 * Save MetaBox value
	 *
	 * @param int $post_id Post id.
	 */
	public function save_meta( $post_id ) {

		if ( defined( 'DOING_AJAX' ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}

		$is_checked = isset( $_POST['_mpp_is_all_upload_allowed'] ) ? 1 : 0;

		update_post_meta( $post_id, '_mpp_is_all_upload_allowed', $is_checked );
	}
}

new MPP_GSG_MetaBox_Helper();
