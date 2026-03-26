<?php
/* Template Name: Marketplace Specjaliści */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Marketplace · Zweryfikowani wykonawcy</p>
		<h1>Specjaliści dla domu, auta i biznesu</h1>
		<p class="section-subtitle">Porównuj profile, doświadczenie i opinie klientów. Wybieraj sprawdzonych ekspertów lokalnie.</p>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php get_template_part('template-parts/listing/listing', 'grid'); ?>
	</div>
</section>

<section class="section">
	<div class="container grid grid-3">
		<article class="card"><h2>Weryfikacja</h2><p>Profil specjalisty zawiera zakres usług, lokalizację i historię opinii.</p></article>
		<article class="card"><h2>Porównanie</h2><p>Sprawdź kilka ofert i wybierz najlepszy stosunek jakości do ceny.</p></article>
		<article class="card"><h2>Szybki kontakt</h2><p>Skorzystaj z formularza zapytania i odbierz ofertę dopasowaną do potrzeb.</p></article>
	</div>
</section>
<?php get_footer();
