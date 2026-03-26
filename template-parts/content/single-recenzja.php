<?php
/**
 * Template Part: Single Recenzja (Expert Review)
 * Layout: Enterprise — score ring, bars, pros/cons, verdict, buy CTA
 * Schema: Review + BreadcrumbList
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id        = get_the_ID();
$author_id      = (int) get_post_field( 'post_author', $post_id );
$cats           = get_the_terms( $post_id, 'kategoria' );
$primary_cat    = ( ! empty( $cats ) && ! is_wp_error( $cats ) ) ? $cats[0] : null;
$product_name   = get_post_meta( $post_id, '_product_name',  true ) ?: get_the_title( $post_id );
$overall_score  = (float) ( get_post_meta( $post_id, '_overall_score', true ) ?: 0 );
$scores_raw     = get_post_meta( $post_id, '_scores', true );
$scores         = $scores_raw ? (array) json_decode( $scores_raw, true ) : [];
$pros           = array_values( array_filter( explode( "\n", get_post_meta( $post_id, '_pros', true ) ?: '' ) ) );
$cons           = array_values( array_filter( explode( "\n", get_post_meta( $post_id, '_cons', true ) ?: '' ) ) );
$verdict        = get_post_meta( $post_id, '_verdict', true );
$product_buy    = get_post_meta( $post_id, '_product_buy_url', true );
$product_price  = get_post_meta( $post_id, '_product_price',   true );
$score_pct      = $overall_score > 0 ? min( 100, (int) round( ( $overall_score / 10 ) * 100 ) ) : 0;
$circumference  = round( 2 * M_PI * 34, 2 );
$offset         = round( ( 1 - $score_pct / 100 ) * $circumference, 2 );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cpt-single cpt-recenzja' ); ?>>

	<nav class="cpt-breadcrumbs" aria-label="Nawigacja">
		<ol class="breadcrumbs__list">
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Strona główna</a></li>
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/recenzje/' ) ); ?>">Recenzje</a></li>
			<?php if ( $primary_cat ) : ?><li class="breadcrumbs__item"><a href="<?php echo esc_url( get_term_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li><?php endif; ?>
			<li class="breadcrumbs__item" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</nav>

	<header class="cpt-header cpt-header--recenzja">
		<div class="cpt-header__body">
			<span class="cpt-badge cpt-badge--review">Recenzja eksperta</span>
			<h1 class="cpt-title"><?php the_title(); ?></h1>
			<div class="cpt-meta">
				<span class="cpt-meta__item"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time></span>
				<span class="cpt-meta__item">Autor: <?php the_author_meta( 'display_name', $author_id ); ?></span>
			</div>
			<?php if ( has_excerpt() ) : ?><p class="cpt-excerpt"><?php the_excerpt(); ?></p><?php endif; ?>
		</div>
		<?php if ( $overall_score > 0 ) : ?>
		<div class="cpt-header__score">
			<div class="cpt-score-ring cpt-score-ring--lg">
				<svg viewBox="0 0 80 80" class="cpt-score-ring__svg" aria-hidden="true">
					<circle cx="40" cy="40" r="34" class="cpt-score-ring__bg"/>
					<circle cx="40" cy="40" r="34" class="cpt-score-ring__fill" style="stroke-dasharray:<?php echo esc_attr( $circumference ); ?>;stroke-dashoffset:<?php echo esc_attr( $offset ); ?>"/>
				</svg>
				<div class="cpt-score-ring__inner">
					<span class="cpt-score-ring__value"><?php echo esc_html( number_format( $overall_score, 1 ) ); ?></span>
					<span class="cpt-score-ring__denom">/10</span>
				</div>
			</div>
			<p class="cpt-score-label"><?php echo $overall_score >= 8 ? 'Doskonały wybór' : ( $overall_score >= 6 ? 'Dobry wybór' : 'Przeciętny' ); ?></p>
		</div>
		<?php endif; ?>
	</header>

	<?php if ( $product_buy ) : ?>
	<div class="cpt-quick-buy">
		<div class="cpt-quick-buy__info">
			<strong><?php echo esc_html( $product_name ); ?></strong>
			<?php if ( $product_price ) : ?><span class="cpt-quick-buy__price"><?php echo esc_html( $product_price ); ?></span><?php endif; ?>
		</div>
		<a href="<?php echo esc_url( $product_buy ); ?>" class="cpt-btn cpt-btn--accent" target="_blank" rel="noopener noreferrer sponsored">Sprawdź najlepszą cenę →</a>
	</div>
	<?php endif; ?>

	<div class="cpt-layout cpt-layout--recenzja">
		<main class="cpt-content">

			<?php if ( has_post_thumbnail() ) : ?>
			<figure class="cpt-hero-image"><?php the_post_thumbnail( 'large', [ 'class' => 'cpt-featured-img', 'loading' => 'eager' ] ); ?></figure>
			<?php endif; ?>

			<?php if ( ! empty( $scores ) ) : ?>
			<section class="cpt-scores">
				<h2 class="cpt-section-title">Oceny cząstkowe</h2>
				<div class="cpt-scores__grid">
					<?php foreach ( $scores as $criterion => $value ) :
						$v   = (float) $value;
						$pct = min( 100, (int) round( ( $v / 10 ) * 100 ) );
					?>
					<div class="cpt-score-bar">
						<div class="cpt-score-bar__header">
							<span class="cpt-score-bar__label"><?php echo esc_html( ucfirst( $criterion ) ); ?></span>
							<span class="cpt-score-bar__val"><?php echo esc_html( number_format( $v, 1 ) ); ?>/10</span>
						</div>
						<div class="cpt-score-bar__track" role="meter" aria-valuenow="<?php echo esc_attr( $pct ); ?>" aria-valuemin="0" aria-valuemax="100" aria-label="<?php echo esc_attr( ucfirst( $criterion ) . ': ' . number_format( $v, 1 ) . '/10' ); ?>">
							<div class="cpt-score-bar__fill" style="width:<?php echo esc_attr( $pct ); ?>%"></div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</section>
			<?php endif; ?>

			<?php if ( ! empty( $pros ) || ! empty( $cons ) ) : ?>
			<section class="cpt-pros-cons">
				<div class="cpt-pros-cons__col cpt-pros-cons__col--pros">
					<h3 class="cpt-pros-cons__title cpt-pros-cons__title--pros">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
						Zalety
					</h3>
					<ul><?php foreach ( $pros as $pro ) : ?><li><?php echo esc_html( trim( $pro ) ); ?></li><?php endforeach; ?></ul>
				</div>
				<div class="cpt-pros-cons__col cpt-pros-cons__col--cons">
					<h3 class="cpt-pros-cons__title cpt-pros-cons__title--cons">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
						Wady
					</h3>
					<ul><?php foreach ( $cons as $con ) : ?><li><?php echo esc_html( trim( $con ) ); ?></li><?php endforeach; ?></ul>
				</div>
			</section>
			<?php endif; ?>

			<div class="cpt-prose"><?php the_content(); ?></div>

			<?php if ( $verdict ) : ?>
			<div class="cpt-verdict">
				<div class="cpt-verdict__icon" aria-hidden="true">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
				</div>
				<div class="cpt-verdict__body">
					<h3 class="cpt-verdict__title">Werdykt eksperta</h3>
					<p class="cpt-verdict__text"><?php echo wp_kses_post( $verdict ); ?></p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( $product_buy ) : ?>
			<div class="cpt-buy-cta">
				<p class="cpt-buy-cta__product"><?php echo esc_html( $product_name ); ?></p>
				<?php if ( $product_price ) : ?><p class="cpt-buy-cta__price">Cena: <strong><?php echo esc_html( $product_price ); ?></strong></p><?php endif; ?>
				<a href="<?php echo esc_url( $product_buy ); ?>" class="cpt-btn cpt-btn--accent cpt-btn--lg" target="_blank" rel="noopener noreferrer sponsored">Sprawdź najlepszą cenę</a>
			</div>
			<?php endif; ?>

		</main>

		<aside class="cpt-sidebar">
			<?php if ( $overall_score > 0 ) : ?>
			<div class="cpt-summary-box">
				<h3 class="cpt-summary-box__title">Nasza ocena</h3>
				<div class="cpt-summary-box__score"><?php echo esc_html( number_format( $overall_score, 1 ) ); ?><span>/10</span></div>
				<p class="cpt-summary-box__label"><?php echo $overall_score >= 8 ? '🏆 Doskonały wybór' : ( $overall_score >= 6 ? '👍 Dobry wybór' : '😐 Przeciętny' ); ?></p>
				<?php if ( $product_buy ) : ?><a href="<?php echo esc_url( $product_buy ); ?>" class="cpt-btn cpt-btn--primary cpt-btn--full" target="_blank" rel="noopener noreferrer sponsored">Sprawdź ofertę</a><?php endif; ?>
			</div>
			<?php endif; ?>

			<?php
			$rel = get_posts( [ 'post_type' => 'recenzja', 'posts_per_page' => 5, 'post__not_in' => [ $post_id ], 'orderby' => 'date', 'order' => 'DESC', 'no_found_rows' => true ] );
			if ( ! empty( $rel ) ) : ?>
			<div class="cpt-related-sidebar">
				<h3 class="cpt-related-sidebar__title">Podobne recenzje</h3>
				<ul class="cpt-related-sidebar__list"><?php foreach ( $rel as $r ) : ?><li><a href="<?php echo esc_url( get_permalink( $r->ID ) ); ?>"><?php echo esc_html( $r->post_title ); ?></a></li><?php endforeach; ?></ul>
			</div>
			<?php endif; wp_reset_postdata(); ?>
		</aside>
	</div>

</article>
<?php get_template_part( 'template-parts/schema/schema', 'breadcrumb' ); ?>
<?php get_template_part( 'template-parts/schema/schema', 'review' ); ?>