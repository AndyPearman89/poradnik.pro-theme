<?php
/* Template Name: SEO Jak Naprawić */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Landing SEO · Naprawy domowe</p>
		<h1>Jak naprawić awarię krok po kroku</h1>
		<p class="section-subtitle">Praktyczne scenariusze diagnozy i naprawy najczęstszych usterek: pralka, zmywarka, piekarnik, instalacja wodna i elektryczna.</p>
		<div class="hero-search">
			<a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalisci/')); ?>">Znajdź specjalistę</a>
			<a class="btn" href="<?php echo esc_url(home_url('/poradniki/')); ?>">Przeglądaj poradniki</a>
		</div>
	</div>
</section>

<section class="section">
	<div class="container grid grid-2">
		<article class="card">
			<h2>Szybka diagnoza</h2>
			<ul>
				<li>Objawy usterki i możliwe przyczyny</li>
				<li>Lista narzędzi i części zamiennych</li>
				<li>Ocena ryzyka i bezpieczeństwa</li>
			</ul>
		</article>
		<article class="card">
			<h2>Kiedy wezwać fachowca?</h2>
			<ul>
				<li>Awaria instalacji elektrycznej</li>
				<li>Wyciek, którego nie da się odciąć</li>
				<li>Powtarzający się błąd urządzenia</li>
			</ul>
		</article>
	</div>
</section>

<section class="section">
	<div class="container">
		<?php poradnik_section_title('Najczęściej wyszukiwane naprawy'); ?>
		<div class="grid grid-3">
			<a class="card" href="<?php echo esc_url(home_url('/hydraulika/')); ?>">Jak naprawić cieknący kran</a>
			<a class="card" href="<?php echo esc_url(home_url('/elektryka/')); ?>">Jak naprawić przepalony bezpiecznik</a>
			<a class="card" href="<?php echo esc_url(home_url('/mechanika/')); ?>">Jak zdiagnozować stuki w silniku</a>
		</div>
	</div>
</section>
<?php get_footer();
