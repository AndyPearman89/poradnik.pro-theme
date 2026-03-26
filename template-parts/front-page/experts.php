<section class="section">
  <div class="container">
    <?php poradnik_section_title('Znajdź specjalistę'); ?>
    <div class="grid grid-3">
      <?php foreach (['Hydraulik','Mechanik','Elektryk','Prawnik','Doradca finansowy','Specjalista HVAC'] as $role) : ?>
        <article class="card">
          <h3><?php echo esc_html($role); ?></h3>
          <p class="meta">Zweryfikowane profile, jasne wyceny, szybki kontakt.</p>
          <a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>">Znajdź specjalistę</a>
        </article>
      <?php endforeach; ?>
    </div>
    <?php poradnik_section_title('Najlepsi specjaliści'); ?>
    <div class="cards-scroll">
      <?php
      $pros = [
        ['name' => 'Hydro-Serwis 24', 'meta' => 'Warszawa · Hydraulika', 'rating' => '★ 4.9'],
        ['name' => 'Volt Expert', 'meta' => 'Kraków · Elektryka', 'rating' => '★ 4.8'],
        ['name' => 'AutoDiag Plus', 'meta' => 'Wrocław · Mechanika', 'rating' => '★ 4.9'],
        ['name' => 'PrawoDom', 'meta' => 'Poznań · Prawo budowlane', 'rating' => '★ 4.7'],
      ];

      foreach ($pros as $pro) :
      ?>
        <article class="card">
          <h3><?php echo esc_html($pro['name']); ?></h3>
          <div class="rating"><?php echo esc_html($pro['rating']); ?></div>
          <p class="meta"><?php echo esc_html($pro['meta']); ?></p>
          <a class="btn" href="<?php echo esc_url(home_url('/specjalisci/')); ?>">Wyślij zapytanie</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
