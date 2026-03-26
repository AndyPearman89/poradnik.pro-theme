<?php
/* Template Name: Register */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Konto · Rejestracja</p>
		<h1>Załóż konto i korzystaj z funkcji premium</h1>
		<p class="section-subtitle">Buduj listy poradników, porównuj oferty i szybciej podejmuj decyzje zakupowe.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-3">
		<article class="card"><h2>Personalizacja</h2><p>Dobieraj treści i rekomendacje pod Twoje potrzeby.</p></article>
		<article class="card"><h2>Oszczędność czasu</h2><p>Zapisuj porównania oraz wyniki rankingów w jednym miejscu.</p></article>
		<article class="card"><h2>Lepsze decyzje</h2><p>Korzystaj z opinii, danych i checklist ekspertów.</p></article>
	</div>
</section>

<section class="section">
	<div class="container card">
		<h2>Masz już konto?</h2>
		<p>Przejdź do logowania i kontynuuj pracę z zapisanymi materiałami.</p>
		<a class="btn" href="<?php echo esc_url(home_url('/login/')); ?>">Zaloguj się</a>
	</div>
</section>
<?php get_footer();
