<?php

class HOCWP_Theme_Admin_Setting_Tab {
	public $name;
	public $label;
	public $icon;

	public function __construct( $name, $label, $icon = '' ) {
		if ( empty( $name ) ) {
			_doing_it_wrong( __CLASS__, __( 'The tab name is not valid.', 'hocwp-theme' ), '6.4.4' );
		}

		if ( empty( $icon ) ) {
			$icon = '<span class="dashicons dashicons-admin-page"></span>';
		}

		if ( empty( $label ) ) {
			$label = $name;
		}

		$label = ucwords( $label );
		$label = strip_tags( $label );

		$this->name  = $name;
		$this->label = $label;
		$this->icon  = $icon;
	}
}