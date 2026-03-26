<section class="section">
  <div class="container">
    <?php poradnik_section_title('Popularne problemy'); ?>
    <div class="grid grid-3">
      <?php
      $seoLinks = [
        ['label' => 'Jak naprawić pralkę', 'url' => home_url('/jak-naprawic/')],
        ['label' => 'Ile kosztuje hydraulik', 'url' => home_url('/ile-kosztuje/')],
        ['label' => 'Ranking elektryków 2026', 'url' => home_url('/ranking/')],
        ['label' => 'Najlepszy piec gazowy', 'url' => home_url('/najlepszy-produkt/')],
        ['label' => 'Usługa w Twoim mieście', 'url' => home_url('/usluga-miasto/')],
      ];

      foreach ($seoLinks as $seoLink) :
      ?>
        <a class="card" href="<?php echo esc_url($seoLink['url']); ?>"><?php echo esc_html($seoLink['label']); ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>