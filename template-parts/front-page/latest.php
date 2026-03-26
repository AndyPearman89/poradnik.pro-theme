<section class="section">
  <div class="container">
    <?php poradnik_section_title('Najnowsze poradniki'); ?>
    <div class="article-list">
      <?php
      $latest = [
        'Jak przygotować mieszkanie do sezonu grzewczego?',
        'Cennik usług hydraulicznych 2026 — realne widełki',
        '7 błędów przy wyborze elektryka do remontu',
        'Najczęstsze awarie pralek i ich szybka diagnoza',
        'Jak negocjować wycenę usługi bez utraty jakości',
      ];

      foreach ($latest as $articleTitle) :
      ?>
        <article class="card">
          <h3><?php echo esc_html($articleTitle); ?></h3>
          <p class="meta">Nowy poradnik redakcyjny · aktualizacja: dziś</p>
          <a class="btn" href="<?php echo esc_url(home_url('/poradniki/')); ?>">Czytaj</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>