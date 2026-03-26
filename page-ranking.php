<?php
/* Template Name: SEO Ranking */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Landing SEO · Rankingi</p>
		<h1>Ranking usług i produktów 2026</h1>
		<p class="section-subtitle">Porównujemy oferty według ceny, jakości wykonania, terminowości i opinii klientów.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-3">
		<article class="card"><h2>Hydraulika</h2><p>Top wykonawcy w największych miastach i benchmark cen.</p></article>
		<article class="card"><h2>Elektryka</h2><p>Porównanie certyfikacji, stawek i jakości obsługi.</p></article>
		<article class="card"><h2>Urządzenia AGD</h2><p>Recenzje i ranking produktów najczęściej kupowanych.</p></article>
	</div>
</section>

<section class="section">
	<div class="container card">
		<h2>Kryteria rankingu</h2>
		<p>Każdy wpis oceniamy w modelu punktowym: koszt całkowity, jakość, SLA, transparentność i satysfakcja klientów.</p>
		<a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>">Porównaj specjalistów</a>
	</div>
</section>
<?php get_footer();
