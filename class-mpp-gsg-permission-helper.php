<?php

//exit if access directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MPP_GSG_Permission_Helper {

	public function __construct() {
		$this->setup();
	}

	public function setup() {

		add_filter( 'mpp_user_can_upload', array( $this, 'can_upload' ), 9, 4 );
	}

	public function can_upload( $can_do, $component, $component_id, $gallery = null ) {

		//if gallery is not given, we don't know
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