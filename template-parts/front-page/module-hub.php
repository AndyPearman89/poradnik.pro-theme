<section class="section section-module-hub">
  <div class="container">
    <div class="module-hub-head">
      <h2 class="section-title"><?php esc_html_e('Centrum funkcji portalu', 'generatepress-child-poradnik'); ?></h2>
      <p class="section-subtitle"><?php esc_html_e('Pełny stack modułów PearTree: od SEO po leady, mapy i booking.', 'generatepress-child-poradnik'); ?></p>
    </div>

    <div class="module-hub-grid">
      <?php
      $modules = [
          ['name' => 'Listings Engine', 'desc' => 'Katalog i filtry treści', 'url' => home_url('/poradnik/')],
          ['name' => 'Leads Engine', 'desc' => 'Pozyskiwanie i routing leadów', 'url' => home_url('/specjalista/')],
          ['name' => 'Claim Engine', 'desc' => 'Weryfikacja i claim treści', 'url' => home_url('/pytanie/')],
          ['name' => 'Weather Engine', 'desc' => 'Dane pogodowe i alerty', 'url' => home_url('/poradnik/')],
          ['name' => 'Map Engine', 'desc' => 'Widok mapowy i lokalizacje', 'url' => home_url('/specjalista/')],
          ['name' => 'Booking Engine', 'desc' => 'Obsługa rezerwacji premium', 'url' => home_url('/produkt/')],
          ['name' => 'Sponsored / Ads', 'desc' => 'Monetyzacja powierzchni', 'url' => home_url('/reklama/')],
          ['name' => 'Programmatic SEO', 'desc' => 'Skalowanie landing pages', 'url' => home_url('/ranking/')],
      ];

      foreach ($modules as $module) :
      ?>
        <article class="module-card card">
          <h3><?php echo esc_html($module['name']); ?></h3>
          <p><?php echo esc_html($module['desc']); ?></p>
          <a class="btn btn-module" href="<?php echo esc_url($module['url']); ?>"><?php esc_html_e('Przejdź', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
