<?php
/**
 * Schema.org: FAQPage (conditional, used when _faq_items meta is present)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$post_id   = get_the_ID();
$faq_raw   = get_post_meta( $post_id, '_faq_items', true );
if ( ! $faq_raw ) return;
$faq_items = json_decode( $faq_raw, true );
if ( ! is_array( $faq_items ) || empty( $faq_items ) ) return;
$entities = [];
foreach ( $faq_items as $item ) {
	if ( empty( $item['question'] ) || empty( $item['answer'] ) ) continue;
	$entities[] = [
		'@type'          => 'Question',
		'name'           => sanitize_text_field( $item['question'] ),
		'acceptedAnswer' => [ '@type' => 'Answer', 'text' => wp_strip_all_tags( $item['answer'] ) ],
	];
}
if ( empty( $entities ) ) return;
echo '<script type="application/ld+json">' . wp_json_encode( [ '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';