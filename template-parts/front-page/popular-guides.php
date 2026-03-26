<section class="section">
  <div class="container">
    <?php poradnik_section_title('Popularne poradniki'); ?>
    <div class="grid grid-4">
      <?php
      $guidesQuery = new WP_Query([
          'post_type' => 'poradnik',
          'post_status' => 'publish',
          'posts_per_page' => 4,
          'orderby' => 'date',
          'order' => 'DESC',
          'no_found_rows' => true,
          'ignore_sticky_posts' => true,
          'update_post_meta_cache' => false,
          'update_post_term_cache' => false,
      ]);

      if ($guidesQuery->have_posts()) :
          while ($guidesQuery->have_posts()) : $guidesQuery->the_post();
      ?>
          <article class="card card-glossy">
            <p class="meta"><?php echo esc_html(poradnik_get_post_type_label((int) get_the_ID())); ?></p>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags((string) get_the_content()), 18)); ?></p>
            <div class="meta"><?php echo esc_html(get_the_date('j F Y')); ?></div>
            <a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Czytaj poradnik', 'generatepress-child-poradnik'); ?></a>
          </article>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
      ?>
        <article class="card card-glossy">
          <h3><?php esc_html_e('Brak poradników', 'generatepress-child-poradnik'); ?></h3>
          <p><?php esc_html_e('Dodaj pierwsze wpisy typu Poradnik, aby zasilić sekcję.', 'generatepress-child-poradnik'); ?></p>
          <a class="btn" href="<?php echo esc_url(home_url('/poradnik/')); ?>"><?php esc_html_e('Przejdź do archiwum', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php endif; ?>
    </div>
  </div>
</section>
