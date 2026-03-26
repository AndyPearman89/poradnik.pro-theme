<section class="section landing-hero portal-hero">
  <div class="container portal-hero__grid">
    <div>
      <p class="meta"><?php esc_html_e('Poradnik.pro • portal ekspertów', 'generatepress-child-poradnik'); ?></p>
      <h1 class="portal-hero__title"><?php esc_html_e('Najlepsze poradniki, rankingi i specjaliści w jednym miejscu', 'generatepress-child-poradnik'); ?></h1>
      <p class="section-subtitle"><?php esc_html_e('Szukaj rozwiązań realnych problemów, porównuj oferty i kontaktuj się ze sprawdzonymi fachowcami lokalnie.', 'generatepress-child-poradnik'); ?></p>
      <form class="hero-search search-sticky" data-sticky-search data-hero-search-form action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <input type="search" name="s" placeholder="Wpisz pytanie lub usługę, np. wymiana instalacji" aria-label="Wpisz pytanie" />
        <button class="btn" type="submit"><?php esc_html_e('Szukaj', 'generatepress-child-poradnik'); ?></button>
      </form>
      <div class="landing-actions">
        <a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>"><?php esc_html_e('Znajdź specjalistę', 'generatepress-child-poradnik'); ?></a>
        <a class="btn" href="<?php echo esc_url(home_url('/poradnik/')); ?>"><?php esc_html_e('Przeglądaj poradniki', 'generatepress-child-poradnik'); ?></a>
      </div>
      <div class="tag-list" aria-label="Popular topics">
        <?php foreach (['Hydraulika', 'Elektryka', 'Finanse', 'Prawo', 'Mechanika', 'Remont'] as $topic) : ?>
          <span class="tag"><?php echo esc_html($topic); ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <aside class="portal-hero__panel card">
      <h3><?php esc_html_e('Szybki start', 'generatepress-child-poradnik'); ?></h3>
      <ul class="portal-hero__list">
        <li><a href="<?php echo esc_url(home_url('/elektryka/')); ?>"><?php esc_html_e('Elektryka', 'generatepress-child-poradnik'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/hydraulika/')); ?>"><?php esc_html_e('Hydraulika', 'generatepress-child-poradnik'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/ranking/')); ?>"><?php esc_html_e('Rankingi usług', 'generatepress-child-poradnik'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/ile-kosztuje/')); ?>"><?php esc_html_e('Ile to kosztuje?', 'generatepress-child-poradnik'); ?></a></li>
      </ul>
    </aside>
  </div>
</section>
