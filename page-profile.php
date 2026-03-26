<?php
/* Template Name: Profile */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Konto · Centrum użytkownika</p>
		<h1>Twój profil</h1>
		<p class="section-subtitle">Zarządzaj ustawieniami konta, historią aktywności i zapisanymi poradnikami.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-2">
		<article class="card">
			<h2>Najważniejsze sekcje</h2>
			<ul>
				<li>Dane konta i preferencje</li>
				<li>Zapisane poradniki i rankingi</li>
				<li>Historia pytań i odpowiedzi ekspertów</li>
			</ul>
		</article>
		<article class="card">
			<h2>Szybkie przejścia</h2>
			<p>Przejdź do sekcji, które używasz najczęściej.</p>
			<div class="landing-actions">
				<a class="btn" href="<?php echo esc_url(home_url('/my-guides/')); ?>">Moje poradniki</a>
				<a class="btn" href="<?php echo esc_url(home_url('/my-questions/')); ?>">Moje pytania</a>
			</div>
		</article>
	</div>
</section>
<?php get_footer();
