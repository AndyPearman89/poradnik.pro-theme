<section class="section">
  <div class="container">
    <?php poradnik_section_title('Znajdź specjalistę'); ?>
    <div class="grid grid-3">
      <?php foreach (['Hydraulik','Mechanik','Elektryk','Prawnik','Doradca finansowy','Specjalista HVAC'] as $role) : ?>
        <article class="card card-glossy">
          <h3><?php echo esc_html($role); ?></h3>
          <p class="meta">Zweryfikowane profile, jasne wyceny, szybki kontakt.</p>
          <a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>">Znajdź specjalistę</a>
        </article>
      <?php endforeach; ?>
    </div>
    <?php poradnik_section_title('Najlepsi specjaliści'); ?>
    <div class="cards-scroll">
      <?php
      $specialistsQuery = new WP_Query([
          'post_type' => 'specjalista',
          'post_status' => 'publish',
          'posts_per_page' => 6,
          'orderby' => 'date',
          'order' => 'DESC',
      ]);

      if ($specialistsQuery->have_posts()) :
          while ($specialistsQuery->have_posts()) : $specialistsQuery->the_post();
      ?>
        <article class="card card-glossy">
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <div class="rating">★ <?php echo esc_html((string) number_format_i18n((float) rand(45, 50) / 10, 1)); ?></div>
          <p class="meta"><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags((string) get_the_content()), 12)); ?></p>
          <a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Wyślij zapytanie', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
      ?>
        <article class="card card-glossy">
          <h3><?php esc_html_e('Brak profili specjalistów', 'generatepress-child-poradnik'); ?></h3>
          <p><?php esc_html_e('Sekcja automatycznie pokaże wpisy typu Specjalista.', 'generatepress-child-poradnik'); ?></p>
          <a class="btn" href="<?php echo esc_url(home_url('/specjalisci/')); ?>"><?php esc_html_e('Przejdź do katalogu', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php endif; ?>
    </div>
  </div>
</section>
