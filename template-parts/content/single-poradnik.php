<?php
/**
 * Template Part: Single Poradnik (artykuł poradnikowy)
 * Layout: Enterprise — dwukolumnowy (treść 2/3 + sticky sidebar 1/3)
 * Features: TOC, breadcrumbs, FAQ accordion, author box, share, related
 * Schema: Article + BreadcrumbList + FAQPage (conditional)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $post;
$post_id    = get_the_ID();
$categories = get_the_terms( $post_id, 'kategoria' );
$tags       = get_the_terms( $post_id, 'tag' );
$author_id  = (int) get_post_field( 'post_author', $post_id );

// Reading time
$content_text = strip_tags( get_the_content() );
$word_count   = str_word_count( $content_text );
$read_minutes = max( 1, (int) ceil( $word_count / 200 ) );

// Meta fields
$updated_date = get_post_meta( $post_id, '_updated_date', true ) ?: get_the_modified_date( 'Y-m-d' );
$expert_title = get_post_meta( $post_id, '_expert_title', true );
$faq_raw      = get_post_meta( $post_id, '_faq_items', true );
$faq_items    = [];
if ( $faq_raw ) {
	$decoded = json_decode( $faq_raw, true );
	if ( is_array( $decoded ) ) $faq_items = $decoded;
}
$primary_cat = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0] : null;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cpt-single cpt-poradnik' ); ?> itemscope itemtype="https://schema.org/Article">

	<!-- BREADCRUMBS -->
	<nav class="cpt-breadcrumbs" aria-label="<?php esc_attr_e( 'Nawigacja okruszkowa', 'generatepress-child-poradnik' ); ?>">
		<ol class="breadcrumbs__list">
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Strona główna', 'generatepress-child-poradnik' ); ?></a></li>
			<li class="breadcrumbs__item"><a href="<?php echo esc_url( home_url( '/poradniki/' ) ); ?>"><?php esc_html_e( 'Poradniki', 'generatepress-child-poradnik' ); ?></a></li>
			<?php if ( $primary_cat ) : ?>
				<li class="breadcrumbs__item"><a href="<?php echo esc_url( get_term_link( $primary_cat ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a></li>
			<?php endif; ?>
			<li class="breadcrumbs__item" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</nav>

	<!-- ARTICLE HEADER -->
	<header class="cpt-header cpt-header--poradnik">
		<?php if ( $primary_cat ) : ?>
			<a href="<?php echo esc_url( get_term_link( $primary_cat ) ); ?>" class="cpt-badge cpt-badge--category"><?php echo esc_html( $primary_cat->name ); ?></a>
		<?php endif; ?>
		<h1 class="cpt-title" itemprop="headline"><?php the_title(); ?></h1>
		<div class="cpt-meta">
			<span class="cpt-meta__item">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
			</span>
			<span class="cpt-meta__item" itemprop="author" itemscope itemtype="https://schema.org/Person">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
				<span itemprop="name"><?php the_author_meta( 'display_name', $author_id ); ?></span>
			</span>
			<span class="cpt-meta__item">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
				<?php printf( esc_html__( '%d min czytania', 'generatepress-child-poradnik' ), $read_minutes ); ?>
			</span>
			<?php if ( $updated_date && $updated_date !== get_the_date( 'Y-m-d' ) ) : ?>
			<span class="cpt-meta__item cpt-meta__item--updated">
				<?php printf( esc_html__( 'Akt.: %s', 'generatepress-child-poradnik' ), esc_html( date_i18n( 'j F Y', strtotime( $updated_date ) ) ) ); ?>
			</span>
			<?php endif; ?>
		</div>
		<?php if ( has_excerpt() ) : ?><p class="cpt-excerpt" itemprop="description"><?php the_excerpt(); ?></p><?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
	<figure class="cpt-hero-image">
		<?php the_post_thumbnail( 'large', [ 'class' => 'cpt-featured-img', 'loading' => 'eager', 'itemprop' => 'image' ] ); ?>
		<?php $caption = get_the_post_thumbnail_caption(); if ( $caption ) : ?>
			<figcaption class="cpt-hero-image__caption"><?php echo esc_html( $caption ); ?></figcaption>
		<?php endif; ?>
	</figure>
	<?php endif; ?>

	<div class="cpt-layout cpt-layout--article">

		<main class="cpt-content" id="cpt-main-poradnik">

			<div class="cpt-prose" itemprop="articleBody">
				<?php
				the_content();
				wp_link_pages( [
					'before' => '<div class="cpt-pagination"><span>' . esc_html__( 'Strony:', 'generatepress-child-poradnik' ) . '</span>',
					'after'  => '</div>',
				] );
				?>
			</div>

			<?php if ( ! empty( $faq_items ) ) : ?>
			<section class="cpt-faq" id="faq" itemscope itemtype="https://schema.org/FAQPage">
				<h2 class="cpt-section-title"><?php esc_html_e( 'Najczęściej zadawane pytania', 'generatepress-child-poradnik' ); ?></h2>
				<div class="cpt-faq__list">
					<?php foreach ( $faq_items as $i => $item ) :
						if ( empty( $item['question'] ) || empty( $item['answer'] ) ) continue;
						$faq_id = 'faq-item-' . ( $i + 1 );
					?>
					<div class="cpt-faq__item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
						<button class="cpt-faq__question" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $faq_id ); ?>" itemprop="name">
							<?php echo esc_html( $item['question'] ); ?>
							<svg class="cpt-faq__chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
						</button>
						<div class="cpt-faq__answer" id="<?php echo esc_attr( $faq_id ); ?>" hidden itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
							<div class="cpt-faq__answer-inner" itemprop="text"><?php echo wp_kses_post( $item['answer'] ); ?></div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</section>
			<?php endif; ?>

			<?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
			<div class="cpt-tags">
				<?php foreach ( $tags as $tag ) : ?>
				<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="cpt-tag" rel="tag"><?php echo esc_html( $tag->name ); ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<div class="cpt-author-box" itemscope itemtype="https://schema.org/Person">
				<?php echo get_avatar( $author_id, 80, '', '', [ 'class' => 'cpt-author-box__avatar' ] ); ?>
				<div class="cpt-author-box__info">
					<p class="cpt-author-box__name" itemprop="name"><?php the_author_meta( 'display_name', $author_id ); ?></p>
					<p class="cpt-author-box__role"><?php echo $expert_title ? esc_html( $expert_title ) : esc_html__( 'Ekspert Poradnik.pro', 'generatepress-child-poradnik' ); ?></p>
					<?php $bio = get_the_author_meta( 'description', $author_id ); if ( $bio ) : ?>
					<p class="cpt-author-box__bio"><?php echo esc_html( $bio ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="cpt-share">
				<span class="cpt-share__label"><?php esc_html_e( 'Udostępnij:', 'generatepress-child-poradnik' ); ?></span>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink() ); ?>" class="cpt-share__btn cpt-share__btn--fb" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg> Facebook
				</a>
				<a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&amp;text=<?php echo rawurlencode( get_the_title() ); ?>" class="cpt-share__btn cpt-share__btn--tw" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.7 5.5 4.3 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg> Twitter
				</a>
				<button type="button" class="cpt-share__btn cpt-share__btn--copy" data-url="<?php echo esc_attr( get_permalink() ); ?>"><?php esc_html_e( 'Kopiuj link', 'generatepress-child-poradnik' ); ?></button>
			</div>

		</main>

		<aside class="cpt-sidebar">
			<div class="cpt-toc" id="cpt-toc">
				<h3 class="cpt-toc__title"><?php esc_html_e( 'Spis treści', 'generatepress-child-poradnik' ); ?></h3>
				<nav class="cpt-toc__nav"><p class="cpt-toc__placeholder"><?php esc_html_e( 'Ładowanie...', 'generatepress-child-poradnik' ); ?></p></nav>
			</div>

			<?php
			$related_args = [
				'post_type'     => 'poradnik',
				'posts_per_page'=> 5,
				'post__not_in'  => [ $post_id ],
				'orderby'       => 'date',
				'order'         => 'DESC',
				'no_found_rows' => true,
			];
			if ( $primary_cat ) $related_args['tax_query'] = [ [ 'taxonomy' => 'kategoria', 'field' => 'term_id', 'terms' => $primary_cat->term_id ] ];
			$related_posts = get_posts( $related_args );
			if ( ! empty( $related_posts ) ) : ?>
			<div class="cpt-related-sidebar">
				<h3 class="cpt-related-sidebar__title"><?php esc_html_e( 'Podobne poradniki', 'generatepress-child-poradnik' ); ?></h3>
				<ul class="cpt-related-sidebar__list">
					<?php foreach ( $related_posts as $rel ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $rel->ID ) ); ?>"><?php echo esc_html( $rel->post_title ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; wp_reset_postdata(); ?>

			<div class="cpt-sidebar-cta">
				<p class="cpt-sidebar-cta__title"><?php esc_html_e( 'Potrzebujesz specjalisty?', 'generatepress-child-poradnik' ); ?></p>
				<p class="cpt-sidebar-cta__desc"><?php esc_html_e( 'Porównaj oferty lokalnych ekspertów.', 'generatepress-child-poradnik' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/specjalisci/' ) ); ?>" class="cpt-btn cpt-btn--primary cpt-btn--full"><?php esc_html_e( 'Znajdź specjalistę', 'generatepress-child-poradnik' ); ?></a>
			</div>
		</aside>

	</div>
</article>
<?php get_template_part( 'template-parts/schema/schema', 'article' ); ?>
<?php get_template_part( 'template-parts/schema/schema', 'breadcrumb' ); ?>
<?php if ( ! empty( $faq_items ) ) get_template_part( 'template-parts/schema/schema', 'faq' ); ?>
<script>(function(){'use strict';
var main=document.getElementById('cpt-main-poradnik'),tocNav=document.querySelector('#cpt-toc .cpt-toc__nav');
if(main&&tocNav){var hs=main.querySelectorAll('.cpt-prose h2,.cpt-prose h3');if(hs.length){var ul=document.createElement('ul');ul.className='cpt-toc__list';hs.forEach(function(h,i){if(!h.id)h.id='h-'+i;var li=document.createElement('li');li.className='cpt-toc__item cpt-toc__item--'+h.tagName.toLowerCase();var a=document.createElement('a');a.href='#'+h.id;a.textContent=h.textContent;li.appendChild(a);ul.appendChild(li);});tocNav.innerHTML='';tocNav.appendChild(ul);}else{var tb=document.getElementById('cpt-toc');if(tb)tb.style.display='none';}}
document.querySelectorAll('.cpt-faq__question').forEach(function(b){b.addEventListener('click',function(){var x=this.getAttribute('aria-expanded')==='true',t=document.getElementById(this.getAttribute('aria-controls'));this.setAttribute('aria-expanded',x?'false':'true');if(t)t.hidden=x;});});
var cb=document.querySelector('.cpt-share__btn--copy');if(cb&&navigator.clipboard)cb.addEventListener('click',function(){navigator.clipboard.writeText(this.dataset.url||location.href).then(function(){cb.textContent='✓ Skopiowano!';setTimeout(function(){cb.textContent='Kopiuj link';},2000);});});
}());</script>