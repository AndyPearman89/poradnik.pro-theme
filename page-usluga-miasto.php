<?php
/* Template Name: SEO Usługa Miasto */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Landing SEO · Lokalnie</p>
		<h1>Usługa w Twoim mieście</h1>
		<p class="section-subtitle">Znajdź lokalnych wykonawców, porównaj oferty i wybierz najlepszy termin realizacji.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-3">
		<article class="card"><h2>Warszawa</h2><p>Największa baza specjalistów i szybkie terminy realizacji.</p></article>
		<article class="card"><h2>Kraków</h2><p>Sprawdzone profile i rozbudowane opinie klientów.</p></article>
		<article class="card"><h2>Wrocław</h2><p>Konkurencyjne stawki i krótkie czasy dojazdu.</p></article>
	</div>
</section>

<section class="section">
	<div class="container card">
		<h2>Jak wybrać fachowca lokalnie?</h2>
		<ol>
			<li>Porównaj minimum 3 oferty i zakres prac.</li>
			<li>Zweryfikuj opinie, zdjęcia realizacji i SLA.</li>
			<li>Ustal koszt całkowity przed rozpoczęciem.</li>
		</ol>
		<a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>">Przejdź do katalogu specjalistów</a>
	</div>
</section>
<?php get_footer();
