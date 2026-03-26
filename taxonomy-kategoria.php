<?php
get_header();

$term = get_queried_object();
$taxonomy = 'kategoria';
$config = poradnik_get_taxonomy_archive_config($taxonomy);
$title = $term instanceof WP_Term ? $term->name : $config['label'];
$desc = $term instanceof WP_Term ? term_description($term) : '';
$description = !empty($desc) ? wp_strip_all_tags($desc) : $config['fallback_description'];
$related_terms = $term instanceof WP_Term ? poradnik_get_taxonomy_related_terms($taxonomy, (int) $term->term_id, 8, (int) $term->parent) : [];
$post_type_labels = poradnik_get_archive_post_type_labels();
$post_count = (int) $GLOBALS['wp_query']->found_posts;
?>
<section class="cpt-archive cpt-taxonomy cpt-taxonomy--kategoria">
	<header class="cpt-archive__hero">
		<div class="cpt-archive__hero-content">
			<span class="cpt-badge"><?php echo esc_html($config['label']); ?></span>
			<h1 class="cpt-archive__title"><?php echo esc_html($title); ?></h1>
			<p class="cpt-archive__desc"><?php echo esc_html($description); ?></p>
			<div class="cpt-taxonomy__stats">
				<div class="cpt-taxonomy__stat"><span class="cpt-taxonomy__stat-value"><?php echo esc_html((string) $post_count); ?></span><span class="cpt-taxonomy__stat-label">Publikacji</span></div>
				<div class="cpt-taxonomy__stat"><span class="cpt-taxonomy__stat-value"><?php echo esc_html((string) count($post_type_labels)); ?></span><span class="cpt-taxonomy__stat-label">Typy treści</span></div>
				<div class="cpt-taxonomy__stat"><span class="cpt-taxonomy__stat-value"><?php echo !empty($related_terms) ? esc_html((string) count($related_terms)) : '0'; ?></span><span class="cpt-taxonomy__stat-label">Powiązane kategorie</span></div>
			</div>
			<?php if (!empty($post_type_labels)) : ?>
				<div class="cpt-taxonomy__meta" aria-label="Zakres treści">
					<?php foreach ($post_type_labels as $post_type_label) : ?>
						<span class="cpt-chip cpt-chip--muted"><?php echo esc_html($post_type_label); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</header>

	<?php if (!empty($related_terms)) : ?>
	<nav class="cpt-archive__chips" aria-label="Powiązane kategorie">
		<?php foreach ($related_terms as $related_term) : ?>
			<a class="cpt-chip" href="<?php echo esc_url(get_term_link($related_term)); ?>"><?php echo esc_html($related_term->name); ?></a>
		<?php endforeach; ?>
	</nav>
	<?php endif; ?>

	<?php if (have_posts()) : ?>
		<div class="cpt-archive-grid">
			<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class('cpt-archive-card'); ?>>
					<?php if (has_post_thumbnail()) : ?>
						<a class="cpt-archive-card__thumb-wrap" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large', ['class' => 'cpt-archive-card__thumb', 'loading' => 'lazy']); ?></a>
					<?php endif; ?>
					<div class="cpt-archive-card__body">
						<h2 class="cpt-archive-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="cpt-archive-card__meta"><span><?php echo esc_html(poradnik_get_post_type_label(get_the_ID())); ?></span><span class="cpt-archive-card__dot">•</span><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time></div>
						<p class="cpt-archive-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
						<div class="cpt-archive-card__footer"><a class="cpt-btn cpt-btn--outline cpt-btn--sm" href="<?php the_permalink(); ?>">Czytaj więcej</a></div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="cpt-archive__pagination">
			<?php the_posts_pagination([
				'mid_size' => 1,
				'prev_text' => '← Poprzednia',
				'next_text' => 'Następna →',
			]); ?>
		</div>
	<?php else : ?>
		<div class="cpt-empty-state">
			<h2><?php echo esc_html($config['empty_title']); ?></h2>
			<p><?php echo esc_html($config['empty_description']); ?></p>
			<a class="cpt-btn cpt-btn--primary" href="<?php echo esc_url($config['cta_url']); ?>"><?php echo esc_html($config['cta_label']); ?></a>
		</div>
	<?php endif; ?>
</section>
<?php get_footer();
