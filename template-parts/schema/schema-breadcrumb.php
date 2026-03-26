<?php
/**
 * Schema.org: BreadcrumbList (dynamic, used on all CPT singles)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id   = get_the_ID();
$post_type = get_post_type();
$items     = [];
$position  = 1;
$items[]   = [ '@type' => 'ListItem', 'position' => $position++, 'name' => get_bloginfo( 'name' ), 'item' => home_url( '/' ) ];
$archive_map = [
	'poradnik' => [ 'Poradniki', '/poradniki/' ],
	'ranking'  => [ 'Rankingi',  '/rankingi/' ],
	'recenzja' => [ 'Recenzje',  '/recenzje/' ],
	'produkt'  => [ 'Produkty',  '/produkty/' ],
];
if ( isset( $archive_map[ $post_type ] ) ) {
	$items[] = [ '@type' => 'ListItem', 'position' => $position++, 'name' => $archive_map[ $post_type ][0], 'item' => home_url( $archive_map[ $post_type ][1] ) ];
}
$cats = get_the_terms( $post_id, 'kategoria' );
if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
	$link = get_term_link( $cats[0] );
	if ( ! is_wp_error( $link ) ) {
		$items[] = [ '@type' => 'ListItem', 'position' => $position++, 'name' => $cats[0]->name, 'item' => $link ];
	}
}
$items[] = [ '@type' => 'ListItem', 'position' => $position, 'name' => get_the_title(), 'item' => get_permalink() ];
echo '<script type="application/ld+json">' . wp_json_encode( [ '@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';
