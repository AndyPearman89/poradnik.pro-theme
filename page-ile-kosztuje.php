<?php
/* Template Name: SEO Ile Kosztuje */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Landing SEO · Cennik usług</p>
		<h1>Ile kosztuje usługa? Sprawdź realne widełki</h1>
		<p class="section-subtitle">Porównanie stawek rynkowych, kosztów materiałów i wariantów robocizny dla najpopularniejszych prac.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-3">
		<article class="card"><h2>Hydraulik</h2><p>Od 180 do 450 zł za wizytę, zależnie od pory i zakresu prac.</p></article>
		<article class="card"><h2>Elektryk</h2><p>Od 220 do 600 zł za podstawowe prace instalacyjne.</p></article>
		<article class="card"><h2>Mechanik</h2><p>Roboczogodzina od 170 do 380 zł w zależności od miasta.</p></article>
	</div>
</section>

<section class="section">
	<div class="container card">
		<h2>Co wpływa na cenę?</h2>
		<ul>
			<li>Miasto i dostępność wykonawców</li>
			<li>Pilność realizacji i termin nocny/weekendowy</li>
			<li>Zakres prac oraz koszt materiałów</li>
		</ul>
		<a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>">Poproś o wycenę</a>
	</div>
</section>
<?php get_footer();
