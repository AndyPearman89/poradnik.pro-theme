<?php
/**
 * Schema.org: Review (used for recenzja CPT)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id       = get_the_ID();
$author_id     = (int) get_post_field( 'post_author', $post_id );
$product_name  = get_post_meta( $post_id, '_product_name',  true ) ?: get_the_title();
$overall_score = (float) get_post_meta( $post_id, '_overall_score', true );
$brand         = get_post_meta( $post_id, '_brand', true );
$schema = [
	'@context'      => 'https://schema.org',
	'@type'         => 'Review',
	'name'          => get_the_title(),
	'description'   => wp_strip_all_tags( get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 ) ),
	'url'           => get_permalink(),
	'datePublished' => get_the_date( 'c' ),
	'dateModified'  => get_the_modified_date( 'c' ),
	'author'        => [ '@type' => 'Person', 'name' => get_the_author_meta( 'display_name', $author_id ) ],
	'publisher'     => [ '@type' => 'Organization', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ],
	'itemReviewed'  => [ '@type' => 'Product', 'name' => $product_name ],
];
if ( $brand ) $schema['itemReviewed']['brand'] = [ '@type' => 'Brand', 'name' => $brand ];
if ( $overall_score > 0 ) {
	$schema['reviewRating'] = [
		'@type'       => 'Rating',
		'ratingValue' => number_format( $overall_score, 1 ),
		'bestRating'  => '10',
		'worstRating' => '1',
	];
}
if ( has_post_thumbnail() ) { $img = get_the_post_thumbnail_url( $post_id, 'large' ); if ( $img ) $schema['image'] = $img; }
echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';