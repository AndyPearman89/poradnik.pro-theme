<?php
/**
 * Premium Poradnik (Guide) Template v1.2.0
 */
if (!defined('ABSPATH')) {
    exit;
}

$is_premium = (bool) get_post_meta(get_the_ID(), '_poradnik_is_premium', true);
if (!$is_premium || !poradnik_is_user_premium()) {
    get_template_part('template-parts/content/single', 'poradnik');
    return;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('poradnik-premium'); ?>>
    <div class="premium-banner">🌟 Poradnik Premium</div>
    
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="entry-meta">
            <span class="author">By <?php the_author(); ?></span>
            <span class="date"><?php echo get_the_date(); ?></span>
            <span class="reading-time">Czas czytania: ~<?php echo ceil(str_word_count(get_the_content()) / 200); ?> min</span>
        </div>
    </header>

    <?php if (has_post_thumbnail()): ?>
        <figure class="featured-image">
            <?php the_post_thumbnail('full', ['class' => 'wp-post-image']); ?>
        </figure>
    <?php endif; ?>

    <div class="entry-content">
        <div class="toc">
            <h3>Spis treści</h3>
            <ul id="table-of-contents"></ul>
        </div>

        <?php the_content(); ?>

        <div class="premium-benefits">
            <h3>✓ Dodatki Premium w tym poradniku:</h3>
            <ul>
                <li>Szczegółowe krok po kroku instrukcje</li>
                <li>Ekskluzywne porady od specjalistów</li>
                <li>Nieograniczony dostęp do wszystkich materiałów dodatkowych</li>
                <li>Bezpłatne aktualizacje treści</li>
            </ul>
        </div>
    </div>

    <footer class="entry-footer">
        <div class="tags">
            <?php the_tags('<span class="tag">', '</span><span class="tag">', '</span>'); ?>
        </div>
    </footer>
</article>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const headings = document.querySelectorAll('.entry-content h2, .entry-content h3');
    const toc = document.getElementById('table-of-contents');
    headings.forEach((h, i) => {
        h.id = 'heading-' + i;
        const li = document.createElement('li');
        li.innerHTML = `<a href="#heading-${i}">${h.textContent}</a>`;
        toc.appendChild(li);
    });
});
</script>
