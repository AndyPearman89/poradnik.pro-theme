<?php
get_header();

$term = get_queried_object();
$title = $term instanceof WP_Term ? $term->name : 'Miasto';
$desc = $term instanceof WP_Term ? term_description($term) : '';
?>
<section class="cpt-archive cpt-taxonomy cpt-taxonomy--miasto">
	<header class="cpt-archive__hero">
		<div class="cpt-archive__hero-content">
			<span class="cpt-badge">Miasto</span>
			<h1 class="cpt-archive__title"><?php echo esc_html($title); ?></h1>
			<p class="cpt-archive__desc">
				<?php
				if (!empty($desc)) {
					echo wp_kses_post(wp_strip_all_tags($desc));
				} else {
					echo esc_html__('Specjaliści i treści przypisane do tej lokalizacji.', 'generatepress-child-poradnik');
				}
				?>
			</p>
		</div>
	</header>

	<?php if (have_posts()) : ?>
		<div class="cpt-archive-grid">
			<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class('cpt-archive-card'); ?>>
					<?php if (has_post_thumbnail()) : ?>
						<a class="cpt-archive-card__thumb-wrap" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large', ['class' => 'cpt-archive-card__thumb', 'loading' => 'lazy']); ?></a>
					<?php endif; ?>
					<div class="cpt-archive-card__body">
						<h2 class="cpt-archive-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="cpt-archive-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
						<a class="cpt-btn cpt-btn--outline cpt-btn--sm" href="<?php the_permalink(); ?>"><?php esc_html_e('Zobacz profil', 'generatepress-child-poradnik'); ?></a>
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
			<h2>Brak wpisów dla tej lokalizacji</h2>
			<p>Spróbuj wybrać inne miasto lub wróć do katalogu.</p>
			<a class="cpt-btn cpt-btn--primary" href="<?php echo esc_url(home_url('/specjalista/')); ?>">Przejdź do specjalistów</a>
		</div>
	<?php endif; ?>
</section>
<?php get_footer();
