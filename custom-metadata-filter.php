<?php
/**
 * Plugin Name: Custom Metadata Filter
 * Plugin URI:  https://tommcfarlin.com/
 * Description: Adds a custom filter for viewing posts with headline metadata.
 * Author:      Tom McFarlin <tom@tommcfarlin.com>
 * Version:     1.0.0
 *
 * @package HeadlinesDemo
 * @since   2021-05-28
 */

namespace HeadlinesDemo;

use WP_Query;

/**
 * Determines how many of the incoming results are of the standard
 * 'post' type.
 *
 * @param array $results The results of from the database of all standard posts.
 *
 * @return array $post_ids The IDs of the posts that are of the standard post type.
 */
function filter_posts_from_pages( array $results ) : array {
	$post_ids = array();

	foreach ( $results as $result) {
		if ( 'post' === get_post_type( $result['post_type'] ) ) {
			$post_ids[] = $result['post_id'];
		}
	}

	return $post_ids;
}

/**
 * Retrieves the post IDs for all posts with the required meta key and
 * meta values.
 *
 * @return array The results of posts with the article_attribute
 */
function get_headline_results() : array {
	global $wpdb;
	return $wpdb->get_results( // phpcs:ignore
		$wpdb->prepare(
			"
			SELECT post_id FROM $wpdb->postmeta
			WHERE meta_key = %s AND meta_value = %s
			",
			'article_attribute',
			'headline'
		),
		ARRAY_A
	);
}

add_action(
	'pre_get_posts',
	function ( WP_Query $query ) {
		$meta_value = 'headline';

		if ( filter_input( INPUT_GET, 'meta_value' ) === $meta_value ) {
			$query->set( 'meta_key', 'article_attribute' );
			$query->set( 'meta_value', $meta_value );
		}
	}
);

add_action(
	'views_edit-post',
	function ( array $views ) {
		// Determine if we're looking at the Headlines page.
		$attributes = 'class=""';
		if ( filter_input( INPUT_GET, 'meta_value' ) === 'headline' ) {
			$attributes = 'class="current aria-current="page"';
		}

		// Build the anchor for the 'Headlines' and add it to $views.
		array_push(
			$views,
			sprintf(
				'<a href="%1$s" %2$s>%3$s <span class="count">(%4$s)</span></a>',
				add_query_arg(
					array(
						'post_type'   => 'post',
						'post_status' => 'all',
						'meta_value'  => 'headline', // phpcs:ignore
					),
					'edit.php'
				),
				$attributes,
				__( 'Headlines' ),
				count(
					filter_posts_from_pages( get_headline_results() )
				)
			)
		);

		return $views;
	}
);
