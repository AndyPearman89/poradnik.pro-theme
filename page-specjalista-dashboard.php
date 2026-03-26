<?php
/* Template Name: Specjalista Dashboard */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Strefa specjalisty · Performance</p>
		<h1>Dashboard specjalisty</h1>
		<p class="section-subtitle">Zarządzaj leadami, ofertami i skutecznością profilu z jednego miejsca.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-3">
		<article class="card"><h2>Nowe leady</h2><p>Priorytetyzuj zapytania według lokalizacji i budżetu.</p></article>
		<article class="card"><h2>Konwersja</h2><p>Monitoruj skuteczność odpowiedzi i czas reakcji zespołu.</p></article>
		<article class="card"><h2>Rekomendacje</h2><p>Wdrażaj podpowiedzi poprawiające wynik profilu i ofert.</p></article>
	</div>
</section>

<section class="section">
	<div class="container card">
		<h2>Szybkie akcje</h2>
		<p>Przejdź bezpośrednio do najważniejszych obszarów operacyjnych.</p>
		<div class="landing-actions">
			<a class="btn" href="<?php echo esc_url(home_url('/specjalista-leady/')); ?>">Przeglądaj leady</a>
			<a class="btn" href="<?php echo esc_url(home_url('/specjalista-profil/')); ?>">Edytuj profil</a>
		</div>
	</div>
</section>
<?php get_footer();
