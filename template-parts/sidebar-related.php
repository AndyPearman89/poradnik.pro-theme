<?php
/**
 * Sidebar - Related Content (v1.2.0)
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<aside class="sidebar sidebar-secondary">
    <div class="sidebar-widget">
        <h3>Powiązana zawartość</h3>
        <?php
        $current_id = get_the_ID();
        $current_cats = wp_get_post_terms($current_id, 'kategoria', ['fields' => 'ids']);
        
        $related = new WP_Query([
            'post_type' => get_post_type(),
            'post__not_in' => [$current_id],
            'tax_query' => [
                [
                    'taxonomy' => 'kategoria',
                    'field' => 'term_id',
                    'terms' => $current_cats,
                ]
            ],
            'posts_per_page' => 5,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        if ($related->have_posts()): ?>
            <ul class="related-list">
                <?php while ($related->have_posts()): $related->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                        <?php if (get_post_meta(get_the_ID(), '_poradnik_is_premium', true)): ?>
                            <span class="premium-badge-small">⭐</span>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif;
        wp_reset_postdata();
        ?>
    </div>

    <div class="sidebar-widget">
        <h3>Popularne tagi</h3>
        <?php wp_tag_cloud(['post_type' => get_post_type(), 'number' => 10]); ?>
    </div>

    <?php if (is_user_logged_in() && current_user_can('edit_post', $current_id)): ?>
        <div class="sidebar-widget editor-widget">
            <h3>Redakcja</h3>
            <ul>
                <li><a href="<?php echo esc_url(get_edit_post_link()); ?>">Edytuj zawartość</a></li>
                <?php if (poradnik_is_user_premium()): ?>
                    <li><a href="#">Opcje Premium</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
</aside>
