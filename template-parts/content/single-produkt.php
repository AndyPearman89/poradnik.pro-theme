<?php
/**
 * Template Part: Single Produkt
 * Layout: Enterprise — product header, offers, specs, content
 * Schema: Product + BreadcrumbList
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id      = get_the_ID();
$cats         = get_the_terms( $post_id, 'kategoria' );
$primary_cat  = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0] : null;
$brand        = get_post_meta( $post_id, '_brand',            true );
$sku          = get_post_meta( $post_id, '_sku',              true );
$product_price= get_post_meta( $post_id, '_price',            true );
$product_url  = get_post_meta( $post_id, '_buy_url',          true );
$agg_rating   = (float) get_post_meta( $post_id, '_aggregate_rating', true );
$rating_count = (int)   get_post_meta( $post_id, '_rating_count',     true );

$specs  = [];
$raw    = get_post_meta( $post_id, '_specs', true );
if ( $raw ) { $d = json_decode( $raw, true ); if ( is_array( $d ) ) $specs = $d; }

$offers = [];
$raw_o  = get_post_meta( $post_id, '_offers', true );
if ( $raw_o ) { $d = json_decode( $raw_o, true ); if ( is_array( $d ) ) $offers = $d; }
if ( empty( $offers ) && $product_url ) {
	$offers[] = [ 'shop' => 'Sprawdź ofertę', 'price' => $product_price, 'url' => $product_url ];
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cpt-single cpt-produkt' ); ?>>

	<nav class="cpt-breadcrumbs" aria-label="Nawigacja">
		<ol class="breadcrumbs__list">
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Strona główna</a></li>
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/produkty/' ) ); ?>">Produkty</a></li>
			<?php if ( $primary_cat ) : ?><li class="breadcrumbs__item"><a href="<?php echo esc_url( get_term_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li><?php endif; ?>
			<li class="breadcrumbs__item" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</nav>

	<header class="cpt-header cpt-header--produkt">
		<div class="cpt-header__body">
			<?php if ( $brand ) : ?><span class="cpt-badge cpt-badge--brand"><?php echo esc_html( $brand ); ?></span><?php endif; ?>
			<h1 class="cpt-title"><?php the_title(); ?></h1>
			<div class="cpt-meta">
				<?php if ( $sku ) : ?><span class="cpt-meta__item">SKU: <code><?php echo esc_html( $sku ); ?></code></span><?php endif; ?>
				<?php if ( $agg_rating > 0 ) : ?>
				<span class="cpt-meta__item cpt-stars" aria-label="Ocena <?php echo esc_attr( number_format( $agg_rating, 1 ) ); ?>/5">
					<?php for ( $s = 1; $s <= 5; $s++ ) : ?><svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $s <= round( $agg_rating ) ? '#f59e0b' : 'none'; ?>" stroke="#f59e0b" stroke-width="1.5" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg><?php endfor; ?>
					<span>(<?php echo esc_html( $rating_count ); ?> opinii)</span>
				</span>
				<?php endif; ?>
			</div>
			<?php if ( has_excerpt() ) : ?><p class="cpt-excerpt"><?php the_excerpt(); ?></p><?php endif; ?>
		</div>
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="cpt-header__image"><?php the_post_thumbnail( 'medium', [ 'class' => 'cpt-product-thumb', 'loading' => 'eager' ] ); ?></div>
		<?php endif; ?>
	</header>

	<?php if ( ! empty( $offers ) ) : ?>
	<section class="cpt-offers">
		<h2 class="cpt-section-title">Najlepsze oferty</h2>
		<div class="cpt-offers__list">
			<?php foreach ( $offers as $i => $offer ) :
				if ( empty( $offer['url'] ) ) continue;
			?>
			<div class="cpt-offer-row<?php echo ( $i === 0 ) ? ' cpt-offer-row--top' : ''; ?>">
				<?php if ( $i === 0 ) : ?><span class="cpt-offer-row__badge">Najlepsza cena</span><?php endif; ?>
				<span class="cpt-offer-row__shop"><?php echo esc_html( $offer['shop'] ?? '' ); ?></span>
				<?php if ( ! empty( $offer['price'] ) ) : ?><strong class="cpt-offer-row__price"><?php echo esc_html( $offer['price'] ); ?></strong><?php endif; ?>
				<a href="<?php echo esc_url( $offer['url'] ); ?>" class="cpt-btn <?php echo ( $i === 0 ) ? 'cpt-btn--accent' : 'cpt-btn--outline'; ?> cpt-btn--sm" target="_blank" rel="noopener noreferrer sponsored">Sprawdź</a>
			</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<div class="cpt-layout cpt-layout--produkt">
		<main class="cpt-content">

			<?php if ( ! empty( $specs ) ) : ?>
			<section class="cpt-specs">
				<h2 class="cpt-section-title">Specyfikacja techniczna</h2>
				<table class="cpt-table cpt-table--specs">
					<tbody>
					<?php foreach ( $specs as $key => $val ) : ?>
					<tr><th scope="row"><?php echo esc_html( ucfirst( $key ) ); ?></th><td><?php echo esc_html( $val ); ?></td></tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</section>
			<?php endif; ?>

			<div class="cpt-prose"><?php the_content(); ?></div>

		</main>

		<aside class="cpt-sidebar">
			<?php if ( ! empty( $specs ) ) : ?>
			<div class="cpt-spec-quick">
				<h3 class="cpt-spec-quick__title">Kluczowe cechy</h3>
				<ul class="cpt-spec-quick__list">
					<?php foreach ( array_slice( $specs, 0, 6, true ) as $k => $v ) : ?>
					<li><span><?php echo esc_html( ucfirst( $k ) ); ?></span><strong><?php echo esc_html( $v ); ?></strong></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $offers ) ) : $top = $offers[0]; ?>
			<div class="cpt-sidebar-cta">
				<?php if ( ! empty( $top['price'] ) ) : ?><p class="cpt-sidebar-cta__title"><?php echo esc_html( $top['price'] ); ?></p><?php endif; ?>
				<a href="<?php echo esc_url( $top['url'] ?? '#' ); ?>" class="cpt-btn cpt-btn--accent cpt-btn--full" target="_blank" rel="noopener noreferrer sponsored">Najlepsza cena →</a>
			</div>
			<?php endif; ?>
		</aside>
	</div>

</article>
<?php get_template_part( 'template-parts/schema/schema', 'breadcrumb' ); ?>
<?php get_template_part( 'template-parts/schema/schema', 'product' ); ?>