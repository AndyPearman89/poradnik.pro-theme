<?php
/**
 * Template Part: Single Ranking
 * Layout: Enterprise — Top3 podium + full ranking table + sidebar
 * Schema: ItemList + BreadcrumbList
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id      = get_the_ID();
$cats         = get_the_terms( $post_id, 'kategoria' );
$primary_cat  = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0] : null;
$updated_date = get_post_meta( $post_id, '_updated_date', true ) ?: get_the_modified_date( 'Y-m-d' );

$ranking_items = [];
$raw = get_post_meta( $post_id, '_ranking_items', true );
if ( $raw ) {
	$d = json_decode( $raw, true );
	if ( is_array( $d ) ) $ranking_items = $d;
}
$medals = [ '🥇', '🥈', '🥉' ];
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cpt-single cpt-ranking' ); ?>>

	<nav class="cpt-breadcrumbs" aria-label="Nawigacja">
		<ol class="breadcrumbs__list">
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Strona główna</a></li>
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/rankingi/' ) ); ?>">Rankingi</a></li>
			<?php if ( $primary_cat ) : ?><li class="breadcrumbs__item"><a href="<?php echo esc_url( get_term_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li><?php endif; ?>
			<li class="breadcrumbs__item" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</nav>

	<header class="cpt-header cpt-header--ranking">
		<span class="cpt-badge cpt-badge--ranking"><?php echo esc_html( 'Ranking ' . date_i18n( 'Y' ) ); ?></span>
		<h1 class="cpt-title"><?php the_title(); ?></h1>
		<div class="cpt-meta">
			<span class="cpt-meta__item"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time></span>
			<?php if ( $updated_date ) : ?><span class="cpt-meta__item cpt-meta__item--updated"><?php printf( 'Akt.: %s', esc_html( date_i18n( 'j F Y', strtotime( $updated_date ) ) ) ); ?></span><?php endif; ?>
			<?php if ( ! empty( $ranking_items ) ) : ?><span class="cpt-meta__item"><?php printf( '%d pozycji', count( $ranking_items ) ); ?></span><?php endif; ?>
		</div>
		<?php if ( has_excerpt() ) : ?><p class="cpt-excerpt"><?php the_excerpt(); ?></p><?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
	<figure class="cpt-hero-image"><?php the_post_thumbnail( 'large', [ 'class' => 'cpt-featured-img', 'loading' => 'eager' ] ); ?></figure>
	<?php endif; ?>

	<?php if ( ! empty( $ranking_items ) ) :
		$top3 = array_slice( $ranking_items, 0, 3 );
	?>
	<section class="cpt-podium">
		<h2 class="cpt-section-title">Top 3 rankingu</h2>
		<div class="cpt-podium__grid">
			<?php foreach ( $top3 as $idx => $item ) :
				if ( empty( $item['name'] ) ) continue;
				$score = (float) ( $item['score'] ?? 0 );
			?>
			<div class="cpt-podium__card cpt-podium__card--pos-<?php echo ( $idx + 1 ); ?>">
				<div class="cpt-podium__medal"><?php echo esc_html( $medals[ $idx ] ?? ( $idx + 1 ) ); ?></div>
				<?php if ( ! empty( $item['thumb'] ) ) : ?>
				<img src="<?php echo esc_url( $item['thumb'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" class="cpt-podium__thumb" loading="lazy" width="120" height="80">
				<?php endif; ?>
				<h3 class="cpt-podium__name"><?php echo esc_html( $item['name'] ); ?></h3>
				<?php if ( ! empty( $item['summary'] ) ) : ?><p class="cpt-podium__summary"><?php echo esc_html( $item['summary'] ); ?></p><?php endif; ?>
				<?php if ( $score > 0 ) : ?>
				<div class="cpt-score-badge"><span class="cpt-score-badge__val"><?php echo esc_html( number_format( $score, 1 ) ); ?></span><span class="cpt-score-badge__max">/10</span></div>
				<?php endif; ?>
				<?php if ( ! empty( $item['url'] ) ) : ?>
				<a href="<?php echo esc_url( $item['url'] ); ?>" class="cpt-btn cpt-btn--primary cpt-btn--sm" target="_blank" rel="noopener noreferrer sponsored">Sprawdź ofertę</a>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<div class="cpt-layout cpt-layout--ranking">
		<main class="cpt-content">

			<?php if ( ! empty( $ranking_items ) ) : ?>
			<section class="cpt-ranking-table">
				<h2 class="cpt-section-title">Pełny ranking</h2>
				<div class="cpt-table-wrap">
					<table class="cpt-table">
						<thead><tr><th>#</th><th>Produkt / Usługa</th><th>Ocena</th><th>Główne zalety</th><th>Akcja</th></tr></thead>
						<tbody>
						<?php foreach ( $ranking_items as $pos => $item ) :
							if ( empty( $item['name'] ) ) continue;
							$score = (float) ( $item['score'] ?? 0 );
						?>
						<tr class="cpt-table__row<?php echo ( $pos < 3 ) ? ' cpt-table__row--top' : ''; ?>">
							<td class="cpt-table__pos"><span class="cpt-pos-num"><?php echo esc_html( $pos + 1 ); ?></span></td>
							<td class="cpt-table__product">
								<?php if ( ! empty( $item['thumb'] ) ) : ?><img src="<?php echo esc_url( $item['thumb'] ); ?>" alt="" class="cpt-table__thumb" loading="lazy" width="48" height="32"><?php endif; ?>
								<strong><?php echo esc_html( $item['name'] ); ?></strong>
							</td>
							<td class="cpt-table__score"><?php if ( $score > 0 ) : ?><span class="cpt-score-inline"><?php echo esc_html( number_format( $score, 1 ) ); ?><span>/10</span></span><?php endif; ?></td>
							<td class="cpt-table__pros"><?php echo esc_html( $item['pros'] ?? '' ); ?></td>
							<td class="cpt-table__action"><?php if ( ! empty( $item['url'] ) ) : ?><a href="<?php echo esc_url( $item['url'] ); ?>" class="cpt-btn cpt-btn--outline cpt-btn--xs" target="_blank" rel="noopener noreferrer sponsored">Sprawdź</a><?php endif; ?></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
			<?php endif; ?>

			<div class="cpt-prose"><?php the_content(); ?></div>

		</main>

		<aside class="cpt-sidebar">
			<?php if ( ! empty( $ranking_items ) ) : ?>
			<div class="cpt-toc">
				<h3 class="cpt-toc__title">Najlepsze wybory</h3>
				<ol class="cpt-toc__list">
					<?php foreach ( array_slice( $ranking_items, 0, 10 ) as $i => $item ) :
						if ( empty( $item['name'] ) ) continue;
					?>
					<li class="cpt-toc__item"><span class="cpt-toc__num"><?php echo esc_html( $i + 1 ); ?>.</span> <?php echo esc_html( $item['name'] ); ?></li>
					<?php endforeach; ?>
				</ol>
			</div>
			<?php endif; ?>
			<div class="cpt-sidebar-cta">
				<p class="cpt-sidebar-cta__title">Szukasz najlepszej opcji?</p>
				<p class="cpt-sidebar-cta__desc">Porównaj ceny i wybierz najlepiej dopasowaną ofertę.</p>
				<a href="<?php echo esc_url( home_url( '/rankingi/' ) ); ?>" class="cpt-btn cpt-btn--primary">Więcej rankingów</a>
			</div>
		</aside>
	</div>

</article>
<?php get_template_part( 'template-parts/schema/schema', 'breadcrumb' ); ?>
<?php
$schema_items = [];
if ( ! empty( $ranking_items ) ) {
	foreach ( $ranking_items as $i => $ri ) {
		if ( empty( $ri['name'] ) ) continue;
		$schema_items[] = [ '@type' => 'ListItem', 'position' => $i + 1, 'name' => sanitize_text_field( $ri['name'] ), 'url' => ! empty( $ri['url'] ) ? esc_url( $ri['url'] ) : get_permalink( $post_id ) ];
	}
}
if ( ! empty( $schema_items ) ) {
	echo '<script type="application/ld+json">' . wp_json_encode( [ '@context' => 'https://schema.org', '@type' => 'ItemList', 'name' => get_the_title(), 'description' => wp_strip_all_tags( get_the_excerpt() ), 'url' => get_permalink( $post_id ), 'numberOfItems' => count( $schema_items ), 'itemListElement' => $schema_items ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
}
?>