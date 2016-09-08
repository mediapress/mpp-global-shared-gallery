<?php

//exit if access directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MPP_GSG_MetaBox_Helper {

	public function __construct() {
		$this->setup();
	}

	public function setup() {
		add_action( 'add_meta_boxes', array( $this,'add_metabox' ) );
		add_action( 'save_post_' . mpp_get_gallery_post_type(), array( $this,'save_meta' ) );

	}

	public function add_metabox() {
		add_meta_box( 'share-mpp-members-all-option', __( 'Shared Gallery', 'mpp-global-shared-gallery' ), array( $this,'render' ), mpp_get_gallery_post_type(), 'normal' );
	}

	public function render( $post ) {

		$is_checked = get_post_meta( $post->ID, '_mpp_is_all_upload_allowed', true );
		?>

		<label>
			<input type="checkbox" name="_mpp_is_all_upload_allowed" value="1" <?php checked( 1, $is_checked );?> />
			<?php _e( 'Allow everyone to upload.', 'mpp-global-shared-gallery' ) ?></label>
		<?php

	}

	public function save_meta( $post_id ) {

		if ( defined( 'DOING_AJAX' ) || wp_is_post_autosave( $post_id ) ) {
			return ;
		}

		$is_checked = isset( $_POST['_mpp_is_all_upload_allowed'] ) ? 1: 0;

		update_post_meta( $post_id, '_mpp_is_all_upload_allowed',  $is_checked );
	}

}

new MPP_GSG_MetaBox_Helper();