<?php
/* Template Name: Login */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Konto · Logowanie</p>
		<h1>Zaloguj się do konta Poradnik.pro</h1>
		<p class="section-subtitle">Uzyskaj dostęp do zapisanych poradników, zapytań i narzędzi premium.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-2">
		<article class="card">
			<h2>Co zyskujesz po zalogowaniu</h2>
			<ul>
				<li>Historię pytań i odpowiedzi ekspertów</li>
				<li>Szybkie przejście do dashboardu konta</li>
				<li>Dostęp do treści i rankingów premium</li>
			</ul>
		</article>
		<article class="card">
			<h2>Nie masz konta?</h2>
			<p>Załóż darmowe konto i odblokuj pełny dostęp do narzędzi platformy.</p>
			<a class="btn btn-accent" href="<?php echo esc_url(home_url('/register/')); ?>">Przejdź do rejestracji</a>
		</article>
	</div>
</section>
<?php get_footer();
