<section class="section">
  <div class="container">
    <?php poradnik_section_title('Popularne poradniki'); ?>
    <div class="grid grid-4">
      <?php
      $guides = [
        ['title' => 'Jak naprawić pralkę, która nie odprowadza wody?', 'category' => 'Dom i ogród', 'desc' => 'Diagnoza krok po kroku: filtr, pompa, odpływ i reset serwisowy.', 'time' => '7 min czytania', 'url' => home_url('/jak-naprawic/')],
        ['title' => 'Ile kosztuje wymiana instalacji elektrycznej?', 'category' => 'Elektryka', 'desc' => 'Przedziały cenowe, czynniki kosztu i checklista przed wyceną.', 'time' => '8 min czytania', 'url' => home_url('/ile-kosztuje/')],
        ['title' => 'Jak wybrać hydraulika bez przepłacania?', 'category' => 'Hydraulika', 'desc' => 'Porównanie ofert, standard SLA i sygnały ostrzegawcze.', 'time' => '6 min czytania', 'url' => home_url('/hydraulika/')],
        ['title' => 'Ranking pieców gazowych 2026', 'category' => 'Ranking', 'desc' => 'Zestawienie modeli, koszty eksploatacji i trwałość podzespołów.', 'time' => '9 min czytania', 'url' => home_url('/ranking/')],
      ];

      foreach ($guides as $guide) :
      ?>
        <article class="card">
          <p class="meta"><?php echo esc_html($guide['category']); ?></p>
          <h3><?php echo esc_html($guide['title']); ?></h3>
          <p><?php echo esc_html($guide['desc']); ?></p>
          <div class="meta"><?php echo esc_html($guide['time']); ?></div>
          <a class="btn" href="<?php echo esc_url($guide['url']); ?>">Czytaj poradnik</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
