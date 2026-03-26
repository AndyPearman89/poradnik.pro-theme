<section class="section">
  <div class="container">
    <?php poradnik_section_title('Najlepsze rankingi'); ?>
    <div class="grid grid-4">
      <?php
      $rankingsQuery = new WP_Query([
          'post_type' => 'ranking',
          'post_status' => 'publish',
          'posts_per_page' => 4,
          'orderby' => 'date',
          'order' => 'DESC',
          'no_found_rows' => true,
          'ignore_sticky_posts' => true,
          'update_post_meta_cache' => false,
          'update_post_term_cache' => false,
      ]);

      if ($rankingsQuery->have_posts()) :
          while ($rankingsQuery->have_posts()) : $rankingsQuery->the_post();
      ?>
        <article class="card card-glossy">
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="meta"><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags((string) get_the_content()), 16)); ?></p>
          <a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Zobacz ranking', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
      ?>
        <article class="card card-glossy">
          <h3><?php esc_html_e('Brak rankingów', 'generatepress-child-poradnik'); ?></h3>
          <p><?php esc_html_e('Sekcja automatycznie pokaże wpisy typu Ranking.', 'generatepress-child-poradnik'); ?></p>
          <a class="btn" href="<?php echo esc_url(home_url('/ranking/')); ?>"><?php esc_html_e('Archiwum rankingów', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php endif; ?>
    </div>
  </div>
</section>
