<section class="section">
  <div class="container">
    <?php poradnik_section_title('Najlepsze recenzje produktów'); ?>
    <div class="cards-scroll">
      <?php
      $reviews = [
        ['title' => 'Kocioł kondensacyjny X200', 'rating' => '★ 4.8', 'pros' => 'Niskie zużycie gazu, stabilna praca zimą'],
        ['title' => 'Zmywarka AquaSilent 8', 'rating' => '★ 4.7', 'pros' => 'Cicha praca, dobry serwis producenta'],
        ['title' => 'Pompa ciepła HeatPro', 'rating' => '★ 4.9', 'pros' => 'Wysoka sprawność, niski koszt eksploatacji'],
        ['title' => 'Odkurzacz przemysłowy MaxVac', 'rating' => '★ 4.6', 'pros' => 'Mocny silnik, trwała konstrukcja'],
      ];

      foreach ($reviews as $review) :
      ?>
        <article class="card">
          <h3><?php echo esc_html($review['title']); ?></h3>
          <div class="rating"><?php echo esc_html($review['rating']); ?></div>
          <p class="meta"><?php echo esc_html($review['pros']); ?></p>
          <a class="btn" href="<?php echo esc_url(home_url('/recenzje/')); ?>">Sprawdź recenzję</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>