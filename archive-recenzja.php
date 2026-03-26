<?php
get_header();

$title = 'Recenzje ekspertów';
$desc  = 'Rzetelne testy, oceny i rekomendacje produktów przygotowane przez redakcję Poradnik.pro.';
$terms = get_terms([
	'taxonomy'   => 'kategoria',
	'hide_empty' => true,
	'number'     => 12,
]);
?>
<section class="cpt-archive cpt-archive--recenzja">
	<header class="cpt-archive__hero">
		<div class="cpt-archive__hero-content">
			<span class="cpt-badge">Recenzje</span>
			<h1 class="cpt-archive__title"><?php echo esc_html($title); ?></h1>
			<p class="cpt-archive__desc"><?php echo esc_html($desc); ?></p>
		</div>
	</header>

	<?php if (!empty($terms) && !is_wp_error($terms)) : ?>
	<nav class="cpt-archive__chips" aria-label="Popularne kategorie recenzji">
		<?php foreach ($terms as $term) : ?>
			<a class="cpt-chip" href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
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
					<div class="cpt-archive-card__meta"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time></div>
					<p class="cpt-archive-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
					<a class="cpt-btn cpt-btn--outline cpt-btn--sm" href="<?php the_permalink(); ?>">Czytaj recenzję</a>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
	<div class="cpt-archive__pagination">
		<?php the_posts_pagination([
			'mid_size'  => 1,
			'prev_text' => '← Poprzednia',
			'next_text' => 'Następna →',
		]); ?>
	</div>
	<?php else : ?>
		<div class="cpt-empty-state">
			<h2>Brak recenzji do wyświetlenia</h2>
			<p>Nowe recenzje pojawią się wkrótce.</p>
			<a class="cpt-btn cpt-btn--primary" href="<?php echo esc_url(home_url('/')); ?>">Powrót na stronę główną</a>
		</div>
	<?php endif; ?>
</section>
<?php get_footer();
