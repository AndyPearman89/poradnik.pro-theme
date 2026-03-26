<section class="section">
  <div class="container">
    <?php poradnik_section_title('Najnowsze poradniki'); ?>
    <div class="article-list">
      <?php
      $latestQuery = new WP_Query([
          'post_type' => ['poradnik', 'ranking', 'recenzja'],
          'post_status' => 'publish',
          'posts_per_page' => 5,
          'orderby' => 'date',
          'order' => 'DESC',
          'no_found_rows' => true,
          'ignore_sticky_posts' => true,
          'update_post_meta_cache' => false,
          'update_post_term_cache' => false,
      ]);

      if ($latestQuery->have_posts()) :
          while ($latestQuery->have_posts()) : $latestQuery->the_post();
      ?>
        <article class="card card-glossy">
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="meta"><?php echo esc_html(poradnik_get_post_type_label((int) get_the_ID()) . ' · ' . get_the_date('j F Y')); ?></p>
          <a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Czytaj', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
      ?>
        <article class="card card-glossy">
          <h3><?php esc_html_e('Brak najnowszych wpisów', 'generatepress-child-poradnik'); ?></h3>
          <p><?php esc_html_e('Dodaj publikacje, aby zasilić feed aktualności.', 'generatepress-child-poradnik'); ?></p>
        </article>
      <?php endif; ?>
    </div>
  </div>
</section>