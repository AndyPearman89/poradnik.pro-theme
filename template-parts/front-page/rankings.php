<section class="section">
  <div class="container">
    <?php poradnik_section_title('Najlepsze rankingi'); ?>
    <div class="grid grid-4">
      <?php
      $rankings = [
        ['title' => 'Ranking hydraulików 2026', 'meta' => 'Top 3: czas reakcji, cena, opinie klientów', 'url' => home_url('/ranking/')],
        ['title' => 'Ranking elektryków w Twoim mieście', 'meta' => 'Top 3: certyfikacje, SLA, transparentność wycen', 'url' => home_url('/elektryka/')],
        ['title' => 'Ranking pieców i kotłów gazowych', 'meta' => 'Top 3: efektywność, koszty utrzymania, serwis', 'url' => home_url('/najlepszy-produkt/')],
        ['title' => 'Ranking polis i pakietów assistance', 'meta' => 'Top 3: zakres ochrony, wyłączenia, cena', 'url' => home_url('/finanse/')],
      ];

      foreach ($rankings as $ranking) :
      ?>
        <article class="card">
          <h3><?php echo esc_html($ranking['title']); ?></h3>
          <p class="meta"><?php echo esc_html($ranking['meta']); ?></p>
          <a class="btn" href="<?php echo esc_url($ranking['url']); ?>">Zobacz ranking</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
