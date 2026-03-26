<?php
/**
 * Schema.org: Product (used for produkt CPT)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id      = get_the_ID();
$brand        = get_post_meta( $post_id, '_brand',            true );
$sku          = get_post_meta( $post_id, '_sku',              true );
$price        = get_post_meta( $post_id, '_price',            true );
$buy_url      = get_post_meta( $post_id, '_buy_url',          true );
$agg_rating   = (float) get_post_meta( $post_id, '_aggregate_rating', true );
$rating_count = (int)   get_post_meta( $post_id, '_rating_count',     true );
$schema = [
	'@context'    => 'https://schema.org',
	'@type'       => 'Product',
	'name'        => get_the_title(),
	'description' => wp_strip_all_tags( get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 ) ),
	'url'         => get_permalink(),
];
if ( $brand ) $schema['brand'] = [ '@type' => 'Brand', 'name' => $brand ];
if ( $sku )   $schema['sku']   = $sku;
if ( has_post_thumbnail() ) { $img = get_the_post_thumbnail_url( $post_id, 'large' ); if ( $img ) $schema['image'] = $img; }
if ( $price && $buy_url ) {
	$schema['offers'] = [
		'@type'         => 'Offer',
		'url'           => $buy_url,
		'priceCurrency' => 'PLN',
		'price'         => preg_replace( '/[^0-9.,]/', '', $price ),
		'availability'  => 'https://schema.org/InStock',
		'seller'        => [ '@type' => 'Organization', 'name' => get_bloginfo( 'name' ) ],
	];
}
if ( $agg_rating > 0 ) {
	$schema['aggregateRating'] = [
		'@type'       => 'AggregateRating',
		'ratingValue' => number_format( $agg_rating, 1 ),
		'ratingCount' => max( 1, $rating_count ),
		'bestRating'  => '5',
		'worstRating' => '1',
	];
}
echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';