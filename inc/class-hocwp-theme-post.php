<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class HOCWP_Theme_Post {
	public $post;

	public function __construct( $post = null ) {
		if ( is_numeric( $post ) ) {
			$post = get_post( $post );
		} elseif ( ! ( $post instanceof WP_Post ) ) {
			$post = HT_Util()->return_post( $post );
		}

		if ( $post instanceof WP_Post ) {
			$this->post = $post;
		}
	}

	public function get_id() {
		return $this->post->ID;
	}

	public function get() {
		return $this->post;
	}

	public function set( $post ) {
		$this->post = $post;
	}

	public function get_meta( $key, $single = true ) {
		return get_post_meta( $this->post->ID, $key, $single );
	}

	public function get_terms( $taxonomy = 'post_tag', $args = array() ) {
		return wp_get_object_terms( $this->get_id(), $taxonomy, $args );
	}

	public function get_ancestor_terms( $taxonomy = 'category', $output = OBJECT ) {
		$result = null;

		if ( is_taxonomy_hierarchical( $taxonomy ) && has_term( '', $taxonomy, $this->post->ID ) ) {
			$result = get_ancestors( $this->post->ID, $taxonomy, 'taxonomy' );

			if ( ! HT()->array_has_value( $result ) ) {
				$result = wp_get_post_terms( $this->post->ID, $taxonomy, array(
					'orderby' => 'parent',
					'fields'  => 'ids'
				) );
			}
		}

		if ( HT()->array_has_value( $result ) && OBJECT == $output ) {
			foreach ( $result as $key => $term_id ) {
				$result[ $key ] = get_term( $term_id, $taxonomy );
			}
		}

		return $result;
	}

	public function thumbnail( $size = 'thumbnail', $attr = '' ) {
		hocwp_theme_post_thumbnail( $size, $attr );
	}

	public function the_date( $format = '' ) {
		echo get_the_date( $format );
	}
}