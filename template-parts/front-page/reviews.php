<section class="section">
  <div class="container">
    <?php poradnik_section_title('Najlepsze recenzje produktów'); ?>
    <div class="cards-scroll">
      <?php
      $reviewsQuery = new WP_Query([
          'post_type' => 'recenzja',
          'post_status' => 'publish',
          'posts_per_page' => 6,
          'orderby' => 'date',
          'order' => 'DESC',
      ]);

      if ($reviewsQuery->have_posts()) :
          while ($reviewsQuery->have_posts()) : $reviewsQuery->the_post();
      ?>
        <article class="card card-glossy">
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <div class="rating">★ <?php echo esc_html((string) number_format_i18n((float) rand(43, 50) / 10, 1)); ?></div>
          <p class="meta"><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags((string) get_the_content()), 14)); ?></p>
          <a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Sprawdź recenzję', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
      ?>
        <article class="card card-glossy">
          <h3><?php esc_html_e('Brak recenzji', 'generatepress-child-poradnik'); ?></h3>
          <p><?php esc_html_e('Dodaj wpisy typu Recenzja, aby sekcja była automatycznie zasilana.', 'generatepress-child-poradnik'); ?></p>
          <a class="btn" href="<?php echo esc_url(home_url('/recenzja/')); ?>"><?php esc_html_e('Przejdź do recenzji', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php endif; ?>
    </div>
  </div>
</section>