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
	public function can_upload( $can_do, $component, $component_id, $gallery = null ) {

		// If gallery is not given.
		if ( ! $gallery ) {
			return $can_do;
		}

		$gallery = mpp_get_gallery( $gallery );
		$id      = $gallery->id;

		$is_allowed = get_post_meta( $id, '_mpp_is_all_upload_allowed', true );

		if ( $is_allowed ) {
			$can_do = true;
		}

		return $can_do;
	}
}

new MPP_GSG_Permission_Helper();
