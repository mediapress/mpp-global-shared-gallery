<?php
/**
 * Permission Helper class
 *
 * @package mpp-global-shared-gallery
 */

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class MPP_GSG_Permission_Helper
 */
class MPP_GSG_Permission_Helper {

	/**
	 * MPP_GSG_Permission_Helper constructor.
	 */
	public function __construct() {
		$this->setup();
	}

	/**
	 * Modify MediaPress permissions.
	 */
	public function setup() {
		add_filter( 'mpp_user_can_upload', array( $this, 'can_upload' ), 9, 4 );
	}

	/**
	 * Modify who can upload media to gallery.
	 *
	 * @param bool        $can_do        Can upload media or not.
	 * @param string      $component     Gallery component.
	 * @param int         $component_id  Component id.
	 * @param MPP_Gallery $gallery       MediaPress Gallery object.
	 *
	 * @return bool
	 */
	public function can_upload( $can_do, $component, $component_id, $gallery ) {

		if ( ! is_user_logged_in() || ! $this->is_shared_gallery( $gallery ) ) {
			return $can_do;
		}

		return true;
	}

	/**
	 * CHeck if gallery marked as shared or not.
	 *
	 * @param MPP_Gallery $gallery Gallery object.
	 *
	 * @return bool
	 */
	private function is_shared_gallery( $gallery ) {
		$is_shared = get_post_meta( $gallery->id, '_mpp_is_all_upload_allowed', true );

		return $is_shared ? true : false;
	}
}

new MPP_GSG_Permission_Helper();
