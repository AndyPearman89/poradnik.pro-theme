<?php
/**
 * Schema.org: Article (used for poradnik CPT)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id   = get_the_ID();
$author_id = (int) get_post_field( 'post_author', $post_id );
$schema = [
	'@context'         => 'https://schema.org',
	'@type'            => 'Article',
	'headline'         => get_the_title(),
	'description'      => wp_strip_all_tags( get_the_excerpt() ?: wp_trim_words( get_the_content(), 30 ) ),
	'url'              => get_permalink(),
	'datePublished'    => get_the_date( 'c' ),
	'dateModified'     => get_the_modified_date( 'c' ),
	'inLanguage'       => get_bloginfo( 'language' ),
	'author'           => [
		'@type' => 'Person',
		'name'  => get_the_author_meta( 'display_name', $author_id ),
		'url'   => get_author_posts_url( $author_id ),
	],
	'publisher'        => [
		'@type' => 'Organization',
		'name'  => get_bloginfo( 'name' ),
		'url'   => home_url( '/' ),
		'logo'  => [ '@type' => 'ImageObject', 'url' => get_site_icon_url( 60 ) ?: home_url( '/favicon.ico' ) ],
	],
	'mainEntityOfPage' => [ '@type' => 'WebPage', '@id' => get_permalink() ],
];
if ( has_post_thumbnail() ) {
	$img = get_the_post_thumbnail_url( $post_id, 'large' );
	if ( $img ) $schema['image'] = [ '@type' => 'ImageObject', 'url' => $img ];
}
$word_count = str_word_count( strip_tags( get_the_content() ) );
if ( $word_count > 0 ) $schema['wordCount'] = $word_count;
echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';