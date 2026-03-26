<section class="section section-module-hub">
  <div class="container">
    <div class="module-hub-head">
      <h2 class="section-title"><?php esc_html_e('Centrum funkcji portalu', 'generatepress-child-poradnik'); ?></h2>
      <p class="section-subtitle"><?php esc_html_e('Pełny stack modułów PearTree: od SEO po leady, mapy i booking.', 'generatepress-child-poradnik'); ?></p>
    </div>

    <div class="module-hub-grid">
      <?php
      $statusData = function_exists('poradnik_get_module_statuses') ? poradnik_get_module_statuses(false) : ['items' => []];
      $moduleStatusByName = [];
      if (isset($statusData['items']) && is_array($statusData['items'])) {
        foreach ($statusData['items'] as $item) {
          $moduleStatusByName[$item['name']] = $item;
        }
      }

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
        $statusName = str_replace(' Engine', '', $module['name']);
        $statusItem = $moduleStatusByName[$statusName] ?? null;
        $statusClass = !empty($statusItem['online']) ? 'is-online' : 'is-offline';
        $statusLabel = !empty($statusItem['online'])
          ? esc_html__('API online', 'generatepress-child-poradnik')
          : esc_html__('API offline', 'generatepress-child-poradnik');
      ?>
        <article class="module-card card">
          <span class="module-status-badge <?php echo esc_attr($statusClass); ?>"><?php echo esc_html($statusLabel); ?></span>
          <h3><?php echo esc_html($module['name']); ?></h3>
          <p><?php echo esc_html($module['desc']); ?></p>
          <?php if ($statusItem && isset($statusItem['status_code']) && (int) $statusItem['status_code'] > 0) : ?>
            <p class="module-status-code"><?php echo esc_html('HTTP ' . (int) $statusItem['status_code']); ?></p>
          <?php endif; ?>
          <a class="btn btn-module" href="<?php echo esc_url($module['url']); ?>"><?php esc_html_e('Przejdź', 'generatepress-child-poradnik'); ?></a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
