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
		add_filter( 'mpp_user_can_edit_media', array( $this, 'can_edit_media' ), 10, 3 );
		add_filter( 'mpp_user_can_delete_media', array( $this, 'can_delete_media' ), 10, 3 );
		add_filter( 'mpp_user_can_add_remote_media', array( $this, 'can_add_remote_media' ), 10, 4 );
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
	 * Modify media edit permission
	 *
	 * @param bool        $allow    Allow media editing or not.
	 * @param MPP_Media   $media    MediaPress Media object.
	 * @param MPP_Gallery $gallery  MediaPress Gallery object.
	 *
	 * @return bool
	 */
	public function can_edit_media( $allow, $media, $gallery ) {

		if ( ! is_user_logged_in() || ! $this->is_shared_gallery( $gallery ) ) {
			return $allow;
		}

		if ( get_current_user_id() == $media->user_id ) {
			$allow = true;
		}

		return $allow;
	}

	/**
	 * Modify media delete permission
	 *
	 * @param bool        $allow    Allow media editing or not.
	 * @param MPP_Media   $media    MediaPress Media object.
	 * @param MPP_Gallery $gallery  MediaPress Gallery object.
	 *
	 * @return bool
	 */
	public function can_delete_media( $allow, $media, $gallery ) {

		if ( ! is_user_logged_in() || ! $this->is_shared_gallery( $gallery ) ) {
			return $allow;
		}

		if ( get_current_user_id() == $media->user_id ) {
			$allow = true;
		}

		return $allow;
	}

	/**
	 * Modify adding remote media permission
	 *
	 * @param bool        $can_do       Can add or not.
	 * @param string      $component    Component.
	 * @param int         $component_id Component id.
	 * @param MPP_Gallery $gallery      MediaPress Gallery object.
	 *
	 * @return mixed
	 */
	public function can_add_remote_media( $can_do, $component, $component_id, $gallery ) {

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
		$gallery = mpp_get_gallery( $gallery );

		if ( empty( $gallery->id ) ) {
			return false;
		}

		$is_shared = get_post_meta( $gallery->id, '_mpp_is_all_upload_allowed', true );

		return $is_shared ? true : false;
	}
}

new MPP_GSG_Permission_Helper();
